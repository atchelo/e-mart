<?php

namespace App\Http\Controllers\Subs;

use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\CurrencyNew;
use App\FailedTranscations;
use App\Http\Controllers\Controller;
use App\SellerPlans;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->defaultCurrency = CurrencyNew::with(['currencyextract'])->whereHas('currencyextract', function ($query) {

            return $query->where('default_currency', '1');

        })->first();

        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this
            ->_api_context
            ->setConfig($paypal_conf['settings']);

    }

    public function paytm(Request $request){

        if(session()->get('currency')['id'] != 'INR'){
            notify()->error('ONLY INR currency supported in Paytm');
            return back();
        }

        $orderID = uniqid();

        $plan = SellerPlans::where('status','1')->where('unique_id',Crypt::decrypt($request->plan_id))->first();

        $amount = sprintf("%.2f",currency($plan->price, $from = $this->defaultCurrency->code, $to = session()->get('currency')['id'] , $format = false));

        $payment = PaytmWallet::with('receive');

        Cookie::queue('plan',$plan);

        $payment->prepare([
            'order' => $orderID,
            'user' => auth()->id(),
            'mobile_number' => auth()->user()->mobile,
            'email' => auth()->user()->email,
            'amount' => $amount,
            'callback_url' => route('pay.subscription.paytm.success'),
        ]);

        return $payment->receive();
        
    }

    public function paytmsuccess(Request $request){

        $transaction = PaytmWallet::with('receive');
        $response    = $transaction->response();

        $plan =  json_decode(Cookie::get('plan'),true);

        if ($transaction->isSuccessful()) {
            
            $txn_id  = $response['TXNID'];

            $subs = $this->createsubscription($plan,$txn_id,$paidamount = $response['TXNAMOUNT'],$method = 'Paytm',$user = auth()->user());

            auth()->user()->update([
                'subs_id' => $subs->id
            ]);

            notify()->success('Payment successfull',$txn_id);

            return redirect('/');


        } elseif ($transaction->isFailed()) {

            notify()->error($transaction->getResponseMessage());
            $failedTranscations = new FailedTranscations();
            $failedTranscations->txn_id = 'SELLER_PLANS_PAYTM_FAILED_' . str_random(5);
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            return back();

        } elseif ($transaction->isOpen()) {
            //Transaction Open/Processing

        } else {

            notify()->error($transaction->getResponseMessage());
            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = 'SELLER_PLANS_PAYTM_FAILED_' . str_random(5);
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            return back();

        }
    }

    public function razorpay(Request $request){

        $input = $request->all();

        $api = new Api(env('RAZOR_PAY_KEY'), env('RAZOR_PAY_SECRET'));

        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try
            {

                $response = $api
                    ->payment
                    ->fetch($input['razorpay_payment_id'])->capture(array(
                    'amount' => $payment['amount'],
                ));

                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                $txn_id = $payment->id;
                $plan = SellerPlans::where('status','1')->where('unique_id',Crypt::decrypt($request->plan_id))->first();

                $subs = $this->createsubscription($plan,$txn_id,$paidamount = $payment->amount / 100,$method = 'Razorpay',$user = auth()->user());

                auth()->user()->update([
                    'subs_id' => $subs->id
                ]);

                notify()->success('Payment successfull',$txn_id);

                return redirect('/');

                

            } catch (\Exception $e) {
                notify()->error($e->getMessage());
                $failedTranscations = new FailedTranscations;
                $failedTranscations->order_id = $input['razorpay_payment_id'];
                $failedTranscations->txn_id = $input['razorpay_payment_id'];
                $failedTranscations->user_id = auth()->id();
                $failedTranscations->save();
                return back();
            }

        }


    }

    public function paypal(Request $request){

        if(session()->get('currency')['id'] == 'INR'){
            notify()->error('INR currency not supported in PAYPAL TEST MODE');
            return back();
        }

        $orderID = uniqid();

        $plan = SellerPlans::where('status','1')->where('unique_id',Crypt::decrypt($request->plan_id))->first();
        Cookie::queue('plan',$plan);
        $payout = sprintf("%.2f",currency($plan->price, $from = $this->defaultCurrency->code, $to = session()->get('currency')['id'] , $format = false));

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('Payment For Plan '.$plan->name)
        /** item name **/
            ->setCurrency(session()->get('currency')['id'])->setQuantity(1)
            ->setPrice($payout);
        /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array(
            $item_1,
        ));
        $amount = new Amount();
        $amount->setCurrency(session()->get('currency')['id'])->setTotal($payout);
        $transaction = new Transaction();
        $transaction->setAmount($amount)->setItemList($item_list)->setDescription('Payment for order');
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('/pay/for/subscription/paypal/success'))
            ->setCancelUrl(url('seller/plans'));
        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)->setRedirectUrls($redirect_urls)->setTransactions(array(
            $transaction,
        ));

        try
        {
            $payment->create($this->_api_context);
        } catch (\Exception $e) {
           
                notify()->error($e->getMessage());
                $failedTranscations = new FailedTranscations;
                $failedTranscations->order_id = $orderID;
                $failedTranscations->txn_id = 'PAYPAL_SELLER_PLAN_FAILED_' . str_random(5);
                $failedTranscations->user_id = auth()->id();
                $failedTranscations->save();

                return back();
            
        }
        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }
        /** add payment ID to session **/
        Cookie::queue('txn_id', $payment->getId());
        if (isset($redirect_url)) {
            /** redirect to paypal **/
            return Redirect::away($redirect_url);
        }
        notify()->error('Unknown error occurred !');
        return back();


    }

    public function paypalSuccess(Request $request){

       

        $txn_id = Cookie::get('txn_id');
        $plan =  json_decode(Cookie::get('plan'),true);

        if (empty($request->get('PayerID')) || empty($request->get('token'))) {
           
            notify()->error('Payment Failed !');

            $failedTranscations = new FailedTranscations;
            $failedTranscations->order_id = uniqid();
            $failedTranscations->txn_id = 'PAYPAL_SELLER_PLAN_FAILED_' . str_random(5);
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();

            return redirect('/seller/plans');
        }

        $payment = Payment::get($txn_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->get('PayerID'));
        /**Execute the payment **/
        $response = $payment->execute($execution, $this->_api_context);

     

        if ($response->getState() == 'approved') {

            $transactions = $payment->getTransactions();
            $relatedResources = $transactions[0]->getRelatedResources();
            $sale = $relatedResources[0]->getSale();

            $subs = $this->createsubscription($plan,$txn_id,$paidamount = $sale->amount->total,$method = 'Paypal',$user = auth()->user());

            auth()->user()->update([
                'subs_id' => $subs->id
            ]);

            Cookie::queue(Cookie::forget('txn_id'));

            notify()->success('Payment successfull',$txn_id);

            return redirect('/');

            
            /*End*/

        } else {
            notify()->error("Payment Failed !");
            $failedTranscations = new FailedTranscations;
            $failedTranscations->order_id = $request->token;
            $failedTranscations->txn_id = 'PAYPAL_SELLER_PLAN_FAILED_' . str_random(5);
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            return redirect('/seller/plans');
        }

    }

    public function stripe(Request $request){

        $expiry = explode('/', $request->expiry);

        $request->validate([
            'number' => 'required',
            'expiry' => 'required',
            'cvc' => 'required|max:3',
        ]);

        $input = $request->all();

        $input = array_except($input, array('_token'));

        $stripe = Stripe::make(env('STRIPE_SECRET'));

        if ($stripe == '' || $stripe == null) {
            notify()->error("Stripe keys are not updated !");
            return back();
        }

        $plan = SellerPlans::where('status','1')->where('unique_id',Crypt::decrypt($request->plan_id))->first();
        $amount = sprintf("%.2f",currency($plan->price, $from = $this->defaultCurrency->code, $to = session()->get('currency')['id'] , $format = false));

        try {

            $month = (int) $expiry[0];
            $year = (int) $expiry[1];

            $token = $stripe->tokens()->create([
                'card' => [
                    'number' => $request->get('number'),
                    'exp_month' => $month,
                    'exp_year' => $year,
                    'cvc' => $request->get('cvc'),
                ],
            ]);

            if (!isset($token['id'])) {
                notify()->error('The Stripe token was not generated correctly !');
                return back();
            }

            $charge = $stripe->charges()->create([
                'card' => $token['id'],
                'currency' => session()->get('currency')['id'],
                'amount' => $amount,
                'description' => "Payment For Plan $plan->name",
            ]);

            if ($charge['status'] == 'succeeded') {

                $txn_id = $charge['id'];

                $subs = $this->createsubscription($plan,$txn_id,$paidamount = $amount,$method = 'Stripe',$user = auth()->user());

                auth()->user()->update([
                    'subs_id' => $subs->id
                ]);
    
                notify()->success('Payment successfull',$txn_id);
    
                return redirect('/');

            }else{

                $failedTranscations = new FailedTranscations;
                $failedTranscations->txn_id = 'STRIPE_SELLER_PLANS_FAILED_' . str_random(5);
                $failedTranscations->user_id = auth()->id();
                $failedTranscations->save();
                notify()->error('Payment failed');
                return back();

            }

        }catch(\Exception $e){

            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = 'STRIPE_SELLER_PLANS_FAILED_' . str_random(5);
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            notify()->error('Payment failed');
            return back();

        }

    }

    public function createsubscription($plan,$txn_id,$paidamount,$method,$user,$currency = NULL){

       
        
        if($plan['period'] == 'day'){

            $days = $plan['validity']*7;

            $enddate = date("Y-m-d h:i:s", strtotime(date('Y-m-d h:i:s')."+$days days"));

        }elseif($plan['period'] == 'week'){

            $days = $plan['validity']*7;

            $enddate = date("Y-m-d h:i:s", strtotime(date('Y-m-d h:i:s')."+$days days"));

        }elseif ($plan['period'] == 'month') {
            $days = $plan['validity'] * 30;
            $enddate = date("Y-m-d h:i:s", strtotime(date('Y-m-d h:i:s')."+$days days"));
        }
        elseif ($plan['period'] == 'year') {
            $days = $plan['validity'] * 365;
            $enddate = date("Y-m-d h:i:s", strtotime(date('Y-m-d h:i:s')."+$days days"));
        }

        DB::beginTransaction();

        if($prev_plan = $user->sellersubscription()->latest()->first()){

            $prev_plan->status = 0;
            $prev_plan->save();

        }


        $payment = $user->sellersubscription()->create([

            'plan_id' => $plan['id'],
            'txn_id'  => $txn_id,
            'method'  => $method,
            'start_date' => date('Y-m-d h:i:s'),
            'end_date'   => $enddate,
            'status'  => 1,
            'original_amount' => (float) $plan['price'],
            'paid_amount' => (float) $paidamount,
            'paid_currency' => (string) $currency != NULL ? $currency : session()->get('currency')['id']

        ]);


        DB::commit();

        Cookie::queue(Cookie::forget('plan'));

        return $payment;

    }
}
