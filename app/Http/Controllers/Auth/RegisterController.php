<?php

namespace App\Http\Controllers\Auth;

use App\Affilate;
use App\Cart;
use App\Coupan;
use App\Genral;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CouponApplyController;
use App\Product;
use App\User;
use Arcanedev\NoCaptcha\Rules\CaptchaRule;
use Auth;
use Carbon\Carbon;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Session;

class RegisterController extends Controller
{

    private $setting;

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->setting = Genral::first();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function register(Request $request)
    {

        if ($this->setting->captcha_enable == 1) {

            $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6|confirmed',
                    'phonecode' => 'required|numeric',
                    'mobile' => 'numeric|unique:users,mobile',
                    'eula' => 'required',
                    'g-recaptcha-response' => ['required', new CaptchaRule],
            ], [
                    'g-recaptcha-response.required' => 'Please check the captcha !',
                    'mobile.unique' => 'Mobile no is already taken !',
                    'phonecode' => 'Phonecode is required',
                    'mobile.numeric' => 'Mobile no should be numeric !',
                    'eula.required' => 'Please accept terms and condition !'
                ]
            );

        } else {

            $request->validate([

                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'mobile' => 'numeric|unique:users,mobile',
                'eula' => 'required',
                'phonecode' => 'required|numeric'
            ], [
                'mobile.unique' => 'Mobile no is already taken !',
                'mobile.numeric' => 'Mobile no should be numeric !',
                'eula.required' => 'Please accept terms and condition !',
                'phonecode' => 'Phonecode is required',
            ]);

        }

        $af_system = Affilate::first();

        if($af_system && $af_system->enable_affilate == '1'){

            $findreferal = User::firstWhere('refer_code',$request->refer_code);

            if(!$findreferal){

                return back()->withInput()->withErrors([
                    'refercode' => 'Refer code is invalid !'
                ]);

            }

        }

        $user = User::create([
            'name'      => $request['name'],
            'email'     => $request['email'],
            'mobile'    => $request['mobile'],
            'phonecode' => $request['phonecode'],
            'password'  => Hash::make($request['password']),
            'email_verified_at' => $this->setting->email_verify_enable == '1' ? NULL : Carbon::now(),
            'is_verified' => 1,
            'refered_from' => $af_system && $af_system->enable_affilate == '1' ? $request['refer_code'] : NULL
        ]);

        if($af_system && $af_system->enable_affilate == '1'){

            $findreferal->getReferals()->create([
                'log' => 'Refer successfull',
                'refer_user_id' => $user->id,
                'user_id' => $findreferal->id,
                'amount' => $af_system->refer_amount,
                'procces' => $af_system->enable_purchase == 1 ? 0 : 1
            ]);

            if($af_system->enable_purchase == 0){

                if(isset($findreferal->wallet) && $findreferal->wallet->status == 1){

                    $findreferal->wallet()->update([
                        'balance' => $findreferal->wallet->balance + $af_system->refer_amount
                    ]);

                    $findreferal->wallet->wallethistory()->create([
                        'type' => 'Credit',
                        'log' => 'Referal bonus',
                        'amount' => $af_system->refer_amount,
                        'txn_id' => str_random(8),
                        'expire_at' => date("Y-m-d", strtotime(date('Y-m-d').'+365 days'))
                    ]);

                }



            }

        }

        if (session()->has('cart')) {

            foreach (session()->get('cart') as $c) {

                $product = Product::find($c['pro_id']);

                if(isset($product)){
                    $cart = new Cart;
                    $cart->user_id = $user->id;
                    $cart->qty = $c['qty'];
                    $cart->pro_id = $c['pro_id'];
                    $cart->variant_id = $c['variantid'];
                    $cart->ori_price = $c['varprice'];
                    $cart->ori_offer_price = $c['varofferprice'];
                    $cart->semi_total = $c['qty'] * $c['varofferprice'];
                    $cart->price_total = $c['qty'] * $c['varprice'];
                    $cart->vender_id = $product->vender_id;
                    $cart->save();
                }
            }

        }

        

        session()->forget('cart');

        if($this->setting->email_verify_enable == '1'){

            $user->sendEmailVerificationNotification();
    
        }

        Auth::login($user);

        if(session()->has('coupanapplied')){

            $cpn = Coupan::firstWhere('code','=',session()->get('coupanapplied')['code']);

            if(isset($cpn)){

                $applycoupan = new CouponApplyController;

                if(session()->get('coupanapplied')['appliedOn'] == 'category'){
                    $applycoupan->validCouponForCategory($cpn);
                }

                if(session()->get('coupanapplied')['appliedOn'] == 'cart'){
                    $applycoupan->validCouponForCart($cpn);
                }

                if(session()->get('coupanapplied')['appliedOn'] == 'product'){
                    $applycoupan->validCouponForProduct($cpn);
                }

                Session::forget('coupanapplied');
            }

        }

        return redirect('/');

    }


}
