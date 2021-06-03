<?php

namespace App\Http\Controllers\Api;

use App\AutoDetectGeo;
use App\Config;
use App\CurrencyCheckout;
use App\CurrencyList;
use App\CurrencyNew;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfigController extends Controller
{
    public function __construct()
    {
        $this->config = Config::first();
    }

    public function getConfigs(Request $request){

        $validator = Validator::make($request->all(),[
            'secret' => 'required'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
            if($errors->first('secret')){
                return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $configs = array();

        $configs = array(
            'available_currency' => $this->listOfCurrency(),
            'pincode_enable' => $this->config->pincode_system, 
            'geolocation_api' => 'AIzaSyAtkRQ5HYowiNYREE81yRXI49zOHYeM2v8'  
        );

        return response()->json($configs);

    }

    public function getPaymentMethods(Request $request){

            $validator = Validator::make($request->all(),[
                'secret' => 'required',
                'currency' => 'string|max:3|min:3'
            ]);

            $getsetting = array();

            if ($validator->fails()) {

                $errors = $validator->errors();
                
                if($errors->first('secret')){
                    return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
                }
    
                if($errors->first('currency')){
                    return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
                }
        
            }

            $settings =  AutoDetectGeo::first();

            if($settings->checkout_currency == '1'){

                // find the avilable payment methods

                $listcheckoutcurrency = CurrencyCheckout::where('currency',$request->currency)->first();

                foreach (explode(',',$listcheckoutcurrency->payment_method) as $key => $value) {
                    $methods[] = $value;
                }

               

                if(in_array('paypal',$methods)){

                    $getsetting[] = array(
                        'payment_method' => 'paypal',
                        'enable' => $this->config->paypal_enable ? 1 : 0,
                        'PAYPAL_CLIENT_ID' => env('PAYPAL_CLIENT_ID'),
                        'PAYPAL_SECRET' => env('PAYPAL_SECRET'),
                        'PAYPAL_MODE' => env('PAYPAL_MODE'),
                        'logo' => url('images/payment/paypal.png')
                    );
                }

                if(in_array('stripe',$methods)){

                    $getsetting[] = array(
                        'payment_method' => 'stripe',
                        'enable' =>  $this->config->stripe_enable ? 1 : 0,
                        'STRIPE_KEY' => env('STRIPE_KEY'),
                        'STRIPE_SECRET' => env('STRIPE_SECRET'),
                        'logo' => url('images/payment/stripe.png')
                    );
                }

                if(in_array('braintree',$methods)){

                    $getsetting[] = array(
                        'payment_method' => 'paytm',
                        'enable' => $this->config->paytm_enable ? 1 : 0,
                        'PAYTM_ENVIRONMENT' => env('PAYTM_ENVIRONMENT'),
                        'PAYTM_MERCHANT_ID' => env('PAYTM_MERCHANT_ID'),
                        'PAYTM_MERCHANT_KEY' => env('PAYTM_MERCHANT_KEY'),
                        'PAYTM_MERCHANT_WEBSITE' => env('PAYTM_MERCHANT_WEBSITE'),
                        'PAYTM_CHANNEL' => env('PAYTM_CHANNEL'),
                        'PAYTM_INDUSTRY_TYPE' => env('PAYTM_INDUSTRY_TYPE'),
                        'logo' => url('images/payment/braintree.png')
                    );
                }

                if(in_array('paystack',$methods)){

                    $getsetting[] = array(
                        'payment_method' => 'paystack',
                        'enable' => $this->config->paystack_enable ? 1 : 0,
                        'PAYSTACK_PUBLIC_KEY' => env('PAYSTACK_PUBLIC_KEY'),
                        'PAYSTACK_SECRET_KEY' => env('PAYSTACK_SECRET_KEY'),
                        'PAYSTACK_PAYMENT_URL' => env('PAYSTACK_PAYMENT_URL'),
                        'logo' => url('images/payment/braintree.png')
                    );
                }

                if(in_array('razorpay',$methods)){

                    $getsetting[] = array(
                        'payment_method' => 'razorpay',
                        'enable' => $this->config->razorpay ? 1 : 0,
                        'RAZOR_PAY_KEY' => env('RAZOR_PAY_KEY'),
                        'RAZOR_PAY_SECRET' => env('RAZOR_PAY_SECRET'),
                        'logo' => url('images/payment/razorpay.png')
                    );
                }

                if(in_array('paytm',$methods)){

                    $getsetting[] = array(
                        'payment_method' => 'paytm',
                        'enable' => $this->config->paytm ? 1 : 0,
                        'PAYTM_ENVIRONMENT' => env('PAYTM_ENVIRONMENT'),
                        'PAYTM_MERCHANT_ID' => env('PAYTM_MERCHANT_ID'),
                        'PAYTM_MERCHANT_KEY' => env('PAYTM_MERCHANT_KEY'),
                        'PAYTM_MERCHANT_WEBSITE' => env('PAYTM_MERCHANT_WEBSITE'),
                        'PAYTM_CHANNEL' => env('PAYTM_CHANNEL'),
                        'PAYTM_INDUSTRY_TYPE' => env('PAYTM_INDUSTRY_TYPE'),
                        'logo' => url('images/payment/paytm.png')
                    );
                }

                if(in_array('paymoney',$methods)){

                    $getsetting[] = array(
                        'payment_method' => 'paymoney',
                        'enable' => $this->config->payu_enable ? 1 : 0,
                        'PAYU_METHOD' => env('PAYU_METHOD'),
                        'PAYU_DEFAULT' => env('PAYU_DEFAULT'),
                        'PAYU_MERCHANT_KEY' => env('PAYU_MERCHANT_KEY'),
                        'PAYU_MERCHANT_SALT' => env('PAYU_MERCHANT_SALT'),
                        'PAYU_AUTH_HEADER' => env('PAYU_AUTH_HEADER'),
                        'PAY_U_MONEY_ACC' => env('PAY_U_MONEY_ACC'),
                        'PAYU_REFUND_URL' => env('PAYU_REFUND_URL'),
                        'logo' => url('images/payment/payumoney.png')
                    );
                }


            }else{
                
                $getsetting[] = array(
                    'payment_method' => 'paypal',
                    'enable' => $this->config->paypal_enable ? 1 : 0,
                    'PAYPAL_CLIENT_ID' => env('PAYPAL_CLIENT_ID'),
                    'PAYPAL_SECRET' => env('PAYPAL_SECRET'),
                    'PAYPAL_MODE' => env('PAYPAL_MODE'),
                    'logo' => url('images/payment/paypal.png')
                );

                $getsetting[] = array(
                    'payment_method' => 'stripe',
                    'enable' =>  $this->config->stripe_enable ? 1 : 0,
                    'STRIPE_KEY' => env('STRIPE_KEY'),
                    'STRIPE_SECRET' => env('STRIPE_SECRET'),
                    'logo' => url('images/payment/stripe.png')
                );

                $getsetting[] = array(
                    'payment_method' => 'paytm',
                    'enable' => $this->config->paytm_enable ? 1 : 0,
                    'PAYTM_ENVIRONMENT' => env('PAYTM_ENVIRONMENT'),
                    'PAYTM_MERCHANT_ID' => env('PAYTM_MERCHANT_ID'),
                    'PAYTM_MERCHANT_KEY' => env('PAYTM_MERCHANT_KEY'),
                    'PAYTM_MERCHANT_WEBSITE' => env('PAYTM_MERCHANT_WEBSITE'),
                    'PAYTM_CHANNEL' => env('PAYTM_CHANNEL'),
                    'PAYTM_INDUSTRY_TYPE' => env('PAYTM_INDUSTRY_TYPE'),
                    'logo' => url('images/payment/paytm.png')
                );

                $getsetting[] = array(
                    'payment_method' => 'paystack',
                    'enable' => $this->config->paystack_enable ? 1 : 0,
                    'PAYSTACK_PUBLIC_KEY' => env('PAYSTACK_PUBLIC_KEY'),
                    'PAYSTACK_SECRET_KEY' => env('PAYSTACK_SECRET_KEY'),
                    'PAYSTACK_PAYMENT_URL' => env('PAYSTACK_PAYMENT_URL'),
                    'logo' => url('images/payment/braintree.png')
                );

                $getsetting[] = array(
                    'payment_method' => 'razorpay',
                    'enable' => $this->config->razorpay ? 1 : 0,
                    'RAZOR_PAY_KEY' => env('RAZOR_PAY_KEY'),
                    'RAZOR_PAY_SECRET' => env('RAZOR_PAY_SECRET'),
                    'logo' => url('images/payment/razorpay.png')
                );

                $getsetting[] = array(
                    'payment_method' => 'paymoney',
                    'enable' => $this->config->payu_enable ? 1 : 0,
                    'PAYU_METHOD' => env('PAYU_METHOD'),
                    'PAYU_DEFAULT' => env('PAYU_DEFAULT'),
                    'PAYU_MERCHANT_KEY' => env('PAYU_MERCHANT_KEY'),
                    'PAYU_MERCHANT_SALT' => env('PAYU_MERCHANT_SALT'),
                    'PAYU_AUTH_HEADER' => env('PAYU_AUTH_HEADER'),
                    'PAY_U_MONEY_ACC' => env('PAY_U_MONEY_ACC'),
                    'PAYU_REFUND_URL' => env('PAYU_REFUND_URL'),
                    'logo' => url('images/payment/payumoney.png')
                );
                

            }
            
           

            $otherpayments[] = array(
                'name' => 'Cash On Delivery',
                'enable' => (int) env('COD_ENABLE')
            );

            $otherpayments[] = array(
                'name' => 'Bank Transfer',
                'enable' => (int) env('BANK_TRANSFER'),
            );
            
            return response()->json(['online_payments' => $getsetting, 'other_options' => $otherpayments]);
        

    }


    public function listOfCurrency(){

        $currency = array();


        foreach (CurrencyNew::all() as $key => $c) {

           

            $currency[] = array(

                'code' => $c->code,
                'name' => $c->name,
                'symbol' => $c->symbol,
                'rate' => $c->exchange_rate,
                'is_default' => isset($c->currency) && $c->currency->default_currency == 1 ? 1 : 0,

            );
        }

        return $currency;

    }
}
