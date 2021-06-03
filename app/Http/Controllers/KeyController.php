<?php
namespace App\Http\Controllers;

use App\BankDetail;
use App\Config;
use Illuminate\Http\Request;
use DotenvEditor;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Developer : Ankit             =
=            Copyright (c) 2020            =
==========================================*/

class KeyController extends Controller
{

    protected $config;

    public function __construct()
    {
        $this->config = Config::first();
    }

    public function saveamarpaysettings(Request $request){

        $input = $request->all();

        $env_keys_save = DotenvEditor::setKeys([
            
            'AAMARPAY_STORE_ID' => $input['AAMARPAY_STORE_ID'], 
            'AAMARPAY_KEY' => $input['AAMARPAY_KEY'],
            'AAMARPAY_SANDBOX' => $request->AAMARPAY_SANDBOX ? "true" : "false"

        ]);

        $env_keys_save->save();

        $this->config->enable_amarpay = isset($request->enable_amarpay) ? 1 : 0;
        $this->config->save();

        return back()->with('added','AAMARPAY settings has been updated !');
    }

    public function paymentsettings()
    {
        $bank = BankDetail::first();
        return view('admindesk.payment_settings.index', compact('bank'));
    }

    public function paystackUpdate(Request $request){

        $input = $request->all();

        $env_keys_save = DotenvEditor::setKeys([
            'PAYSTACK_PUBLIC_KEY' => $input['PAYSTACK_PUBLIC_KEY'], 
            'PAYSTACK_SECRET_KEY' => $input['PAYSTACK_SECRET_KEY'], 
            'PAYSTACK_PAYMENT_URL' => $input['PAYSTACK_PAYMENT_URL'],
            'MERCHANT_EMAIL' => $input['MERCHANT_EMAIL']
        ]);

        $env_keys_save->save();

        $this->config->paystack_enable = isset($request->paystack_enable) ? 1 : 0;
        $this->config->save();
        return back()->with('added','Paystack settings has been updated !');
    }

    public function sslcommerzeUpdate(Request $request){

        $input = $request->all();

        $env_keys_save = DotenvEditor::setKeys([
            'API_DOMAIN_URL' => $input['API_DOMAIN_URL'], 
            'STORE_ID' => $input['STORE_ID'], 
            'STORE_PASSWORD' => $input['STORE_PASSWORD'],
            'IS_LOCALHOST' => isset($request->IS_LOCALHOST) ? 'true' : 'false',
            'SANDBOX_MODE' => isset($request->SANDBOX_MODE) ? 'true' : 'false',
        ]);

        $env_keys_save->save();

        $this->config->sslcommerze_enable = isset($request->sslcommerze_enable) ? 1 : 0;
        $this->config->save();
        notify()->success('SSLCommerze settings has been updated !');
        return back();
    }

    public function iyzicoUpdate(Request $request){

        $request->validate([
            'IYZIPAY_BASE_URL' => 'required',
            'IYZIPAY_API_KEY' => 'required',
            'IYZIPAY_SECRET_KEY' => 'required'
        ],[
            'IYZIPAY_BASE_URL.required' => 'IYZIPAY Base url is required',
            'IYZIPAY_API_KEY.required' => 'IYZIPAY api key is required',
            'IYZIPAY_SECRET_KEY.required' => 'IYZIPAY secret key is required'
        ]);

        $input = $request->all();


        $env_keys_save = DotenvEditor::setKeys([
            'IYZIPAY_BASE_URL' => $input['IYZIPAY_BASE_URL'], 
            'IYZIPAY_API_KEY' => $input['IYZIPAY_API_KEY'], 
            'IYZIPAY_SECRET_KEY' => $input['IYZIPAY_SECRET_KEY']
        ]);

        $env_keys_save->save();

        $this->config->iyzico_enable = isset($request->iyzico_enable) ? 1 : 0;
        $this->config->save();
        notify()->success('iyzico Payment settings has been updated !');
        return back();

    }

    public function updatePaytm(Request $request)
    {
        $input = $request->all();

        $env_keys_save = DotenvEditor::setKeys([
            'PAYTM_ENVIRONMENT' => $input['PAYTM_ENVIRONMENT'], 'PAYTM_MERCHANT_ID' => $input['PAYTM_MERCHANT_ID'], 'PAYTM_MERCHANT_KEY' => $input['PAYTM_MERCHANT_KEY'],
        ]);

        $env_keys_save->save();

        $this->config->paytm_enable = isset($request->paytmchk) ? 1 : 0;

        $this->config->save();

        return back()
            ->with('updated', 'Paytm settings has been updated !');
    }

    public function updaterazorpay(Request $request)
    {
        $input = $request->all();

        $env_keys_save = DotenvEditor::setKeys([
            'RAZOR_PAY_KEY' => $input['RAZOR_PAY_KEY'], 
            'RAZOR_PAY_SECRET' => $input['RAZOR_PAY_SECRET'],
        ]);

        $env_keys_save->save();

        $this->config->razorpay = isset($request->rpaycheck ) ? 1 : 0;

        $this->config->save();

        return back()
            ->with('updated', 'Razorpay settings has been updated !');

    }

    public function saveStripe(Request $request)
    {
        $input = $request->all();

        $env_keys_save = DotenvEditor::setKeys([
            'STRIPE_KEY' => $input['STRIPE_KEY'],
            'STRIPE_SECRET' => $input['STRIPE_SECRET'],
        ]);

        $env_keys_save->save();

        $this->config->stripe_enable = isset($request->strip_check) ? "1" : "0";

        $this->config->save();

        return back()->with('updated', 'Stripe settings has been updated !');
    }

    public function saveBraintree(Request $request)
    {
        $input = $request->all();

        $env_keys_save = DotenvEditor::setKeys([
            'BRAINTREE_ENV' => $input['BRAINTREE_ENV'],
            'BRAINTREE_MERCHANT_ID' => $input['BRAINTREE_MERCHANT_ID'],
            'BRAINTREE_PUBLIC_KEY' => $input['BRAINTREE_PUBLIC_KEY'],
            'BRAINTREE_PRIVATE_KEY' => $input['BRAINTREE_PRIVATE_KEY'],
            'BRAINTREE_MERCHANT_ACCOUNT_ID' => $input['BRAINTREE_MERCHANT_ACCOUNT_ID']
        ]);

        $env_keys_save->save();

        $this->config->braintree_enable = isset($request->braintree_enable) ? "1" : "0";

        $this->config->save();

        return back()->with('updated', 'Stripe settings has been updated !');
    }

    public function savePaypal(Request $request)
    {

        $input = $request->all();


        $env_keys_save = DotenvEditor::setKeys([

            'PAYPAL_CLIENT_ID' => $input['PAYPAL_CLIENT_ID'], 
            'PAYPAL_SECRET' => $input['PAYPAL_SECRET'], 
            'PAYPAL_MODE' => $input['PAYPAL_MODE'],

        ]);

        $env_keys_save->save();

        $this->config->paypal_enable = isset($request->paypal_check) ? 1 : 0;

        $this->config->save();

        return back()->with('updated', 'Paypal settings has been updated !');

    }

    public function payhereUpdate(Request $request){

        $this->config->payhere_enable = isset($request->payhere_enable) ? 1 : 0;

        $env_keys_save = DotenvEditor::setKeys([

            'PAYHERE_BUISNESS_APP_CODE' => $request['PAYHERE_BUISNESS_APP_CODE'],
            'PAYHERE_APP_SECRET' => $request['PAYHERE_APP_SECRET'],
            'PAYHERE_MERCHANT_ID' => $request['PAYHERE_MERCHANT_ID'],
            'PAYHERE_MODE' => isset($request['PAYHERE_MODE']) ? 'live' : 'sandbox',

        ]);

        $env_keys_save->save();

        $this->config->save();

        return back()->with('added', 'Payhere Setting has been updated !');

    }

    public function instamojoupdate(Request $request)
    {

        $input = $request->all();

        $this->config->instamojo_enable = isset($request->instam_check) ? 1 : 0;


        $env_keys_save = DotenvEditor::setKeys([

            'IM_API_KEY' => $input['IM_API_KEY'],
            'IM_AUTH_TOKEN' => $input['IM_AUTH_TOKEN'],
            'IM_URL' => $input['IM_URL'],
            'IM_REFUND_URL' => $input['IM_REFUND_URL'],
        ]);

        $env_keys_save->save();

        $this->config->save();

        return back()->with('added', 'Instamojo Setting has been updated !');

    }

    public function payuupdate(Request $request)
    {
        $input = $request->all();

        $this->config->payu_enable = isset($request->payu_chk) ? 1 : 0;

        $env_keys_save = DotenvEditor::setKeys([

            'PAYU_METHOD' => $input['PAYU_METHOD'],
            'PAYU_DEFAULT' => $input['PAYU_DEFAULT'],
            'PAYU_MERCHANT_KEY' => $input['PAYU_MERCHANT_KEY'],
            'PAYU_MERCHANT_SALT' => $input['PAYU_MERCHANT_SALT'],
            'PAYU_AUTH_HEADER' => $input['PAYU_AUTH_HEADER'],
            'PAY_U_MONEY_ACC' => isset($request->PAY_U_MONEY_ACC) ? "true" : "false",
            'PAYU_REFUND_URL' => $input['PAYU_REFUND_URL'],

        ]);

        $env_keys_save->save();

        $this->config->save();

        return back()
            ->with('updated', 'PayUMoney payment settings has been updated !');

    }

    public function updateCashfree(Request $request){

        $input = $request->all();

        $this->config->cashfree_enable = isset($request->cashfree_enable) ? 1 : 0;

        $env_keys_save = DotenvEditor::setKeys([

            'CASHFREE_APP_ID' => $input['CASHFREE_APP_ID'],
            'CASHFREE_SECRET_KEY' => $input['CASHFREE_SECRET_KEY'],
            'CASHFREE_END_POINT' => $input['CASHFREE_END_POINT'],

        ]);

        $env_keys_save->save();

        $this->config->save();
        notify()->success('Cashfree payment settings has been updated !');
        return back();
    }

    public function updateSkrill(Request $request){

        $input = $request->all();

        $this->config->skrill_enable = isset($request->skrill_enable) ? 1 : 0;

        $env_keys_save = DotenvEditor::setKeys([

            'SKRILL_MERCHANT_EMAIL' => $input['SKRILL_MERCHANT_EMAIL'],
            'SKRILL_API_PASSWORD' => $input['SKRILL_API_PASSWORD']

        ]);

        $env_keys_save->save();

        $this->config->save();
        notify()->success('Skrill payment settings has been updated !');
        return back();
    }

    public function updateOmise(Request $request){

        $input = $request->all();

        $this->config->omise_enable = isset($request->omise_enable) ? 1 : 0;


        $env_keys_save = DotenvEditor::setKeys([

            'OMISE_PUBLIC_KEY' => $input['OMISE_PUBLIC_KEY'],
            'OMISE_SECRET_KEY' => $input['OMISE_SECRET_KEY'],
            'OMISE_API_VERSION' => $input['OMISE_API_VERSION']

        ]);

        $env_keys_save->save();

        $this->config->save();
        notify()->success('Omise payment settings has been updated !');
        return back();
    }

    public function updateMoli(Request $request){

        $input = $request->all();

        $this->config->moli_enable = isset($request->moli_enable) ? 1 : 0;

        $env_keys_save = DotenvEditor::setKeys([

            'MOLLIE_KEY' => $input['MOLLIE_KEY']

        ]);

        $env_keys_save->save();

        $this->config->save();
        notify()->success('Mollie payment settings has been updated !');
        return back();
    }

    public function updateRave(Request $request){

        $input = $request->all();

        $this->config->rave_enable = isset($request->rave_enable) ? 1 : 0;

        $env_keys_save = DotenvEditor::setKeys([

            'RAVE_PUBLIC_KEY' => $input['RAVE_PUBLIC_KEY'],
            'RAVE_SECRET_KEY' => $input['RAVE_SECRET_KEY'],
            'RAVE_ENVIRONMENT' => isset($request->RAVE_ENVIRONMENT) ? 'live' : 'staging',
            'RAVE_LOGO' => $input['RAVE_LOGO'],
            'RAVE_PREFIX' => $input['RAVE_PREFIX'],
            'RAVE_COUNTRY' => $input['RAVE_COUNTRY']

        ]);

        $env_keys_save->save();

        $this->config->save();
        notify()->success('Rave payment settings has been updated !');
        return back();
    }

}
