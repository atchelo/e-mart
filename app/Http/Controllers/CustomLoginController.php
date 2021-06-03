<?php
namespace App\Http\Controllers;

use App\AddSubVariant;
use App\Cart;
use App\Coupan;
use App\Product;
use Auth;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Redirect;
use Session;

class CustomLoginController extends Controller
{
    use ThrottlesLogins;

    protected $maxAttempts = 3;
    protected $decayMinutes = 1;


    public function doLogin(Request $request)
    {

        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password'),

            'is_verified' => 1, 'status' => 1], $request->remember)) {

            /*Check if user has item in his cart*/
            if (!empty(Session::get('cart'))) {
                $this->cartitem();
            }

            return redirect()->intended('/');

        } else {
            
            $errors = new MessageBag(['email' => 'Email or password is invalid or your account is deactive/ unverified !']);
            return Redirect::back()->withErrors($errors)->withInput($request->except('password'));

        }
    }

    public function cartitem()
    {

        $SessionCart = Session::get('cart');

        foreach ($SessionCart as $key => $c) {

            $venderid = Product::find($c['pro_id']);

            if (count(Auth::user()->cart) > 0) {

                $x = Cart::where('variant_id', $SessionCart[$key]['variantid'])->first();

                if (isset($x)) {

                    $findvar = AddSubVariant::find($c['variantid']);

                    if ($findvar->max_order_qty == '') {

                        if ($findvar->stock > 0) {

                            $newqty = $x->qty + $c['qty'];
                            $newofferprice = $c['qty'] * $c['varofferprice'];
                            $newprice = $c['qty'] * $c['varprice'];

                            Cart::where('user_id', Auth::user()->id)
                                ->where('variant_id', $c['variantid'])->update(['qty' => $newqty, 'semi_total' => $newofferprice, 'price_total' => $newprice]);

                        }

                    }

                } else {

                    $cart = new Cart;
                    $cart->user_id = Auth::user()->id;
                    $cart->qty = $c['qty'];
                    $cart->pro_id = $c['pro_id'];
                    $cart->variant_id = $c['variantid'];
                    $cart->ori_price = $c['varprice'];
                    $cart->ori_offer_price = $c['varofferprice'];
                    $cart->semi_total = $c['qty'] * $c['varofferprice'];
                    $cart->price_total = $c['qty'] * $c['varprice'];
                    $cart->vender_id = $venderid->vender_id;
                    $cart->save();

                }

            } else {

                $cart = new Cart;
                $cart->user_id = Auth::user()->id;
                $cart->qty = $c['qty'];
                $cart->pro_id = $c['pro_id'];
                $cart->variant_id = $c['variantid'];
                $cart->ori_price = $c['varprice'];
                $cart->ori_offer_price = $c['varofferprice'];
                $cart->semi_total = $c['qty'] * $c['varofferprice'];
                $cart->price_total = $c['qty'] * $c['varprice'];
                $cart->vender_id = $venderid->vender_id;
                $cart->save();

            }

        }

        if (session()->has('coupanapplied')) {

            $cpn = Coupan::firstWhere('code', '=', session()->get('coupanapplied')['code']);

            if (isset($cpn)) {

                $applycoupan = new CouponApplyController;

                if (session()->get('coupanapplied')['appliedOn'] == 'category') {
                    $applycoupan->validCouponForCategory($cpn);
                }

                if (session()->get('coupanapplied')['appliedOn'] == 'cart') {
                    $applycoupan->validCouponForCart($cpn);
                }

                if (session()->get('coupanapplied')['appliedOn'] == 'product') {
                    $applycoupan->validCouponForProduct($cpn);
                }

                Session::forget('coupanapplied');
            }

        }

        //Clearing the guest cart
        Session::forget('cart');

    }
}
