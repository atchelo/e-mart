<?php

namespace App\Http\Controllers\Web;

use App\AddSubVariant;
use App\Cart;
use App\Coupan;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add_item(Request $request, $id, $variantid, $varprice, $varofferprice, $qty)
    {

        $getvenderid = Product::where('id', $id)->first()->vender_id;

        $varofferprice1 = $varofferprice * $qty;
        $varprice1 = $varprice * $qty;

        $user = Auth::user();

        if (!empty($user)) {

            $cart_table = Cart::where('variant_id', $variantid)->where('user_id', $user->id)
                ->first();

            if ($cart_table) {

                if ($cart_table->variant_id == $variantid) {

                    $varinfo = AddSubVariant::where('id', $variantid)->first();

                    if ($varinfo->max_order_qty == null) {
                        $limit = $varinfo->stock;
                    } else {
                        $limit = $varinfo->max_order_qty;
                    }

                    $tqty = $cart_table->qty + $qty;

                    if ($tqty <= $limit) {

                        $price_total = $tqty * $varprice;
                        $semi_total = $tqty * $varofferprice;

                        Cart::where('variant_id', $variantid)->where('user_id', $user->id)
                            ->update(['qty' => $tqty, 'price_total' => $price_total, 'semi_total' => $semi_total]);

                        if (isset(Session::get('coupanapplied')['appliedOn']) && Session::get('coupanapplied')['appliedOn'] == 'product') {

                            $coupon = Coupan::where('code', '=', Session::get('coupanapplied')['code'])->first();
                            $discount = 0;
                            $total = 0;
                            $pricenew = 0;
                            $newCart = Cart::where('variant_id', $variantid)->where('user_id', $user->id)
                                ->first();

                            if (isset($coupon)) {

                                if ($coupon->pro_id == $newCart->pro_id) {

                                    if ($coupon->distype == 'per') {

                                        if ($newCart->semi_total != 0) {

                                            $per = $newCart->semi_total * $coupon->amount / 100;
                                            $discount = $per;

                                        } else {

                                            $per = $newCart->price_total * $coupon->amount / 100;
                                            $discount = $per;

                                        }

                                    } else {

                                        if ($newCart->semi_total != 0) {

                                            $discount = $coupon->amount;

                                        } else {

                                            $discount = $coupon->amount;

                                        }

                                    }

                                    // Putting a session//
                                    Session::put('coupanapplied', ['code' => $coupon->code, 'cpnid' => $coupon->id, 'discount' => $discount, 'msg' => "$coupon->code Applied Successfully !", 'appliedOn' => 'product']);

                                    Cart::where('pro_id', '=', $coupon['pro_id'])->where('user_id', '=', Auth::user()
                                            ->id)
                                            ->update(['distype' => 'product', 'disamount' => $discount]);

                                }

                            } else {
                                $discount = 0;
                            }

                        } elseif (Session::has('coupanapplied') && Session::get('coupanapplied')['appliedOn'] == 'category') {

                            $coupon = Coupan::where('code', '=', Session::get('coupanapplied')['code'])->first();
                            $newCart = Cart::where('variant_id', $variantid)->where('user_id', $user->id)
                                ->first();
                            $per = 0;
                            $totaldiscount = 0;

                            if ($coupon->distype == 'per') {

                                if ($newCart->semi_total != 0) {

                                    $per = $newCart->semi_total * $coupon->amount / 100;

                                } else {

                                    $per = $newCart->price_total * $coupon->amount / 100;

                                }

                                $totaldiscount = Session::get('coupanapplied')['discount'] + $per;

                            } else {

                                $allcart = Cart::where('user_id', Auth::user()->id)
                                    ->where('distype', '=', 'category')
                                    ->count();

                                if ($newCart->semi_total != 0) {
                                    $per = $coupon->amount / $allcart;
                                } else {
                                    $per = $coupon->amount / $allcart;
                                }

                                $totaldiscount = Session::get('coupanapplied')['discount'];

                            }

                            Cart::where('id', '=', $newCart->id)
                                ->where('user_id', '=', Auth::user()
                                        ->id)
                                    ->update(['distype' => 'category', 'disamount' => $per]);

                        } elseif (Session::has('coupanapplied') && Session::get('coupanapplied')['appliedOn'] == 'cart') {

                            $pdis = Session::get('coupanapplied');
                            $coupon = Coupan::where('code', '=', Session::get('coupanapplied')['code'])->first();
                            $discount = 0;
                            $total = 0;
                            $pricenew = 0;
                            $allcart = Cart::where('user_id', Auth::user()->id)
                                ->count();
                            $newCart = Cart::where('variant_id', $variantid)->where('user_id', $user->id)
                                ->first();

                            if (isset($coupon)) {

                                if ($coupon->distype == 'per') {

                                    if ($newCart->semi_total != 0) {

                                        $per = $newCart->ori_offer_price * $coupon->amount / 100;
                                        $discount = $per;

                                    } else {

                                        $per = $newCart->ori_price * $coupon->amount / 100;
                                        $discount = $per;

                                    }

                                } else {

                                    if ($newCart->semi_total != 0) {
                                        $discount = $coupon->amount / $allcart;
                                    } else {
                                        $discount = $coupon->amount / $allcart;
                                    }

                                }

                                $totaldiscount = Session::get('coupanapplied')['discount'];
                                Cart::where('user_id', '=', Auth::user()->id)
                                    ->update(['distype' => 'cart', 'disamount' => $discount]);

                            }

                            // Putting a session//
                            Session::put('coupanapplied', ['code' => $coupon->code, 'cpnid' => $coupon->id, 'discount' => $totaldiscount, 'msg' => "$coupon->code Applied Successfully !", 'appliedOn' => 'cart']);

                        }

                        return response()->json([
                            'msg' => __("Product Quantity updated in cart !"),
                            'status' => 'success',
                        ]);
                    } else {

                        return response()->json([
                            'msg' => __("Product already in cart with max quantity limit !"),
                            'status' => 'fail',
                        ]);

                    }

                }

            } else {

                $createCart = new Cart;

                $createCart->user_id = $user->id;
                $createCart->pro_id = $id;
                $createCart->qty = $qty;
                $createCart->variant_id = $variantid;
                $createCart->semi_total = $varofferprice1;
                $createCart->price_total = $varprice1;
                $createCart->ori_price = $varprice;
                $createCart->ori_offer_price = $varofferprice;
                $createCart->vender_id = $getvenderid;

                $createCart->save();

                if (isset(Session::get('coupanapplied')['appliedOn']) && Session::get('coupanapplied')['appliedOn'] == 'cart') {

                    $carts = Cart::where('user_id', '=', Auth::user()->id)
                        ->get();
                    $code = Session::get('coupanapplied')['code'];
                    $coupon = Coupan::where('code', '=', $code)->first();
                    $total = 0;
                    $totaldiscount = 0;

                    foreach ($carts as $key => $c) {
                        if ($c->semi_total != 0) {
                            $total = $total + $c->semi_total;
                        } else {
                            $total = $total + $c->price_total;
                        }
                    }

                    if (isset($coupon)) {

                        foreach ($carts as $key => $c) {

                            $per = 0;

                            if ($coupon->distype == 'per') {

                                if ($c->semi_total != 0) {
                                    $per = $c->semi_total * $coupon->amount / 100;
                                    $totaldiscount = $totaldiscount + $per;
                                } else {
                                    $per = $c->price_total * $coupon->amount / 100;
                                    $totaldiscount = $totaldiscount + $per;
                                }

                            } else {

                                if ($c->semi_total != 0) {
                                    $per = $coupon->amount / count($carts);
                                    $totaldiscount = $totaldiscount + $per;
                                } else {
                                    $per = $coupon->amount / count($carts);
                                    $totaldiscount = $totaldiscount + $per;
                                }

                            }

                            Cart::where('id', '=', $c->id)
                                ->update(['distype' => 'cart', 'disamount' => $per]);

                        }

                    }

                    // Putting a session//
                    Session::put('coupanapplied', ['code' => $coupon->code, 'cpnid' => $coupon->id, 'discount' => $totaldiscount, 'msg' => "$coupon->code Applied Successfully !", 'appliedOn' => 'cart']);

                } elseif (isset(Session::get('coupanapplied')['appliedOn']) && Session::get('coupanapplied')['appliedOn'] == 'category') {

                    $code = Session::get('coupanapplied')['code'];
                    $cpn = Coupan::where('code', '=', $code)->first();
                    $eachqtydis = 0;
                    $lastcartrow = Cart::find($createCart->id);
                    $lastcartrow->distype = 'category';
                    $lastcartrow->save();
                    $totaldiscount = 0;

                    if ($cpn->cat_id == $createCart
                        ->product
                        ->category_id) {

                        if ($cpn->distype == 'per') {

                            if ($lastcartrow->semi_total != 0) {
                                $eachqtydis = $lastcartrow->semi_total * $cpn->amount / 100;
                            } else {
                                $eachqtydis = $lastcartrow->price_total * $cpn->amount / 100;
                            }

                            $totaldiscount = Session::get('coupanapplied')['discount'] + $eachqtydis;

                        } else {

                            $catcart = Cart::where('distype', 'category')->where('user_id', Auth::user()
                                    ->id)
                                    ->count();
                            $eachqtydis = $cpn->amount / $catcart;
                            $totaldiscount = Session::get('coupanapplied')['discount'];
                            Cart::where('user_id', '=', Auth::user()->id)
                                ->where('distype', '=', 'category')
                                ->update(['disamount' => $eachqtydis]);
                        }

                        $lastcartrow->disamount = $eachqtydis;
                        $lastcartrow->distype = 'category';
                        $lastcartrow->save();

                        // Putting a session//
                        Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'discount' => $totaldiscount, 'msg' => "$cpn->code Applied Successfully !", 'appliedOn' => 'category']);

                    }

                }

            }

            return response()->json([
                'msg' => __("Product added in cart !"),
                'status' => 'success',
            ]);

            return redirect('cart');

        } else {

            $carts = Session::get('cart');

            if (!empty(Session::get('cart'))) {

                $avbl = 0;

                foreach ($carts as $key => $ecart) {

                    if ($variantid == $carts[$key]['variantid']) {
                        $avbl = 1;
                        break;
                    }

                }

                if ($avbl == 1) {

                    $curqty = $carts[$key]['qty'];

                    $varinfo = AddSubVariant::where('id', $variantid)->first();

                    if ($varinfo->max_order_qty == null) {
                        $limit = $varinfo->stock;
                    } else {
                        $limit = $varinfo->max_order_qty;
                    }

                    $tqty = $curqty + $qty;

                    if ($tqty <= $limit) {

                        $carts[$key]['qty'] = $tqty;

                        if (isset(Session::get('coupanapplied')['appliedOn']) && Session::get('coupanapplied')['appliedOn'] == 'product') {

                            $totaldiscount = 0;

                            $coupon = Coupan::where('code', '=', Session::get('coupanapplied')['code'])->first();

                            if (isset($coupon) && $coupon->pro_id == $carts[$key]['pro_id']) {
                                $per = 0;
                                $singleper = 0;

                                if ($coupon->distype == 'per') {

                                    if ($carts[$key]['varofferprice'] != 0) {

                                        $per = $carts[$key]['varofferprice'] * $coupon->amount / 100;
                                        $singleper = $per * $carts[$key]['qty'];
                                        $per = $per * $qty;
                                        $totaldiscount = $totaldiscount + $per;

                                    } else {

                                        $per = $carts[$key]['varprice'] * $coupon->amount / 100;
                                        $singleper = $per * $carts[$key]['qty'];
                                        $per = $per * $carts[$key]['qty'];
                                        $totaldiscount = $totaldiscount + $per;

                                    }

                                } else {

                                    if ($carts[$key]['varofferprice'] != 0) {
                                        $singleper = $coupon->amount;
                                    } else {
                                        $singleper = $coupon->amount;
                                    }

                                    $totaldiscount = Session::get('coupanapplied')['discount'];
                                }
                                $totaldiscount = $singleper;
                                $carts[$key]['discount'] = $singleper;
                                $carts[$key]['distype'] = 'product';

                            }

                            // Putting a session//
                            Session::put('coupanapplied', ['code' => $coupon->code, 'cpnid' => $coupon->id, 'discount' => $totaldiscount, 'msg' => "$coupon->code Applied Successfully !", 'appliedOn' => 'product']);

                        } elseif (isset(Session::get('coupanapplied')['appliedOn']) && Session::get('coupanapplied')['appliedOn'] == 'category') {

                            $coupon = Coupan::where('code', '=', Session::get('coupanapplied')['code'])->first();
                            $singleper = 0;
                            $totaldiscount = Session::get('coupanapplied')['discount'];

                            if ($coupon->distype == 'per') {
                                if ($carts[$key]['varofferprice'] != 0) {

                                    $per = $carts[$key]['varofferprice'] * $coupon->amount / 100;
                                    $singleper = $per * $carts[$key]['qty'];
                                    $per = $per * $qty;
                                    $totaldiscount = $totaldiscount + $per;

                                } else {

                                    $per = $carts[$key]['varprice'] * $coupon->amount / 100;
                                    $singleper = $per * $carts[$key]['qty'];
                                    $per = $per * $carts[$key]['qty'];
                                    $totaldiscount = $totaldiscount + $per;

                                }
                            } else {
                                $totaldiscount = Session::get('coupanapplied')['discount'];
                                $per = $carts[$key]['discount'];
                            }

                            $carts[$key]['discount'] = $per;
                            $carts[$key]['distype'] = 'category';
                            Session::put('cart', $carts);
                            // Putting a session//
                            Session::put('coupanapplied', ['code' => $coupon->code, 'cpnid' => $coupon->id, 'discount' => $totaldiscount, 'msg' => "$coupon->code Applied Successfully !", 'appliedOn' => 'category']);

                        } elseif (isset(Session::get('coupanapplied')['appliedOn']) && Session::get('coupanapplied')['appliedOn'] == 'cart') {

                            $pdis = Session::get('coupanapplied');
                            $coupon = Coupan::where('code', '=', Session::get('coupanapplied')['code'])->first();
                            $totaldiscount = Session::get('coupanapplied')['discount'];
                            $total = 0;
                            $pricenew = 0;
                            $allcart = Session::get('cart');
                            $allcart = count($allcart);

                            if (isset($coupon)) {
                                $per = 0;
                                $singleper = 0;
                                if ($coupon->distype == 'per') {

                                    if ($carts[$key]['varofferprice'] != 0) {

                                        $per = $carts[$key]['varofferprice'] * $coupon->amount / 100;
                                        $singleper = $per * $carts[$key]['qty'];
                                        $per = $per * $qty;
                                        $totaldiscount = $totaldiscount + $per;

                                    } else {

                                        $per = $carts[$key]['varprice'] * $coupon->amount / 100;
                                        $singleper = $per * $carts[$key]['qty'];
                                        $per = $per * $carts[$key]['qty'];
                                        $totaldiscount = $totaldiscount + $per;

                                    }

                                } else {

                                    if ($carts[$key]['varofferprice'] != 0) {
                                        $singleper = $coupon->amount / $allcart;
                                    } else {
                                        $singleper = $coupon->amount / $allcart;
                                    }

                                    $totaldiscount = Session::get('coupanapplied')['discount'];
                                }

                                $carts[$key]['discount'] = $singleper;
                                $carts[$key]['distype'] = 'cart';

                            }

                            // Putting a session//
                            Session::put('coupanapplied', ['code' => $coupon->code, 'cpnid' => $coupon->id, 'discount' => $totaldiscount, 'msg' => "$coupon->code Applied Successfully !", 'appliedOn' => 'cart']);

                        }

                        Session::put('cart', $carts);

                        return response()->json([
                            'msg' => __("Product Quantity updated in cart !"),
                            'status' => 'success',
                        ]);

                    } else {

                        return response()->json([
                            'msg' => __("Product already in cart with max quantity limit !"),
                            'status' => 'fail',
                        ]);
                    }

                } else {
                    Session::push('cart', ['distype' => null, 'discount' => 0, 'pro_id' => $id, 'variantid' => $variantid, 'varprice' => $varprice, 'varofferprice' => $varofferprice, 'qty' => $qty]);

                    $cart = Session::get('cart');

                    if (Session::has('coupanapplied')) {

                        $cpn = Coupan::where('code', '=', Session::get('coupanapplied')['code'])->first();

                    }

                    if (isset(Session::get('coupanapplied')['appliedOn']) && Session::get('coupanapplied')['appliedOn'] == 'cart') {
                        $totaldiscount = 0;

                        foreach ($cart as $key => $c) {
                            $per = 0;
                            if ($cpn->distype == 'per') {

                                if ($c['varofferprice'] != 0) {
                                    $per = ($c['varofferprice'] * $c['qty']) * $cpn->amount / 100;
                                    $totaldiscount = $totaldiscount + $per;
                                } else {
                                    $per = ($c['varprice'] * $c['qty']) * $cpn->amount / 100;
                                    $totaldiscount = $totaldiscount + $per;
                                }

                            } else {

                                if ($c['varofferprice'] != 0) {
                                    $per = $cpn->amount / count($cart);
                                    $totaldiscount = $totaldiscount + $per;
                                } else {
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

                    } elseif (isset(Session::get('coupanapplied')['appliedOn']) && Session::get('coupanapplied')['appliedOn'] == 'category') {
                        $cart = Session::get('cart');
                        $catcart = collect();
                        $totaldiscount = 0;

                        foreach ($cart as $key => $c) {

                            $pro = Product::find($c['pro_id']);

                            if (isset($pro)) {

                                if ($pro->category_id == $cpn->cat_id) {

                                    $catcart->push($c);

                                }

                            }

                        }

                        foreach ($cart as $key => $c) {

                            foreach ($catcart as $k => $r) {

                                $pro = Product::find($r['pro_id']);

                                if ($c['pro_id'] == $r['pro_id'] && $cpn->cat_id == $pro->category_id) {
                                    $per = 0;

                                    if ($cpn->distype == 'per') {

                                        if ($r['varofferprice'] != 0) {
                                            $per = ($r['qty'] * $r['varofferprice']) * $cpn->amount / 100;
                                            $totaldiscount = $totaldiscount + $per;
                                        } else {
                                            $per = ($r['qty'] * $r['varprice']) * $cpn->amount / 100;
                                            $totaldiscount = $totaldiscount + $per;
                                        }

                                    } else {
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
                    }

                    return response()->json([
                        'msg' => __("Product added in cart !"),
                        'status' => 'success',
                    ]);
                }

            } else {
                Session::push('cart', ['distype' => null, 'discount' => '0', 'pro_id' => $id, 'variantid' => $variantid, 'varprice' => $varprice, 'varofferprice' => $varofferprice, 'qty' => $qty]);

                return response()->json([
                    'msg' => __("Product added in cart !"),
                    'status' => 'success',
                ]);
            }

        }

    }

    public function removeitemlogin($id)
    {

    }

    public function removeitemguest($variantid)
    {

        return response()->json($variantid);
    }

    public function applygiftcharge(Request $request)
    {

        auth()->user()->cart()->where('variant_id', $request->variant)->update([
            'gift_pkg_charge' => $request->charge,
        ]);

        return response()->json('applied', 200);

    }

    public function resetgiftcharge(Request $request)
    {
        auth()->user()->cart()->where('variant_id', $request->variant)->update([
            'gift_pkg_charge' => 0,
        ]);

        return response()->json('removed', 200);
    }

}
