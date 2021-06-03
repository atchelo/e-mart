<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Auth;
use Session;
use App\Coupan;
use App\Cart;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class CouponApplyController extends Controller
{
    public function apply(Request $request)
    {

        $cpn = Coupan::where('code', '=', $request->coupon)
            ->first();

        if(!isset($cpn)){
            Cart::where('user_id', Auth::user()->id)
                        ->update(['distype' => NULL, 'disamount' => NULL,'coupan_id' => NULL]);
            return back()->with('fail','Invalid Coupan !');
        }

        if ($cpn->is_login == 1)
        {
            if (!Auth::check())
            {
                notify()->error('Login or signup to use this coupon !');
                return back();
            }
        }

        if (isset($cpn))
        {

            $today = date('Y-m-d');

            if (date('Y-m-d', strtotime($cpn->expirydate)) >= $today)
            {

                if ($cpn->maxusage != 0)
                {

                    if ($cpn->link_by == 'product')
                    {

                        return $this->validCouponForProduct($cpn);

                    }
                    elseif ($cpn->link_by == 'cart')
                    {

                        return $this->validCouponForCart($cpn);

                    }
                    elseif ($cpn->link_by == 'category')
                    {

                        return $this->validCouponForCategory($cpn);

                    }

                }
                else
                {
                    Session::forget('coupanapplied');
                    Cart::where('user_id', Auth::user()->id)
                        ->update(['distype' => NULL, 'disamount' => NULL,'coupan_id' => NULL]);
                    return back()
                        ->with('fail', 'Coupan code max usage limit reached !');
                }

            }
            else
            {
                Session::forget('coupanapplied');
                Cart::where('user_id', Auth::user()
                    ->id)
                    ->update(['distype' => NULL, 'disamount' => NULL, 'coupan_id' => NULL]);
                return back()
                    ->with('fail', 'Coupan code is expired !');
            }

        }
        else
        {
            Session::forget('coupanapplied');
            Cart::where('user_id', Auth::user()
                ->id)
                ->update(['distype' => NULL, 'disamount' => NULL, 'coupan_id' => NULL]);
            return back()
                ->with('fail', 'Coupan code is invalid');
        }

    }

    public function validCouponForProduct($cpn)
    {

        if (Auth::check())
        {
            $cart = Cart::where('pro_id', '=', $cpn['pro_id'])->where('user_id', '=', Auth::user()
                ->id)
                ->first();
            $carts = Cart::where('user_id', '=', Auth::user()->id)
                ->get();
            $per = 0;

            if (isset($cart))
            {

                if ($cart->pro_id == $cpn->pro_id)
                {

                    if ($cart->semi_total != 0)
                    {

                        if ($cpn->distype == 'per')
                        {

                            $per = $cart->semi_total * $cpn->amount / 100;

                        }
                        else
                        {

                            $per = $cpn->amount;
                        }

                    }
                    else
                    {

                        if ($cpn->distype == 'per')
                        {
                            $per = $cart->price_total * $cpn->amount / 100;
                        }
                        else
                        {
                            $per = $cpn->amount;
                        }

                    }

                    Cart::where('pro_id', '=', $cpn['pro_id'])->where('user_id', '=', Auth::user()
                        ->id)
                        ->update(['distype' => 'product', 'disamount' => $per, 'coupan_id' => $cpn->id]);
                    Cart::where('pro_id', '!=', $cpn['pro_id'])->where('user_id', '=', Auth::user()
                        ->id)
                        ->update(['distype' => NULL, 'disamount' => NULL, 'coupan_id' => NULL]);

                    return back();

                }
                else
                {
                    Cart::where('user_id', '=', Auth::user()
                        ->id)
                        ->update(['distype' => NULL, 'disamount' => NULL, 'coupan_id' => NULL]);
                    return back()
                        ->with('fail', 'Sorry no product found in your cart for this coupon !');
                }

            }
            else
            {
                Cart::where('user_id', '=', Auth::user()
                        ->id)
                        ->update(['distype' => NULL, 'disamount' => NULL, 'coupan_id' => NULL]);
                return back()
                    ->with('fail', 'Sorry no product found in your cart for this coupon !');
            }
        }
        else
        {

            $cart = Session::get('cart');
            $per = 0;
            $notavbl = 0;
            foreach ($cart as $key => $c)
            {

                if ($c['pro_id'] == $cpn->pro_id)
                {

                    if ($cart[$key]['varofferprice'] != 0)
                    {

                        if ($cpn->distype == 'per')
                        {
                            $per = ($cart[$key]['varofferprice'] * $cart[$key]['qty']) * $cpn->amount / 100;
                        }
                        else
                        {
                            $per = $cpn->amount;
                        }

                    }
                    else
                    {

                        if ($cpn->distype == 'per')
                        {
                            $per = ($cart[$key]['varprice'] * $cart[$key]['qty']) * $cpn->amount / 100;
                        }
                        else
                        {
                            $per = $cpn->amount;
                        }

                    }

                    $cart[$key]['discount'] = $per;
                    $cart[$key]['distype'] = 'product';

                    Session::put('cart', $cart);

                    Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'discount' => $per, 'msg' => "$cpn->code Applied Successfully !", 'appliedOn' => 'product']);
                    return back();

                }
                else
                {

                    $notavbl = 1;

                }

            }

            if ($notavbl == 1)
            {
                return back()->with('fail', 'Sorry no product found in your cart for this coupon !');
            }

        }
    }

    public function validCouponForCart($cpn)
    {
        require_once 'price.php';

        if (Auth::check())
        {
            
            $cart = Cart::where('user_id', '=', Auth::user()->id)
                ->get();

            $total = 0;

            if (isset($cart))
            {

                foreach ($cart as $key => $c)
                {
                    if ($c->semi_total != 0)
                    {
                        $total = $total + $c->semi_total;
                    }
                    else
                    {
                        $total = $total + $c->price_total;
                    }
                }

                $total = $total + Session::get('shippingrate');

                if ($cpn->minamount != 0)
                {

                   
                 
                    if ($total*$conversion_rate >= $cpn->minamount*$conversion_rate)
                    {   
                        
                        //check cart amount  //
                        $totaldiscount = 0;

                        foreach ($cart as $key => $c)
                        {

                            $per = 0;

                            if ($cpn->distype == 'per')
                            {

                                if ($c->semi_total != 0)
                                {
                                    $per = $c->semi_total * $cpn->amount / 100;
                                    $totaldiscount = $totaldiscount + $per;
                                }
                                else
                                {
                                    $per = $c->price_total * $cpn->amount / 100;
                                    $totaldiscount = $totaldiscount + $per;
                                }

                            }
                            else
                            {

                                if ($c->semi_total != 0)
                                {
                                    $per = $cpn->amount / count($cart);
                                    $totaldiscount = $totaldiscount + $per;
                                }
                                else
                                {
                                    $per = $cpn->amount / count($cart);
                                    $totaldiscount = $totaldiscount + $per;
                                }

                            }

                            Cart::where('user_id', Auth::user()->id)
                                ->update(['distype' => 'cart', 'disamount' => $per, 'coupan_id' => $cpn->id]);

                        }


                        //end return success with discounted amount
                        return back();
                    }
                    else
                    {
                        Cart::where('user_id', '=', Auth::user()
                        ->id)
                        ->update(['distype' => NULL, 'disamount' => NULL, 'coupan_id' => NULL]);
                        
                        return back()
                            ->with('fail', 'For Apply this coupon your cart total should be ' . sprintf("%.2f",$cpn->minamount * $conversion_rate) . ' or greater !');
                    }

                }
                else
                {

                    //check cart amount  //
                    $totaldiscount = 0;
                    $per = 0;

                    foreach ($cart as $key => $c)
                    {

                        if ($cpn->distype == 'per')
                        {

                            if ($c->semi_total != 0)
                            {
                                $per = $c->semi_total * $cpn->amount / 100;
                                $totaldiscount = $totaldiscount + $per;
                            }
                            else
                            {
                                $per = $c->price_total * $cpn->amount / 100;
                                $totaldiscount = $totaldiscount + $per;
                            }

                        }
                        else
                        {

                            if ($c->semi_total != 0)
                            {
                                $per = $cpn->amount / count($cart);
                                $totaldiscount = $totaldiscount + $per;
                            }
                            else
                            {
                                $per = $cpn->amount / count($cart);
                                $totaldiscount = $totaldiscount + $per;
                            }

                        }

                        Cart::where('id', '=', $c->id)
                            ->update(['distype' => 'cart', 'disamount' => $per, 'coupan_id' => $cpn->id]);

                    }


                    //end return success with discounted amount
                    return back();

                }

            }

        }
        else
        {
            
            $cart = Session::get('cart');
            $totaldiscount = 0;
            $total = 0;

            foreach ($cart as $key => $c)
            {
                if ($c['varofferprice'] != 0)
                {
                    $total = $total + $c['varofferprice'];
                }
                else
                {
                    $total = $total + $c['varprice'];
                }
            }

            //check cart amount  //
            $totaldiscount = 0;

            $total = $total + Session::get('shippingrate');

            if ($cpn->minamount != 0)
            {
                if ($total*$conversion_rate >= $cpn->minamount*$conversion_rate)
                {
                    
                    $per = 0;

                    if ($cpn->distype == 'per')
                    {

                        if ($c['varofferprice'] != 0)
                        {
                            $per = ($c['varofferprice'] * $c['qty']) * $cpn->amount / 100;
                            $totaldiscount = $totaldiscount + $per;
                        }
                        else
                        {
                            $per = ($c['varprice'] * $c['qty']) * $cpn->amount / 100;
                            $totaldiscount = $totaldiscount + $per;
                        }

                    }
                    else
                    {

                        if ($c['varofferprice'] != 0)
                        {
                            $per = $cpn->amount / count($cart);
                            $totaldiscount = $totaldiscount + $per;
                        }
                        else
                        {
                            $per = $cpn->amount / count($cart);
                            $totaldiscount = $totaldiscount + $per;
                        }

                    }

                    

                    //UPDATE Session row //
                    $cart[$key]['discount'] = $per;
                    $cart[$key]['distype'] = 'cart';
                    Session::put('cart', $cart);
                    // END //
                    Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'discount' => $totaldiscount, 'msg' => "$cpn->code Applied Successfully !", 'appliedOn' => 'cart']);

                    //end return success with discounted amount
                    return back();

                }
                else
                {
                    return back()
                        ->with('fail', 'For Apply this coupon your cart total should be ' . sprintf("%.2f",$cpn->minamount * $conversion_rate) . ' or greater !');
                }
            }
            else
            {

                foreach ($cart as $key => $c)
                {
                    $per = 0;

                    if ($cpn->distype == 'per')
                    {

                        if ($c['varofferprice'] != 0)
                        {
                            $per = ($c['varofferprice'] * $c['qty']) * $cpn->amount / 100;
                            $totaldiscount = $totaldiscount + $per;
                        }
                        else
                        {
                            $per = ($c['varprice'] * $c['qty']) * $cpn->amount / 100;
                            $totaldiscount = $totaldiscount + $per;
                        }

                    }
                    else
                    {

                        if ($c['varofferprice'] != 0)
                        {
                            $per = $cpn->amount / count($cart);
                            $totaldiscount = $totaldiscount + $per;
                        }
                        else
                        {
                            $per = $cpn->amount / count($cart);
                            $totaldiscount = $totaldiscount + $per;
                        }

                    }

                    //UPDATE Session row //
                    $cart[$key]['discount'] = $per;
                    $cart[$key]['distype'] = 'cart';
                    Session::put('cart', $cart);
                    // END //
                    
                }

                //Putting a session//
                Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'discount' => $totaldiscount, 'msg' => "$cpn->code Applied Successfully !", 'appliedOn' => 'cart']);

                //end return success with discounted amount
                return back();
            }

        }

    }

    public function validCouponForCategory($cpn)
    {
        require_once ('price.php');

        if (Auth::check())
        {
            $cart = Cart::where('user_id', '=', Auth::user()->id)
                ->get();
            $catcart = collect();

            foreach ($cart as $row)
            {

                if ($row
                    ->product
                    ->category->id == $cpn->cat_id)
                {
                    $catcart->push($row);
                }

            }

            if (count($catcart) > 0)
            {

                $total = 0;
                $totaldiscount = 0;

                foreach ($catcart as $key => $row)
                {
                    if ($row->semi_total != 0)
                    {
                        $total = $total + $row->semi_total;
                    }
                    else
                    {
                        $total = $total + $row->price_total;
                    }
                }

                foreach ($catcart as $key => $c)
                {

                    $per = 0;

                    if ($cpn->distype == 'per')
                    {

                        if ($c->semi_total != 0)
                        {
                            $per = $c->semi_total * $cpn->amount / 100;
                            $totaldiscount = $totaldiscount + $per;
                        }
                        else
                        {
                            $per = $c->price_total * $cpn->amount / 100;
                            $totaldiscount = $totaldiscount + $per;
                        }

                    }
                    else
                    {

                        if ($c->semi_total != 0)
                        {
                            $per = $cpn->amount / count($catcart);
                            $totaldiscount = $totaldiscount + $per;
                        }
                        else
                        {
                            $per = $cpn->amount / count($catcart);
                            $totaldiscount = $totaldiscount + $per;
                        }

                    }

                    Cart::where('id', '=', $c->id)
                        ->where('user_id', Auth::user()
                        ->id)
                        ->update(['distype' => 'category', 'disamount' => $per,'coupan_id' => $cpn->id]);
                }

                if ($cpn->minamount != 0)
                {

                    $total = $total + Session::get('shippingrate'); 

                    if ($total*$conversion_rate >= $cpn->minamount*$conversion_rate)
                    {

                        Cart::where('id', '=', $c->id)
                        ->where('user_id', Auth::user()
                        ->id)
                        ->update(['distype' => 'category', 'disamount' => $per,'coupan_id' => $cpn->id]);
                        return back();

                    }
                    else
                    {
                        Cart::where('user_id', Auth::user()
                            ->id)
                            ->update(['distype' => NULL, 'disamount' => NULL,'coupan_id' => NULL]);
                        return back()->with('fail', 'For Apply this coupon your similar category products total should be ' . sprintf("%.2f",$cpn->minamount * $conversion_rate) . ' or greater !');
                    }

                }
                else
                {
                    Cart::where('id', '=', $c->id)
                        ->where('user_id', Auth::user()
                        ->id)
                        ->update(['distype' => 'category', 'disamount' => $per,'coupan_id' => $cpn->id]);

                    return back();
                }

            }
            else
            {
                return back()
                    ->with('fail', 'Sorry no matching product found in your cart for this coupon !');
            }

        }
        else
        {

            $cart = Session::get('cart');
            $catcart = collect();
            $totaldiscount = 0;
            $total = 0;
            foreach ($cart as $key => $c)
            {

                $pro = Product::find($c['pro_id']);

                if (isset($pro))
                {

                    if ($pro->category_id == $cpn->cat_id)
                    {

                        $catcart->push($c);

                    }

                }

            }

            foreach ($catcart as $key => $row)
            {
                if ($row['varofferprice'] != 0)
                {
                    $total = $total + $row['varofferprice'];
                }
                else
                {
                    $total = $total + $row['varprice'];
                }
            }

            $total = $total + Session::get('shippingrate');

            if ($cpn->minamount != 0)
            {

                if ($total*$conversion_rate >= $cpn->minamount*$conversion_rate)
                {
                    return back()
                        ->with('fail', 'For Apply this coupon your similar category products total should be greater than ' . sprintf("%.2f",$cpn->minamount * $conversion_rate));
                }

            }

            foreach ($cart as $key => $c)
            {

                foreach ($catcart as $k => $r)
                {

                    $pro = Product::find($r['pro_id']);

                    if ($c['pro_id'] == $r['pro_id'] && $cpn->cat_id == $pro->category_id)
                    {
                        $per = 0;

                        if ($cpn->distype == 'per')
                        {

                            if ($r['varofferprice'] != 0)
                            {
                                $per = ($r['qty'] * $r['varofferprice']) * $cpn->amount / 100;
                                $totaldiscount = $totaldiscount + $per;
                            }
                            else
                            {
                                $per = ($r['qty'] * $r['varprice']) * $cpn->amount / 100;
                                $totaldiscount = $totaldiscount + $per;
                            }

                        }
                        else
                        {
                            $per = $cpn->amount / count($catcart);
                            $totaldiscount = $cpn->amount;
                        }

                        //UPDATE Session row //
                        $cart[$key]['discount'] = $per;
                        $cart[$key]['distype'] = 'category';
                        Session::put('cart', $cart);
                        // END //
                        
                    }

                }

            }

            //Putting a session//
            Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'discount' => $totaldiscount, 'msg' => "$cpn->code Applied Successfully !", 'appliedOn' => 'category']);

            //end return success with discounted amount
            return back();

            if (count($catcart) < 1)
            {
                return back()->with('fail', 'Sorry no matching product found in your cart for this coupon !');
            }

        }

    }

    public function remove()
    {
        Session::forget('coupanapplied');

        if (Auth::check())
        {
            Cart::where('user_id', '=', Auth::user()->id)
                ->update(['distype' => NULL, 'disamount' => NULL, 'coupan_id' => NULL]);
            return back()
                ->with('fail', 'Coupon Removed !');
        }
        else
        {
            $cart = Session::get('cart');
            foreach ($cart as $key => $c)
            {

                $cart[$key]['discount'] = 0;
                $cart[$key]['distype'] = NULL;

            }
            Session::put('cart', $cart);
            return back()->with('fail', 'Coupon Removed !');
        }
    }
}

