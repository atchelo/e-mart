<?php
namespace App\Http\Controllers;

use App\AddSubVariant;
use App\AutoDetectGeo;
use App\Cart;
use App\Coupan;
use App\CurrencyCheckout;
use App\Genral;
use App\Product;
use App\Shipping;
use App\ShippingWeight;
use Auth;
use DB;
use Illuminate\Http\Request;
use Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        $user = Auth::user();
        $qty = 0;
        if (!empty($user)) {

            $cart_table = auth()->user()->cart()->where('pro_id',$id)->first(); 
            if (empty($cart_table)) {

                Cart::create(array(

                    'pro_id' => $id,
                    'user_id' => $user->id,
                    'qty' => $qty + 1,

                ));

            } else {

                Cart::where('pro_id', $id)->where('user_id', $user->id)
                    ->update(array(
                        'pro_id' => $id,
                        'qty' => $qty + 1,
                        'user_id' => $user->id,

                ));

                notify()->error('failure','This Product is Already Available');
                return back();
            }

            return redirect('cart');

        } else {

            $qty = 0;
            $post = $id;

            $cart = Session::get('cart');

            if (isset($cart)) {

                foreach ($cart as $key => $p) {
                    $pro_id = Product::where('id', $id)->first();
                    if ($pro_id->qty <= $p['quantity']) {

                        return back()->with("failure", "Stock Is Not Available");
                    }
                    if ($p['id'] == $post) {
                        $qty = $p['quantity'];
                        unset($cart[$key]);
                        break;
                    }
                }

            }
            $product_data = array();
            $product_data['id'] = $id;
            $product_data['quantity'] = $qty + 1;

            $cart[] = $product_data;

            Session::put('cart', $cart);

            return redirect('cart');

        }
    }

    public function create_cart()
    {

        $checkoutsetting_check = AutoDetectGeo::first();

        if ($checkoutsetting_check->enable_cart_page == 1) {
            $listcheckOutCurrency = CurrencyCheckout::get();
            $currentCurrency = Session::get('currency');

            foreach ($listcheckOutCurrency as $key => $all) {
                if ($currentCurrency['id'] == $all->currency) {
                    if ($all->checkout_currency == 1) {
                        Session::forget('validcurrency');
                    } else {
                        Session::put('validcurrency', 1);
                    }
                }
            }
        } else {
            Session::forget('validcurrency');
        }

        require_once 'price.php';

        $total = 0;

        if (auth()->check()) {

            $cart_table = auth()->user()->cart()->with(['product','product.reviews','variant','product.shippingmethod'])->whereHas('product',function($query){
                return $query->where('status','1');
            })->whereHas('variant')->get();

            foreach ($cart_table as $key => $value) {

                if ($value->semi_total != 0) {
                    $total = $total + $value->semi_total + $value->shipping + $value->tax_amount;
                } else {
                    $total = $total + $value->price_total + $value->shipping + $value->tax_amount;
                }

            }

        } else {

            $value = Session('cart');
            if (isset($value)) {

                foreach ($value as $row) {
                    $id = $row['pro_id'];
                    $qty = $row['qty'];
                    $product = Product::find($id);

                    if ($product) {
                        if (empty($product->offer_price)) {
                            $product->total_price = $qty * $product->price;
                            $product->mrp = $qty * $product->price;
                        } else {
                            $product->total_price = $qty * $product->offer_price;
                            $product->new_offerprice = $qty * $product->offer_price;
                            $product->mrp = $qty * $product->price;
                        }

                        $data[] = $product;

                    }

                }

                $cart_table = session()->get('cart');
                
                Session::put('total', $total);

            }
        }
       
        return view("front.shopping-cart-2", compact('cart_table','conversion_rate'));

    }

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

                        alert()->success('<p class="font-weight-normal">Product Quantity updated in cart !</p>')->html()->autoclose(8000);
                        return redirect('cart');
                    } else {
                        alert()->warning('<p class="font-weight-normal">Product already in cart with max quantity limit !</p>')->html()->autoclose(8000);
                        return redirect('cart');
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

                } elseif (Session::has('coupanapplied') && Session::get('coupanapplied')['appliedOn'] == 'category') {

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

            alert()->success('<p class="font-weight-normal">Product added in cart !</p>')->html()->autoclose(8000);

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

                        if (Session::has('coupanapplied') && Session::get('coupanapplied')['appliedOn'] == 'product') {

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

                        } elseif (Session::has('coupanapplied') && Session::get('coupanapplied')['appliedOn'] == 'category') {

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

                        } elseif (Session::has('coupanapplied') && Session::get('coupanapplied')['appliedOn'] == 'cart') {

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
                        alert()->success('<p class="font-weight-normal">Product Quantity updated in cart !</p>')->html()->autoclose(8000);
                        return redirect('cart');
                    } else {
                        alert()->warning('<p class="font-weight-normal">Product already in cart with max quantity limit !</p>')->html()->autoclose(8000);

                        return redirect('cart');
                    }

                } else {
                    Session::push('cart', ['distype' => null, 'discount' => 0, 'pro_id' => $id, 'variantid' => $variantid, 'varprice' => $varprice, 'varofferprice' => $varofferprice, 'qty' => $qty]);

                    $cart = Session::get('cart');
                    
                    if(Session::has('coupanapplied')){
                        $cpn = Coupan::where('code', '=', Session::get('coupanapplied')['code'])->first();
                    }

                    if (Session::has('coupanapplied') && Session::get('coupanapplied')['appliedOn'] == 'cart') {
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

                    } elseif (Session::has('coupanapplied') && Session::get('coupanapplied')['appliedOn'] == 'category') {
                        $cart = Session::get('cart');
                        $notavbl = 1;
                        $catcart = collect();
                        $totaldiscount = 0;
                        $count = 0;

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

                    alert()->success('<p class="font-weight-normal">Product added in cart !</p>')->html()->autoclose(8000);
                    return redirect('cart');
                }

            } else {
                Session::push('cart', ['distype' => null, 'discount' => '0', 'pro_id' => $id, 'variantid' => $variantid, 'varprice' => $varprice, 'varofferprice' => $varofferprice, 'qty' => $qty]);
                alert()->success('<p class="font-weight-normal">Product added in cart !</p>')->html()->autoclose(8000);
                return redirect('cart');
            }

        }

    }

    public function remove_cart($id)
    {

        $cart = Session::get('cart');
        $count = count($cart);

        if (!Session::has('coupanapplied')) {

            foreach ($cart as $key => $row) {

                if ($row['variantid'] == $id) {
                    unset($cart[$key]);
                }

            }

            Session::put('cart', $cart);

            if (count(Session::get('cart')) > 0) {
                notify()->success('Item is removed from your cart !');
                return back();
            } else {
                notify()
                    ->success('Your cart is now empty !');
                return redirect('/');
            }

        }

        foreach ($cart as $key => $row) {

            if ($row['variantid'] == $id) {
                unset($cart[$key]);
            }

        }

        Session::put('cart', $cart);
        $cart = Session::get('cart');

        if (count($cart) > 0) {

            if (Session::get('coupanapplied')['appliedOn'] == 'product') {
                foreach ($cart as $key => $row) {

                    if ($row['variantid'] == $id) {
                        unset($cart[$key]);
                        break;
                    }

                }
                Session::forget('coupanapplied');
                Session::put('cart', $cart);
                notify()->success('Item is removed from your cart !');
                return back();
            }

            if (Session::get('coupanapplied')['appliedOn'] == 'category') {

                $notavbl = 1;
                $catcart = collect();
                $totaldiscount = 0;
                $count = 0;
                $cpn = Coupan::where('code', '=', Session::get('coupanapplied')['code'])->first();

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

                foreach ($cart as $key => $c) {

                    $pro = Product::find($c['pro_id']);

                    if (isset($pro)) {

                        if ($pro->category_id == $cpn->cat_id) {

                            $catcart->push($c);

                        }

                    }

                }

                $total = 0;

                foreach ($catcart as $key => $value) {

                    if ($value['varofferprice'] != 0) {

                        $total = $total + $value['varofferprice'];

                    } else {

                        $total = $total + $value['varprice'];

                    }

                }

                $total = $total + Session::get('shippingrate');

                if ($cpn->minamount != 0) {
                    if ($total < $cpn->minamount) {
                        Session::forget('coupanapplied');
                        return back()
                            ->with('fail', 'Coupan removed !');
                        exit();
                    }
                }

                if (count($catcart) < 1) {

                    Session::forget('coupanapplied');

                } else {
                    //Putting a session//
                    Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'discount' => $totaldiscount, 'msg' => "$cpn->code Applied Successfully !", 'appliedOn' => 'category']);
                }

                return back();

            }

            if (Session::get('coupanapplied')['appliedOn'] == 'cart') {

                $cpn = Coupan::where('code', '=', Session::get('coupanapplied')['code'])->first();
                $totaldiscount = 0;
                $total = 0;
                foreach ($cart as $key => $c) {
                    if ($c['varofferprice'] != 0) {
                        $total = $total + $c['varofferprice'];
                    } else {
                        $total = $total + $c['varprice'];
                    }

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

                $total = $total + Session::get('shippingrate');

                if ($cpn->minamount != 0) {
                    if ($total < $cpn->minamount) {
                        Session::forget('coupanapplied');
                        return back()
                            ->with('fail', 'Coupon Removed !');
                        exit();
                    }
                }

                //Putting a session//
                Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'discount' => $totaldiscount, 'msg' => "$cpn->code Applied Successfully !", 'appliedOn' => 'cart']);
                notify()
                    ->success('Item is removed from your cart !');
                return redirect()
                    ->back();
            }

        } else {
            Session::forget('coupanapplied');
            Session::forget('cart');
            notify()
                ->success('Your cart is now empty !');
            return redirect('/');
        }

    }

    public function remove_table_cart($id)
    {

        $user_id = Auth::user()->id;
        $cart = Cart::where('user_id', $user_id)->get();
        foreach ($cart as $key => $row) {
            if ($row['variant_id'] == $id) {

                if (Session::has('coupanapplied')) {

                    if (Session::get('coupanapplied')['appliedOn'] == 'product') {

                        return $this->recalulateproduct($user_id, $id);

                    } elseif (Session::get('coupanapplied')['appliedOn'] == 'cart') {

                        return $this->recalulateproductoncart($user_id, $id);

                    } elseif (Session::get('coupanapplied')['appliedOn'] == 'category') {
                        return $this->recalulateproductoncategory($user_id, $id);
                    }
                } else {
                    $url = url()->previous();
                    DB::table('carts')->where('user_id', $user_id)->where('variant_id', $id)->delete();
                    notify()->success('Item removed from your cart !');

                    if (strstr($url, 'order-review')) {
                        Session::put('from-order-review-page', 'yes');
                        Session::put('page-reloaded', 'yes');
                    }

                    if (strstr($url, 'process/billingaddress')) {
                        Session::put('from-order-step-3', 'yes');
                    }

                    if (empty(Session::get('cart')) && count(Auth::user()->cart) < 1) {
                        Session::forget('from-order-review-page');
                        Session::forget('from-order-step-3');
                        Session::forget('page-reloaded');
                        notify()->success('Your cart is empty !');
                        return redirect('/');
                    }

                    return back();

                }

            }

        }

    }

    public function recalulateproduct($user_id, $id)
    {

        Session::forget('coupanapplied');
        DB::table('carts')->where('user_id', $user_id)->update(['disamount' => null, 'distype' => null]);
        DB::table('carts')
            ->where('user_id', $user_id)->where('variant_id', $id)->delete();
        notify()
            ->success('Item removed from your cart !');

        return redirect('/checkout');
    }

    public function recalulateproductoncategory($user_id, $id)
    {

        $row = DB::table('carts')->where('user_id', $user_id)->where('variant_id', $id)->first();
        $cpn = Coupan::where('code', '=', Session::get('coupanapplied')['code'])->first();
        $total = 0;
        if ($cpn->distype == 'per') {
            DB::table('carts')
                ->where('user_id', $user_id)->where('variant_id', $id)->delete();
            $totaldiscount = Session::get('coupanapplied')['discount'] - $row->disamount;
            // Putting a session//
            $catcart = Cart::where('distype', '=', 'category')->where('user_id', Auth::user()
                    ->id)
                    ->get();

            foreach ($catcart as $key => $r) {
                if ($r->semi_total != 0) {
                    $total = $total + $r->semi_total;
                } else {
                    $total = $total + $r->price_total;
                }
            }

            $total = $total + $catcart->sum('shipping');

            if ($cpn->minamount != 0) {
                if ($total < $cpn->minamount) {
                    Session::forget('coupanapplied');
                    return back()
                        ->with('fail', 'Coupon Removed !');
                    exit();
                } else {
                    Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'discount' => $totaldiscount, 'msg' => "$cpn->code Applied Successfully !", 'appliedOn' => 'category']);
                }
            } else {
                Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'discount' => $totaldiscount, 'msg' => "$cpn->code Applied Successfully !", 'appliedOn' => 'category']);
            }

            Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'discount' => $totaldiscount, 'msg' => "$cpn->code Applied Successfully !", 'appliedOn' => 'category']);

            if (count($catcart) < 1) {
                Session::forget('coupanapplied');
            }

        } else {
            DB::table('carts')->where('user_id', $user_id)->where('variant_id', $id)->delete();
            $catcart = Cart::where('distype', '=', 'category')->where('user_id', Auth::user()
                    ->id)
                    ->get();

            foreach ($catcart as $key => $cr) {
                $perd = 0;
                $perd = $cpn->amount / count($catcart);
                Cart::where('id', '=', $cr->id)
                    ->update(['distype' => 'cart', 'disamount' => $perd]);
            }

            if (count($catcart) < 1) {
                Session::forget('coupanapplied');
            }

            foreach ($catcart as $key => $r) {
                if ($r->semi_total != 0) {
                    $total = $total + $r->semi_total;
                } else {
                    $total = $total + $r->price_total;
                }
            }

            $total = $total + $catcart->sum('shipping');

            if ($cpn->minamount != 0) {
                if ($total < $cpn->minamount) {
                    Session::forget('coupanapplied');
                    return back()
                        ->with('fail', 'Coupon Removed !');
                    exit();
                }
            }

        }

        notify()
            ->success('Item removed from your cart !');
        return redirect('/checkout');

    }

    public function recalulateproductoncart($user_id, $id)
    {

        DB::table('carts')->where('user_id', $user_id)->where('variant_id', $id)->delete();
        $carts = Cart::where('user_id', '=', Auth::user()->id)
            ->get();

        if (count($carts) > 0) {

            $code = Session::get('coupanapplied')['code'];

            $total = 0;
            $discount = 0;

            foreach ($carts as $key => $c) {
                if ($c->semi_total != 0) {
                    $total = $total + $c->semi_total;
                } else {
                    $total = $total + $c->price_total;
                }
            }

            $cpn = Coupan::where('code', '=', $code)->first();

            if (isset($cpn)) {
                //check cart amount  //
                $totaldiscount = 0;

                foreach ($carts as $key => $c) {

                    $per = 0;

                    if ($cpn->distype == 'per') {

                        if ($c->semi_total != 0) {
                            $per = $c->semi_total * $cpn->amount / 100;
                            $totaldiscount = $totaldiscount + $per;
                        } else {
                            $per = $c->price_total * $cpn->amount / 100;
                            $totaldiscount = $totaldiscount + $per;
                        }

                    } else {

                        if ($c->semi_total != 0) {
                            $per = $cpn->amount / count($carts);
                            $totaldiscount = $totaldiscount + $per;
                        } else {
                            $per = $cpn->amount / count($carts);
                            $totaldiscount = $totaldiscount + $per;
                        }

                    }

                    Cart::where('id', '=', $c->id)
                        ->update(['distype' => 'cart', 'disamount' => $per]);

                }

            } else {

                $totaldiscount = 0;

            }

            $newcart = Cart::where('user_id', Auth::user()->id)
                ->get();
            $total = 0;

            foreach ($newcart as $key => $r) {
                if ($r->semi_total != 0) {
                    $total = $r->semi_total;
                } else {
                    $total = $r->price_total;
                }
            }

            $total = $total + $newCart->sum('shipping');

            if ($cpn->minamount != 0) {
                if ($total < $cpn->minamount) {
                    Session::forget('coupanapplied');
                    return back()
                        ->with('fail', 'Coupan Removed !');
                    exit();
                } else {
                    // Putting a session//
                    Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'discount' => $totaldiscount, 'msg' => "$cpn->code Applied Successfully !", 'appliedOn' => 'cart']);
                }
            } else {
                // Putting a session//
                Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'discount' => $totaldiscount, 'msg' => "$cpn->code Applied Successfully !", 'appliedOn' => 'cart']);
            }

        } else {
            Session::forget('coupanapplied');
        }

        notify()
            ->success('Item removed from your cart !');
        return redirect('/checkout');
    }

    public function update_table_cart(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $cart = Cart::where('user_id', $user_id)->get();

        $product = Product::where('id', $id)->first();

        $total = $request->quantity * $product->offer_price;

        foreach ($cart as $key => $row) {

            if ($row['pro_id'] == $id) {
                if (empty($row
                    ->product
                    ->offer_price)) {
                    $total = $request->quantity * $row
                        ->product->price;
                } else {
                    $total = $request->quantity * $row
                        ->product->offer_price;
                };
                Cart::where('pro_id', $id)->update(array(
                    'qty' => $request->quantity,
                    'semi_total' => $total,

                ));
            }
        }

        $cart = Cart::where('user_id', $user_id)->get();

        return back();

    }

    public function update_cart(Request $request, $id)
    {

        $cart = Session::get('cart');
        foreach ($cart as $key => $row) {
            if ($row['id'] == $id) {
                $cart[$key]['quantity'] = $request->quantity;
            }

        }

        Session::put('cart', $cart);
        return redirect()->back();

    }

    public function rent_update(Request $request)
    {

        $id = $request->id;
        $days = $request->days;
        $variant_id = $request->variant_id;
        $p = $request->price / $days;
        $op = $request->offerprice / $days;
        $op2 = $request->offerprice;
        $total = 0;
        $shipping = 0;
        $gtotal = 0;
        $auth = Auth::user();
        $pricetotal = 0;
        $offertotal = 0;
        $singletotal = 0;
        $noffertotal = 0;

        require_once 'price.php';

        if (isset(Auth::user()->id)) {
            $user_id = Auth::user()->id;
        }

        if (!empty($user_id)) {

            $ca = Cart::where('id', $id)->first();
            $product = Product::where('id', $ca->pro_id)
                ->first();
            $pro_id = $product->id;

            $offertotal = $days * $ca->ori_offer_price;

            $pricetotal1 = $days * $ca->ori_price;

            if ($offertotal == 0 || $offertotal == null || $offertotal == '') {
                $singletotal = round($pricetotal1, 2);

            } else {
                $singletotal = round($offertotal, 2);
                $noffertotal = round($pricetotal1, 2);
            }

            $cart_table = Cart::where('variant_id', $ca->variant_id)
                ->where('user_id', $user_id)->update(array(
                'qty' => $days,
                'variant_id' => $ca->variant_id,
                'price_total' => $pricetotal1,
                'semi_total' => $offertotal,
            ));

            $show_cart_table = Cart::where('user_id', $user_id)->get();
            foreach ($show_cart_table as $key => $val) {
                if ($val->semi_total == null || $val->semi_total == 0) {
                    $price = $val->price_total;

                } else {
                    $price = $val->semi_total;

                }

                $total = $total + $price;

            }

            $pricetotal = round($total, 2);

        } else {

            $pro_id = $id;

            $cart = Session::get('cart');

            foreach ($cart as $key => $value) {

                if ($value['variantid'] == $variant_id) {
                    $cart[$key]['qty'] = $days;

                    if ($value['varofferprice'] != 0) {
                        $singletotal = $days * $value['varofferprice'];
                        $noffertotal = $days * $value['varprice'];

                    } else {
                        $noffertotal = $days * $value['varprice'];
                    }

                }

            }

            Session::put('cart', $cart);

            //for updating the pricetotal
            foreach (Session::get('cart') as $value) {

                if ($value['varofferprice'] == 0) {
                    $price = $value['qty'] * $value['varprice'];

                } else {
                    $price = $value['qty'] * $value['varofferprice'];

                }

                $total = $total + $price;

            }

            $pricetotal = round($total, 2);

            $singletotal = round($singletotal, 2);
            $noffertotal = round($noffertotal, 2);

        }

        // Shipping

        if (!empty($auth)) {

            $cart_table = Cart::where('user_id', $auth->id)->get();

            foreach ($cart_table as $key => $cart) {

                if ($cart->product->free_shipping == 0) {

                    $free_shipping = Shipping::where('id', $cart->product->shipping_id)->first();

                    if (!empty($free_shipping)) {
                        if ($free_shipping->name == "Shipping Price") {

                            $weight = ShippingWeight::first();
                            $pro_weight = $cart
                                ->variant->weight;
                            if ($weight->weight_to_0 >= $pro_weight) {
                                if ($weight->per_oq_0 == 'po') {
                                    $shipping = $shipping + $weight->weight_price_0;
                                } else {
                                    $shipping = $shipping + $weight->weight_price_0 * $cart->qty;
                                }
                            } elseif ($weight->weight_to_1 >= $pro_weight) {
                                if ($weight->per_oq_1 == 'po') {
                                    $shipping = $shipping + $weight->weight_price_1;
                                } else {
                                    $shipping = $shipping + $weight->weight_price_1 * $cart->qty;
                                }
                            } elseif ($weight->weight_to_2 >= $pro_weight) {
                                if ($weight->per_oq_2 == 'po') {
                                    $shipping = $shipping + $weight->weight_price_2;
                                } else {
                                    $shipping = $shipping + $weight->weight_price_2 * $cart->qty;
                                }
                            } elseif ($weight->weight_to_3 >= $pro_weight) {
                                if ($weight->per_oq_3 == 'po') {
                                    $shipping = $shipping + $weight->weight_price_3;
                                } else {
                                    $shipping = $shipping + $weight->weight_price_3 * $cart->qty;
                                }
                            } else {
                                if ($weight->per_oq_4 == 'po') {
                                    $shipping = $shipping + $weight->weight_price_4;
                                } else {
                                    $shipping = $shipping + $weight->weight_price_4 * $cart->qty;
                                }

                            }

                        } else {

                            $shipping = $shipping + $free_shipping->price;

                        }
                    }

                }

            }

        } else {

            $value = Session::get('cart');
            $shipping = 0;
            if (!empty($value)) {

                foreach ($value as $key => $carts) {
                    $cart = Product::where('id', '=', $carts['pro_id'])->first();
                    $variant = AddSubVariant::where('id', '=', $carts['variantid'])->first();
                    if ($cart->free_shipping == 0) {
                        $free_shipping = Shipping::where('id', $cart->shipping_id)
                            ->first();

                        if ($free_shipping->name == "Shipping Price") {

                            $weight = ShippingWeight::first();
                            $pro_weight = $variant->weight;
                            if ($weight->weight_to_0 >= $pro_weight) {
                                if ($weight->per_oq_0 == 'po') {
                                    $shipping = $shipping + $weight->weight_price_0;
                                } else {
                                    $shipping = $shipping + $weight->weight_price_0 * $carts['qty'];
                                }
                            } elseif ($weight->weight_to_1 >= $pro_weight) {
                                if ($weight->per_oq_1 == 'po') {
                                    $shipping = $shipping + $weight->weight_price_1;
                                } else {
                                    $shipping = $shipping + $weight->weight_price_1 * $carts['qty'];
                                }
                            } elseif ($weight->weight_to_2 >= $pro_weight) {
                                if ($weight->per_oq_2 == 'po') {
                                    $shipping = $shipping + $weight->weight_price_2;
                                } else {
                                    $shipping = $shipping + $weight->weight_price_2 * $carts['qty'];
                                }
                            } elseif ($weight->weight_to_3 >= $pro_weight) {
                                if ($weight->per_oq_3 == 'po') {
                                    $shipping = $shipping + $weight->weight_price_3;
                                } else {
                                    $shipping = $shipping + $weight->weight_price_3 * $carts['qty'];
                                }
                            } else {
                                if ($weight->per_oq_4 == 'po') {
                                    $shipping = $shipping + $weight->weight_price_4;
                                } else {
                                    $shipping = $shipping + $weight->weight_price_4 * $carts['qty'];
                                }

                            }
                            //echo

                        } else {

                            $shipping = $shipping + $free_shipping->price;

                        }

                    }

                }
            }

        }

        $shipping = round($shipping, 2);

        $genrals_settings = Genral::first();

        if ($genrals_settings->cart_amount != 0 || $genrals_settings->cart_amount != '') {

            if ($pricetotal * $conversion_rate >= $genrals_settings->cart_amount * $conversion_rate) {

                $shipping = 0;

            }

        }

        if (Auth::check()) {
            $ca = Cart::where('id', $id)->first();
            Cart::where('user_id', Auth::user()
                    ->id)
                    ->where('variant_id', $ca->variant_id)
                ->update(['shipping' => $shipping]);
        }

        Session::put('shippingrate', $shipping);

        $total = $pricetotal;

        $gtotal = $total + $shipping;

        if (!Auth::check() && !Session::has('coupanapplied')) {

            $gtotal;
            $per = 0;

        } elseif (Auth::check() && Cart::isCoupanApplied() == '1') {
            //proccess coupan calculation for logged in user.

             $cpn = Cart::getCoupanDetail();

            if ($cpn->link_by == 'product') {

                $crt = Cart::where('pro_id', $cpn->pro_id)
                    ->where('user_id', Auth::user()
                            ->id)
                        ->first();

                if ($crt->semi_total != 0) {

                    if ($cpn->distype == 'per') {

                        $per = $crt->semi_total * $cpn->amount / 100;

                    } else {

                        $per = $cpn->amount;
                    }

                } else {

                    if ($crt->distype == 'per') {

                        $per = $crt->price_total * $cpn->amount / 100;

                    } else {
                        $per = $cpn->amount;
                    }

                }

                Cart::where('pro_id', '=', $cpn['pro_id'])->where('user_id', '=', Auth::user()
                        ->id)
                        ->update(['distype' => 'product', 'disamount' => $per, 'coupan_id' => $cpn->id]);
                Cart::where('pro_id', '!=', $cpn['pro_id'])->where('user_id', '=', Auth::user()
                        ->id)
                        ->update(['distype' => null, 'disamount' => null, 'coupan_id' => null]);

                $gtotal = $gtotal - $per;

            } elseif ($cpn->link_by == 'category') {

                $cart = Cart::where('user_id', '=', Auth::user()->id)->get();

                $catcart = collect();
                $cat_total = 0;
                $per = 0;
                foreach ($cart as $row) {

                    if ($row
                        ->product
                        ->category->id == $cpn->cat_id) {
                        $catcart->push($row);
                    }

                }

                foreach ($catcart as $key => $row) {

                    if ($row->semi_total != 0) {
                        $cat_total = $cat_total + $row->semi_total;
                    } else {
                        $cat_total = $cat_total + $row->price_total;
                    }

                }

                foreach ($catcart as $key => $c) {

                    $d = 0;

                    if ($cpn->distype == 'per') {

                        if ($c->semi_total != 0) {

                            $d = $c->semi_total * $cpn->amount / 100;
                            $per = $per + $d;

                        } else {

                            $d = $c->price_total * $cpn->amount / 100;
                            $per = $per + $d;

                        }

                    } else {

                        if ($c->semi_total != 0) {
                            $d = $cpn->amount / count($catcart);
                            $per = $per + $d;
                        } else {
                            $d = $cpn->amount / count($catcart);
                            $per = $per + $d;
                        }

                    }

                    Cart::where('id', '=', $c->id)
                        ->where('user_id', Auth::user()
                                ->id)
                            ->update(['distype' => 'category', 'disamount' => $per, 'coupan_id' => $cpn->id]);
                }

                $gtotal = $gtotal - $per;

            } elseif ($cpn->link_by == 'cart') {

                $cart = Cart::where('user_id', '=', Auth::user()->id)->get();

                $per = 0;

                foreach ($cart as $key => $c) {

                    $d = 0;

                    if ($cpn->distype == 'per') {

                        if ($c->semi_total != 0) {
                            $d = $c->semi_total * $cpn->amount / 100;
                            $per = $per + $d;
                        } else {
                            $d = $c->price_total * $cpn->amount / 100;
                            $per = $per + $d;
                        }

                    } else {

                        if ($c->semi_total != 0) {
                            $d = $cpn->amount / count($cart);
                            $per = $per + $d;
                        } else {
                            $d = $cpn->amount / count($cart);
                            $per = $per + $d;
                        }

                    }

                    Cart::where('id', '=', $c->id)
                        ->update(['distype' => 'cart', 'disamount' => $per, 'coupan_id' => $cpn->id]);

                }

                $gtotal = $gtotal - $per;

            }

        } elseif (!Auth::check() && Session::has('coupanapplied')) {

            require_once 'price.php';

            if (Session::get('coupanapplied')['appliedOn'] == 'product') {

                $cpn = Coupan::where('code', '=', Session::get('coupanapplied')['code'])->first();

                $cart = Session::get('cart');

                foreach ($cart as $key => $c) {

                    if ($cart[$key]['pro_id'] == $cpn->pro_id) {

                        if ($cpn->distype == 'per') {

                            if ($cart[$key]['varofferprice'] != 0) {

                                $per = ($cart[$key]['varofferprice'] * $cart[$key]['qty']) * $cpn->amount / 100;

                            } else {

                                $per = ($cart[$key]['varprice'] * $cart[$key]['qty']) * $cpn->amount / 100;

                            }

                        } else {
                            $per = $cpn->amount;
                        }

                        break;
                    }

                }

                $gtotal = $gtotal - $per;

                // Putting a session//
                Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'discount' => $per, 'msg' => "$cpn->code Applied Successfully !", 'appliedOn' => 'product']);

            } elseif (Session::get('coupanapplied')['appliedOn'] == 'category') {

                $cpn = Coupan::where('code', '=', Session::get('coupanapplied')['code'])->first();

                $cart = Session::get('cart');
                $catcart = collect();
                $per = 0;
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

                        $pro = Product::find($c['pro_id']);

                        if ($c['pro_id'] == $r['pro_id'] && $cpn->cat_id == $pro->category_id) {

                            $d = 0;

                            if ($cpn->distype == 'per') {

                                if ($r['varofferprice'] != 0) {
                                    $d = ($r['qty'] * $r['varofferprice']) * $cpn->amount / 100;
                                    $per = $per + $d;
                                } else {
                                    $d = ($r['qty'] * $r['varprice']) * $cpn->amount / 100;
                                    $per = $per + $d;
                                }

                            } else {
                                $d = $cpn->amount / count($catcart);
                                $per = $per + $d;
                            }

                            //UPDATE Session row //
                            $cart[$key]['discount'] = $d;
                            $cart[$key]['distype'] = 'category';
                            Session::put('cart', $cart);
                            // END //

                        }

                    }

                }

                //Return final total and discounted amount //

                $gtotal = $gtotal - $per;
                //Putting a session//
                Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'discount' => $per, 'msg' => "$cpn->code Applied Successfully !", 'appliedOn' => 'category']);

            } elseif (Session::get('coupanapplied')['appliedOn'] == 'cart') {

                $cpn = Coupan::where('code', '=', Session::get('coupanapplied')['code'])->first();

                $cart = Session::get('cart');
                $per = 0;

                foreach ($cart as $key => $c) {

                    $d = 0;

                    if ($cpn->distype == 'per') {

                        if ($c['varofferprice'] != 0) {
                            $d = ($c['varofferprice'] * $c['qty']) * $cpn->amount / 100;
                            $per = $per + $d;
                        } else {
                            $d = ($c['varprice'] * $c['qty']) * $cpn->amount / 100;
                            $per = $per + $d;
                        }

                    } else {

                        if ($c['varofferprice'] != 0) {
                            $d = $cpn->amount / count($cart);
                            $per = $per + $d;
                        } else {
                            $d = $cpn->amount / count($cart);
                            $per = $per + $d;
                        }

                    }

                    //UPDATE Session row //
                    $cart[$key]['discount'] = $d;
                    $cart[$key]['distype'] = 'cart';
                    Session::put('cart', $cart);
                    // END //

                }

                $gtotal = $gtotal - $per;
                //Putting again in session//
                Session::put('coupanapplied', ['code' => $cpn->code, 'cpnid' => $cpn->id, 'msg' => "$cpn->code Applied Successfully !", 'discount' => $per, 'appliedOn' => 'cart']);

            }

        }

        return response()->json(array(
            'per' => $per ?? NULL,
            'id' => $id,
            'noffertotal' => $noffertotal,
            'singletotal' => $singletotal,
            'pricetotal' => $pricetotal,
            'offertotal' => $offertotal,
            'pro_id' => $pro_id,
            'total' => $total,
            'gtotal' => $gtotal,
            'shipping' => $shipping,
            'variant_id' => $variant_id,
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    function empty() {
        $user = Auth::user()->id;

        $getusercart = Cart::where('user_id', $user)->get();

        foreach ($getusercart as $value) {
            $value->delete();
        }

        Session::forget('cart');
        Session::forget('coupanapplied');

        notify()
            ->success('Your cart is now empty');
        return redirect('/');

    }

    public function emptyCart($token)
    {
        if ($token) {
            Session::forget('cart');
            Session::forget('coupanapplied');
            notify()->success('Your cart is now empty !');
            return redirect('/');
        } else {
            notify()
                ->error('Invalid Token !');
            return back();
        }

    }

}
