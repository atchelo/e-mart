<?php

namespace App\Http\Controllers;

use App\AddSubVariant;
use App\CurrencyList;
use App\Genral;
use App\Invoice;
use App\InvoiceDownload;
use App\Mail\OrderStatus;
use App\multiCurrency;
use App\Notifications\SMSNotifcations;
use App\OrderActivityLog;
use App\OrderWalletLogs;
use App\Return_Product;
use App\UserWalletHistory;
use Auth;
use Braintree;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Mail;
use PayPal\Api\Amount;
use PayPal\Api\RefundRequest;
use PayPal\Api\Sale;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PaytmWallet;
use Razorpay\Api\Api;
use App\Config;
use App\User;
use Twilosms;

class ReturnOrderController extends Controller
{
    private $_api_context;

    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
        $this->wallet_system = Genral::first()->wallet_enable;
        $this->defaultCurrency = multiCurrency::where('default_currency', '=', 1)->first();
        $this->config = Config::first();
    }

    public function index()
    {
        $inv_cus = Invoice::first();
        $orders = Return_Product::orderBy('id', 'desc')->get();

        $unreadorders = collect();
        $readedorders = collect();
        
        $countP = count($unreadorders);
        $countC = count($readedorders);
        
        foreach ($orders as $key => $order) {
    		if($order->status == 'initiated' && isset($order->getorder->order)){
    			$unreadorders->push($order);
    		}
    	}

    	foreach ($orders as $key => $order) {
    		if($order->status != 'initiated' && isset($order->getorder->order)){
    			$readedorders->push($order);
    		}
    	}

        return view('admindesk.order.returnorder.index', compact('orders', 'countP', 'countC', 'inv_cus'));
    }

    public function detail($id)
    {
        $order = Return_Product::find($id);
        $inv_cus = Invoice::first();
        $orderid = $order->getorder->order->order_id;
        $findvar = AddSubVariant::findorfail($order->getorder->variant_id);
        if (isset($order)) {

            if ($order->status != 'initiated') {
                return view('admindesk.order.returnorder.detail', compact('findvar', 'inv_cus', 'order', 'orderid'));
            } else {
                return back()->with('warning', 'Order not refunded yet !');
            }

        } else {
            return redirect()->route('return.order.index')->with('warning', '404 Return order not found !');
        }

    }

    public function show($id)
    {
        $rorder = Return_Product::find($id);
        $findvar = AddSubVariant::findorfail($rorder->getorder->variant_id);
        $inv_cus = Invoice::first();
        $orderid = $rorder->getorder->order->order_id;
        if (isset($rorder)) {
            if ($rorder->status != 'initiated') {
                return back()->with('warning', '400 Refund already initiated !');
            }
            return view('admindesk.order.returnorder.show', compact('rorder', 'orderid', 'inv_cus', 'findvar'));
        } else {
            return redirect()->route('return.order.index')->with('warning', '404 Return order not found !');
        }

    }

    public function paytouser(Request $request, $id)
    {
        $returnorder = Return_Product::find($id);
        $findInvoice = InvoiceDownload::findorfail($returnorder->order_id);

        if (Auth::check()) {

            if (isset($returnorder)) {

                if ($returnorder->status == 'initiated') {

                    if ($returnorder->method_choosen == 'bank') {

                        $returnorder->status = 'refunded';
                        $returnorder->amount = $request->amount;
                        $returnorder->txn_id = $request->txn_id;
                        $returnorder->txn_fee = $request->txn_fee;
                        $returnorder->save();

                        $findInvoice->status = $request->order_status;
                        $findInvoice->save();

                        /*Send Mail to User*/
                        $inv_cus = Invoice::first();

                        if ($request->order_status == 'ret_ref') {
                            $status = 'Returned & Amount has been refunded';
                        } else {
                            $status = $request->order_status;
                        }

                        $create_activity = new OrderActivityLog();

                        $create_activity->order_id = $findInvoice->order->id;
                        $create_activity->inv_id = $findInvoice->id;
                        $create_activity->user_id = $findInvoice->order->user_id;
                        $create_activity->variant_id = $findInvoice->variant_id;
                        $create_activity->log = $status;

                        $create_activity->save();

                        if ($returnorder->getorder->order->payment_method == 'Wallet') {
                            if ($this->wallet_system == 1) {
                                /** If Originally payment made from wallet Make a log entry in Admin Order Wallet logs */
                                $refunded_wallet_amount = sprintf("%.2f", currency($returnorder->amount, $from = $findInvoice->order->paid_in_currency, $to = $this->defaultCurrency->currency->code, $format = false));
                                $inv_cus = Invoice::first();
                                $invoiceno = $inv_cus->prefix . $findInvoice->inv_no . $inv_cus->postfix;
                                $lastbalance = OrderWalletLogs::orderBy('id', 'DESC')->first();

                                $adminwalletlog = new OrderWalletLogs;
                                $adminwalletlog->wallet_txn_id = $request->txn_id;
                                $adminwalletlog->note = 'Refund Payment for Invoice #' . $invoiceno;
                                $adminwalletlog->type = 'Debit';
                                $adminwalletlog->amount = $refunded_wallet_amount;
                                $adminwalletlog->balance = isset($lastbalance) ? $lastbalance->balance - $refunded_wallet_amount : $refunded_wallet_amount;
                                $adminwalletlog->save();
                                /** END */
                            }
                        }

                        try {

                            Mail::to($findInvoice->order->user->email)->send(new OrderStatus($inv_cus, $findInvoice, $status));

                            if($this->config->sms_channel == '1'){

                                $invoiceno = $inv_cus->prefix . $findInvoice->inv_no . $inv_cus->postfix;

                                $method = $returnorder->getorder->order->payment_method;

                                $smsmsg = "Refund amount of $returnorder->amount has been initiated to $method with txn no. $returnorder->txn_id for Invoice No. $invoiceno";
                                $smsmsg.= '%0a - '.config('app.name');
        
                                if(env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1'){
        
                                    try{
                                        
                                        User::find($findInvoice->order->user->id)->notify(new SMSNotifcations($smsmsg));
                
                                    }catch(\Exception $e){
                
                                        \Log::error('Error: '.$e->getMessage());
                
                                    }
        
                                }
            
                                if(env('DEFAULT_SMS_CHANNEL') == 'twillo'){
        
                                    try{
                                        Twilosms::sendMessage($smsmsg, '+'.$findInvoice->order->user->phonecode.$findInvoice->order->user->mobile);
                                    }catch(\Exception $e){
                                        \Log::error('Twillo Error: '.$e->getMessage());
                                    }
        
                                }
                            }


                        } catch (\Exception $e) {
                            
                        }
                        /*end*/

                        return redirect()->route('return.order.index')->with('updated', 'Return Order Updated Successfully !');

                    } else {

                        if ($returnorder->getorder->order->payment_method == 'Wallet') {

                            if ($this->wallet_system == 1) {
                                return $this->refundInWallet($request, $returnorder);
                            } else {
                                return back()->with('warning', 'Wallet System is disabled !');
                            }

                        }

                        if ($returnorder->getorder->order->payment_method == 'Instamojo') {

                            return $this->payviaInstamojo($request, $returnorder);

                        } elseif ($returnorder->getorder->order->payment_method == 'PayPal') {

                            return $this->payviaPaypal($request, $returnorder);

                        } elseif ($returnorder->getorder->order->payment_method == 'Stripe') {

                            return $this->payviaStripe($request, $returnorder);

                        } elseif ($returnorder->getorder->order->payment_method == 'PayU') {

                            return $this->payviaPayU($request, $returnorder);

                        } elseif ($returnorder->getorder->order->payment_method == 'Razorpay') {

                            return $this->payviaRazorPay($request, $returnorder);

                        } elseif ($returnorder->getorder->order->payment_method == 'Paytm') {

                            return $this->payviaPaytm($request, $returnorder);

                        } elseif ($returnorder->getorder->order->payment_method == 'Braintree') {

                            return $this->payviaBraintree($request, $returnorder);

                        } elseif ($returnorder->getorder->order->payment_method == 'Paystack') {

                            return $this->payviaPaystack($request, $returnorder);

                        }else{
                            return back()->with('warning','For Selected Payment Source Instant refund is not available !');
                        }

                    }

                } else {
                    return back()->with('warning', 'Refund for this order already completed !');
                }

            } else {
                return back()->with('warning', '404 Return order not found !');
            }

        } else {
            return back()->with('failure', '401 Unauthorized action !');
        }
    }

    public function refundInWallet($request, $returnorder)
    {
        //find again
        $returnorder = Return_Product::find($returnorder->id);
        $findInvoice = InvoiceDownload::findorfail($returnorder->order_id);

        $refunded_wallet_amount = sprintf("%.2f", currency($returnorder->amount, $from = $findInvoice->order->paid_in_currency, $to = $this->defaultCurrency->currency->code, $format = false));

        /** Put Money back in users wallet */
        $findInvoice->order->user->wallet()->update([
            'balance' => $findInvoice->order->user->wallet->balance + $refunded_wallet_amount,
        ]);

        $inv_cus = Invoice::first();
        $invoiceno = $inv_cus->prefix . $findInvoice->inv_no . $inv_cus->postfix;
        /** Adding Customer Wallet Log in History */

        $walletlog = new UserWalletHistory;
        $walletlog->wallet_id = $findInvoice->order->user->wallet->id;
        $walletlog->type = 'Credit';
        $walletlog->log = 'Refund Payment for Invoice #' . $invoiceno;
        $walletlog->amount = $refunded_wallet_amount;
        $walletlog->txn_id = $returnorder->txn_id;
        $walletlog->save();
        /** END */

        /** Make a log entry in Admin Order Wallet logs */

        $lastbalance = OrderWalletLogs::orderBy('id', 'DESC')->first();

        $adminwalletlog = new OrderWalletLogs;
        $adminwalletlog->wallet_txn_id = $walletlog->txn_id;
        $adminwalletlog->note = 'Refund Payment for Invoice #' . $invoiceno;
        $adminwalletlog->type = 'Debit';
        $adminwalletlog->amount = $refunded_wallet_amount;
        $adminwalletlog->balance = isset($lastbalance) ? $lastbalance->balance - $refunded_wallet_amount : $refunded_wallet_amount;
        $adminwalletlog->save();
        /** END */

        $returnorder->status = 'refunded';
        $returnorder->save();

        $findInvoice->status = $request->order_status;
        $findInvoice->save();

        if ($request->order_status == 'ret_ref') {
            $status = 'Returned & Amount has been refunded';
        } else {
            $status = $request->order_status;
        }

        $create_activity = new OrderActivityLog();

        $create_activity->order_id = $findInvoice->order->id;
        $create_activity->inv_id = $findInvoice->id;
        $create_activity->user_id = $findInvoice->order->user_id;
        $create_activity->variant_id = $findInvoice->variant_id;
        $create_activity->log = $status;

        $create_activity->save();

        try {

            if ($findInvoice->order->user->email) {
                Mail::to($findInvoice->order->user->email)->send(new OrderStatus($inv_cus, $findInvoice, $status));
            }

            if($this->config->sms_channel == '1'){

                 /** Sms Notification */
                 $invoiceno = $inv_cus->prefix . $findInvoice->inv_no . $inv_cus->postfix;
                 $method = $returnorder->getorder->order->payment_method;
                 $smsmsg = "Refund amount of $refunded_wallet_amount has been initiated to $method with txn no. $adminwalletlog->wallet_txn_id for Invoice No. $invoiceno";
                 $smsmsg.= '%0a - '.config('app.name');

                if(env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1'){

                    try{
                        
                        User::find($findInvoice->order->user->id)->notify(new SMSNotifcations($smsmsg));

                    }catch(\Exception $e){

                        \Log::error('Error: '.$e->getMessage());

                    }

                }

                if(env('DEFAULT_SMS_CHANNEL') == 'twillo'){

                    try{
                        Twilosms::sendMessage($smsmsg, '+'.$findInvoice->order->user->phonecode.$findInvoice->order->user->mobile);
                    }catch(\Exception $e){
                        \Log::error('Twillo Error: '.$e->getMessage());
                    }

                }
            }

        } catch (\Exception $e) {
            \Log::error('Error: '.$e->getMessage());
        }

        /*end*/

        return redirect()->route('return.order.index')->with('updated', 'Return Order Updated Successfully !');
    }

    public function payviaPaystack($request, $returnorder)
    {
        //find again
        $returnorder = Return_Product::find($returnorder->id);
        $findInvoice = InvoiceDownload::findorfail($returnorder->order_id);

        $url = "https://api.paystack.co/refund";

        $fields = [
            'amount' => $returnorder->amount,
            'transaction' => $returnorder->getorder->order->transaction_id,
            'customer_note' => $returnorder->reason,
        ];

        $fields_string = http_build_query($fields);
        //open connection
        $ch = curl_init();
        $secret = env('PAYSTACK_SECRET_KEY');
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Authorization: Bearer $secret",
            "Cache-Control: no-cache",
        ));

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //execute post
        $result = curl_exec($ch);
        $result = json_decode($result, true);

        if ($result['status'] == false) {
            return back()->with('warning', $result['message']);
        } else {

            $returnorder->status = 'refunded';
            $returnorder->amount = $result['data']['transaction']['amount'] / 100;
            $returnorder->txn_id = $result['data']['transaction']['id'];
            $returnorder->save();

            $findInvoice->status = $request->order_status;
            $findInvoice->save();

            /*Send Mail to User*/
            $inv_cus = Invoice::first();

            if ($request->order_status == 'ret_ref') {
                $status = 'Returned & Amount has been refunded';
            } else {
                $status = $request->order_status;
            }

            $create_activity = new OrderActivityLog();

            $create_activity->order_id = $findInvoice->order->id;
            $create_activity->inv_id = $findInvoice->id;
            $create_activity->user_id = $findInvoice->order->user_id;
            $create_activity->variant_id = $findInvoice->variant_id;
            $create_activity->log = $status;

            $create_activity->save();

            try {

                Mail::to($findInvoice->order->user->email)->send(new OrderStatus($inv_cus, $findInvoice, $status));
                return redirect()->route('return.order.index')->with('updated', 'Return Order Updated Successfully !');

                if($this->config->sms_channel == '1'){

                    /** Sms Notification */
                    $invoiceno = $inv_cus->prefix . $findInvoice->inv_no . $inv_cus->postfix;
                    $method = $returnorder->getorder->order->payment_method;
                    $smsmsg = "Refund amount of  $returnorder->amount has been initiated to $method with txn no. $returnorder->txn_id for Invoice No. $invoiceno";
                    $smsmsg.= '%0a - '.config('app.name');
   
                   if(env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1'){
   
                       try{
                           
                           User::find($findInvoice->order->user->id)->notify(new SMSNotifcations($smsmsg));
   
                       }catch(\Exception $e){
   
                           \Log::error('Error: '.$e->getMessage());
   
                       }
   
                   }
   
                   if(env('DEFAULT_SMS_CHANNEL') == 'twillo'){
   
                       try{
                           Twilosms::sendMessage($smsmsg, '+'.$findInvoice->order->user->phonecode.$findInvoice->order->user->mobile);
                       }catch(\Exception $e){
                           \Log::error('Twillo Error: '.$e->getMessage());
                       }
   
                   }
               }

            } catch (\Exception $e) {
               
            }

            /*end*/

            return redirect()->route('return.order.index')->with('updated', 'Return Order Updated Successfully !');

        }
    }

    public function payviaPaytm($request, $returnorder)
    {

        //find again
        $returnorder = Return_Product::find($returnorder->id);
        $findInvoice = InvoiceDownload::findorfail($returnorder->order_id);

        $refund = PaytmWallet::with('refund');

        $refund->prepare([
            'order' => $returnorder->getorder->order->order_id,
            'reference' => 'refund-order-' . $returnorder->getorder->order->order_id,
            'amount' => $returnorder->amount,
            'transaction' => $returnorder->getorder->order->transaction_id,
        ]);

        $refund->initiate();
        $response = $refund->response();

        if ($refund->isSuccessful()) {

            $returnorder->status = 'refunded';
            $returnorder->amount = $response['REFUNDAMOUNT'];
            $returnorder->txn_id = $response['REFUNDID'];
            $returnorder->save();

            $findInvoice->status = $request->order_status;
            $findInvoice->save();

            /*Send Mail to User*/
            $inv_cus = Invoice::first();

            if ($request->order_status == 'ret_ref') {
                $status = 'Returned & Amount has been refunded';
            } else {
                $status = $request->order_status;
            }

            $create_activity = new OrderActivityLog();

            $create_activity->order_id = $findInvoice->order->id;
            $create_activity->inv_id = $findInvoice->id;
            $create_activity->user_id = $findInvoice->order->user_id;
            $create_activity->variant_id = $findInvoice->variant_id;
            $create_activity->log = $status;

            $create_activity->save();

            try {

                Mail::to($findInvoice->order->user->email)->send(new OrderStatus($inv_cus, $findInvoice, $status));
                return redirect()->route('return.order.index')->with('updated', 'Return Order Updated Successfully !');

                 /** Sms Notification */
                if($this->config->sms_channel == '1'){

                    /** Sms Notification */
                    $invoiceno = $inv_cus->prefix . $findInvoice->inv_no . $inv_cus->postfix;
                    $method = $returnorder->getorder->order->payment_method;
                    $smsmsg = "Refund amount of  $returnorder->amount has been initiated to $method with txn no. $returnorder->txn_id for Invoice No. $invoiceno";
                    $smsmsg.= '%0a - '.config('app.name');
   
                   if(env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1'){
   
                       try{
                           
                           User::find($findInvoice->order->user->id)->notify(new SMSNotifcations($smsmsg));
   
                       }catch(\Exception $e){
   
                           \Log::error('Error: '.$e->getMessage());
   
                       }
   
                   }
   
                   if(env('DEFAULT_SMS_CHANNEL') == 'twillo'){
   
                       try{
                           Twilosms::sendMessage($smsmsg, '+'.$findInvoice->order->user->phonecode.$findInvoice->order->user->mobile);
                       }catch(\Exception $e){
                           \Log::error('Twillo Error: '.$e->getMessage());
                       }
   
                   }
                }

            } catch (\Exception $e) {
                
            }

            /*end*/

            return redirect()->route('return.order.index')->with('updated', 'Return Order Updated Successfully !');

        } else if ($refund->isFailed()) {

            if ($response['STATUS'] == 'TXN_FAILURE') {

                $status = 0;
                notify()->error($response['RESPMSG']);
                return back();

            }

        } else if ($refund->isOpen()) {
            #nocode
        } else if ($refund->isPending()) {
            #nocode
        }
    }

    public function payviaRazorPay($request, $returnorder)
    {
        //find again
        $returnorder = Return_Product::find($returnorder->id);
        $findInvoice = InvoiceDownload::findorfail($returnorder->order_id);

        try {
            $api = new Api(env('RAZOR_PAY_KEY'), env('RAZOR_PAY_SECRET'));
            $refund = $api->payment->fetch($returnorder->getorder->order->transaction_id);
            $result = $refund->refund(array('amount' => round($returnorder->amount * 100, 2)));

            $returnorder->status = 'refunded';
            $returnorder->amount = $result->amount / 100;
            $returnorder->txn_id = $result->id;
            $returnorder->save();

            $findInvoice->status = $request->order_status;
            $findInvoice->save();

            /*Send Mail to User*/
            $inv_cus = Invoice::first();

            if ($request->order_status == 'ret_ref') {
                $status = 'Returned & Amount has been refunded';
            } else {
                $status = $request->order_status;
            }

            $create_activity = new OrderActivityLog();

            $create_activity->order_id = $findInvoice->order->id;
            $create_activity->inv_id = $findInvoice->id;
            $create_activity->user_id = $findInvoice->order->user_id;
            $create_activity->variant_id = $findInvoice->variant_id;
            $create_activity->log = $status;

            $create_activity->save();

            try {

                Mail::to($findInvoice->order->user->email)->send(new OrderStatus($inv_cus, $findInvoice, $status));
               

                 /** Sms Notification */
                if($this->config->sms_channel == '1'){

                    /** Sms Notification */
                    $invoiceno = $inv_cus->prefix . $findInvoice->inv_no . $inv_cus->postfix;
                    $method = $returnorder->getorder->order->payment_method;
                    $smsmsg = "Refund amount of  $returnorder->amount has been initiated to $method with txn no. $returnorder->txn_id for Invoice No. $invoiceno";
                    $smsmsg.= '%0a - '.config('app.name');
   
                   if(env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1'){
   
                       try{
                           
                           User::find($findInvoice->order->user->id)->notify(new SMSNotifcations($smsmsg));
   
                       }catch(\Exception $e){
   
                           \Log::error('Error: '.$e->getMessage());
   
                       }
   
                   }
   
                   if(env('DEFAULT_SMS_CHANNEL') == 'twillo'){
   
                       try{
                           Twilosms::sendMessage($smsmsg, '+'.$findInvoice->order->user->phonecode.$findInvoice->order->user->mobile);
                       }catch(\Exception $e){
                           \Log::error('Twillo Error: '.$e->getMessage());
                       }
   
                   }
                }

            } catch (\Exception $e) {
               
            }

            /*end*/

            return redirect()->route('return.order.index')->with('updated', 'Return Order Updated Successfully !');

        } catch (\Exception $e) {
            $error = $e->getMessage();
            return back()->with('warning', $error);
        }
    }

    public function payviaInstamojo($request, $returnorder)
    {
        //find again
        $returnorder = Return_Product::find($returnorder->id);
        $findInvoice = InvoiceDownload::findorfail($returnorder->order_id);

        try {

            $ch = curl_init();
            $api_key = env('IM_API_KEY');
            $auth_token = env('IM_AUTH_TOKEN');
            curl_setopt($ch, CURLOPT_URL, env('IM_REFUND_URL'));
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,

                array("X-Api-Key:$api_key",
                    "X-Auth-Token:$auth_token"));

            $payload = array(
                'transaction_id' => 'RFD_IM_' . str_random(10),
                'payment_id' => $returnorder->getorder->order->transaction_id,
                'type' => 'QFL',
                'refund_amount' => round($returnorder->amount, 2),
                'body' => $returnorder->reason,
            );

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
            $response = curl_exec($ch);
            curl_close($ch);

            $result = json_decode($response, true);

            if (isset($result['refund'])) {

                $returnorder->status = 'refunded';
                $returnorder->amount = $result['refund']['refund_amount'];
                $returnorder->txn_id = $result['refund']['id'];
                $returnorder->save();

                $findInvoice->status = $request->order_status;
                $findInvoice->save();

                /*Send Mail to User*/
                $inv_cus = Invoice::first();

                if ($request->order_status == 'ret_ref') {
                    $status = 'Returned & Amount has been refunded';
                } else {
                    $status = $request->order_status;
                }

                $create_activity = new OrderActivityLog();

                $create_activity->order_id = $findInvoice->order->id;
                $create_activity->inv_id = $findInvoice->id;
                $create_activity->user_id = $findInvoice->order->user_id;
                $create_activity->variant_id = $findInvoice->variant_id;
                $create_activity->log = $status;

                $create_activity->save();

                try {

                    Mail::to($findInvoice->order->user->email)->send(new OrderStatus($inv_cus, $findInvoice, $status));


                    /** Sms Notification */
                    if($this->config->sms_channel == '1'){

                        /** Sms Notification */
                        $invoiceno = $inv_cus->prefix . $findInvoice->inv_no . $inv_cus->postfix;
                        $method = $returnorder->getorder->order->payment_method;
                        $smsmsg = "Refund amount of  $returnorder->amount has been initiated to $method with txn no. $returnorder->txn_id for Invoice No. $invoiceno";
                        $smsmsg.= '%0a - '.config('app.name');
       
                       if(env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1'){
       
                           try{
                               
                               User::find($findInvoice->order->user->id)->notify(new SMSNotifcations($smsmsg));
       
                           }catch(\Exception $e){
       
                               \Log::error('Error: '.$e->getMessage());
       
                           }
       
                       }
       
                       if(env('DEFAULT_SMS_CHANNEL') == 'twillo'){
       
                           try{
                               Twilosms::sendMessage($smsmsg, '+'.$findInvoice->order->user->phonecode.$findInvoice->order->user->mobile);
                           }catch(\Exception $e){
                               \Log::error('Twillo Error: '.$e->getMessage());
                           }
       
                       }
                    }

                } catch (\Exception $e) {
                   \Log::error('SmsERROR: '.$e->getMessage());
                }

                /*end*/

                return redirect()->route('return.order.index')->with('updated', 'Return Order Updated Successfully !');

            } else {
                return back()->with('warning', 'Return already completed or insufficient balance !');
            }

        } catch (\Exception $e) {
            $error = $e->getMessage();
            return back()->with('warning', $error);
        }
    }

    public function payviaPaypal($request, $returnorder)
    {
        //find again

        $returnorder = Return_Product::find($returnorder->id);

        $findInvoice = InvoiceDownload::findorfail($returnorder->order_id);

        $fCurrency = multiCurrency::where('currency_symbol', '=', $returnorder->getorder->order->paid_in)->first();

        $setCurrency = CurrencyList::findOrFail($fCurrency->currency_id)->code;

        $amt = new Amount();
        $amt->setTotal(round($returnorder->amount, 2))
            ->setCurrency($setCurrency);
        $saleId = $returnorder->getorder->order->sale_id;
        $refund = new RefundRequest();
        $refund->setAmount($amt);
        $sale = new Sale();
        $sale->setId($saleId);

        try {

            $refundedSale = $sale->refundSale($refund, $this->_api_context);

            $returnorder->status = 'refunded';
            $returnorder->amount = $refundedSale->total_refunded_amount->value;
            $returnorder->txn_id = $refundedSale->id;
            $returnorder->save();

            $findInvoice->status = $request->order_status;
            $findInvoice->save();

            /*Send Mail to User*/
            $inv_cus = Invoice::first();

            if ($request->order_status == 'ret_ref') {
                $status = 'Returned & Amount has been refunded';
            } else {
                $status = $request->order_status;
            }

            $create_activity = new OrderActivityLog();

            $create_activity->order_id = $findInvoice->order->id;
            $create_activity->inv_id = $findInvoice->id;
            $create_activity->user_id = $findInvoice->order->user_id;
            $create_activity->variant_id = $findInvoice->variant_id;
            $create_activity->log = $status;

            $create_activity->save();

            try {

                Mail::to($findInvoice->order->user->email)->send(new OrderStatus($inv_cus, $findInvoice, $status));
                
                 /** Sms Notification */
                if($this->config->sms_channel == '1'){

                    /** Sms Notification */
                    $invoiceno = $inv_cus->prefix . $findInvoice->inv_no . $inv_cus->postfix;
                    $method = $returnorder->getorder->order->payment_method;
                    $smsmsg = "Refund amount of  $returnorder->amount has been initiated to $method with txn no. $returnorder->txn_id for Invoice No. $invoiceno";
                    $smsmsg.= '%0a - '.config('app.name');
   
                   if(env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1'){
   
                       try{
                           
                           User::find($findInvoice->order->user->id)->notify(new SMSNotifcations($smsmsg));
   
                       }catch(\Exception $e){
   
                           \Log::error('Error: '.$e->getMessage());
   
                       }
   
                   }
   
                   if(env('DEFAULT_SMS_CHANNEL') == 'twillo'){
   
                       try{
                           Twilosms::sendMessage($smsmsg, '+'.$findInvoice->order->user->phonecode.$findInvoice->order->user->mobile);
                       }catch(\Exception $e){
                           \Log::error('Twillo Error: '.$e->getMessage());
                       }
   
                   }
                }

            } catch (\Exception $e) {
                
            }

            /*end*/

            return redirect()->route('return.order.index')->with('updated', 'Return Order Updated Successfully !');

        } catch (\Exception $ex) {

            return $ex->getMessage();

        }
    }

    public function payviaStripe($request, $returnorder)
    {

        $stripe = new Stripe();
        $stripe = Stripe::make(env('STRIPE_SECRET'));

        $charge_id = $returnorder->getorder->order->transaction_id;
        $amount = round($returnorder->amount, 2);

        //find again
        $returnorder = Return_Product::find($returnorder->id);
        $findInvoice = InvoiceDownload::findorfail($returnorder->order_id);

        try {

            $refund = $stripe->refunds()->create($charge_id, $amount, [

                'metadata' => [

                    'reason' => $returnorder->reason,

                ],

            ]);

            $returnorder->status = 'refunded';
            $returnorder->amount = $returnorder->amount;
            $returnorder->txn_id = $refund['id'];
            $returnorder->save();

            $findInvoice->status = $request->order_status;
            $findInvoice->save();

            /*Send Mail to User*/
            $inv_cus = Invoice::first();

            if ($request->order_status == 'ret_ref') {
                $status = 'Returned & Amount has been refunded';
            } else {
                $status = $request->order_status;
            }

            $create_activity = new OrderActivityLog();

            $create_activity->order_id = $findInvoice->order->id;
            $create_activity->inv_id = $findInvoice->id;
            $create_activity->user_id = $findInvoice->order->user_id;
            $create_activity->variant_id = $findInvoice->variant_id;
            $create_activity->log = $status;

            $create_activity->save();

            try {

                Mail::to($findInvoice->order->user->email)->send(new OrderStatus($inv_cus, $findInvoice, $status));
                return redirect()->route('return.order.index')->with('updated', 'Return Order Updated Successfully !');

                 /** Sms Notification */
                if($this->config->sms_channel == '1'){

                    /** Sms Notification */
                    $invoiceno = $inv_cus->prefix . $findInvoice->inv_no . $inv_cus->postfix;
                    $method = $returnorder->getorder->order->payment_method;
                    $smsmsg = "Refund amount of  $returnorder->amount has been initiated to $method with txn no. $returnorder->txn_id for Invoice No. $invoiceno";
                    $smsmsg.= '%0a - '.config('app.name');
   
                   if(env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1'){
   
                       try{
                           
                           User::find($findInvoice->order->user->id)->notify(new SMSNotifcations($smsmsg));
   
                       }catch(\Exception $e){
   
                           \Log::error('Error: '.$e->getMessage());
   
                       }
   
                   }
   
                   if(env('DEFAULT_SMS_CHANNEL') == 'twillo'){
   
                       try{

                           Twilosms::sendMessage($smsmsg, '+'.$findInvoice->order->user->phonecode.$findInvoice->order->user->mobile);

                       }catch(\Exception $e){
                           \Log::error('Twillo Error: '.$e->getMessage());
                       }
   
                   }
                }

            } catch (\Exception $e) {
               
            }

            /*end*/

            return redirect()->route('return.order.index')->with('updated', 'Return Order Updated Successfully !');

        } catch (\Exception $e) {
            $error = $e->getMessage();
            return back()->with('warning', $error);
        }

    }

    public function payviaPayU($request, $returnorder)
    {
        return 'Coming Soon ! Please use Bank Transfer !';
    }

    public function payviaBraintree($request, $returnorder)
    {
        $gateway = $this->brainConfig();
        $amount = round($returnorder->amount, 2);

        //find again
        $returnorder = Return_Product::find($returnorder->id);
        $findInvoice = InvoiceDownload::findorfail($returnorder->order_id);

        $response = $gateway->transaction()->refund($returnorder->getorder->order->transaction_id, $amount);

        if ($response->success == true) {

            $returnorder->status = 'refunded';
            $returnorder->amount = $response->transaction->amount;
            $returnorder->txn_id = $response->transaction->id;
            $returnorder->save();

            $findInvoice->status = $request->order_status;
            $findInvoice->save();

            /*Send Mail to User*/
            $inv_cus = Invoice::first();

            if ($request->order_status == 'ret_ref') {
                $status = 'Returned & Amount has been refunded';
            } else {
                $status = $request->order_status;
            }

            $create_activity = new OrderActivityLog();

            $create_activity->order_id = $findInvoice->order->id;
            $create_activity->inv_id = $findInvoice->id;
            $create_activity->user_id = $findInvoice->order->user_id;
            $create_activity->variant_id = $findInvoice->variant_id;
            $create_activity->log = $status;

            $create_activity->save();

            try {

                Mail::to($findInvoice->order->user->email)->send(new OrderStatus($inv_cus, $findInvoice, $status));

                /** Sms Notification */
                if($this->config->sms_channel == '1'){

                    /** Sms Notification */
                    $invoiceno = $inv_cus->prefix . $findInvoice->inv_no . $inv_cus->postfix;
                    $method = $returnorder->getorder->order->payment_method;
                    $smsmsg = "Refund amount of  $returnorder->amount has been initiated to $method with txn no. $returnorder->txn_id for Invoice No. $invoiceno";
                    $smsmsg.= '%0a - '.config('app.name');
   
                   if(env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1'){
   
                       try{
                           
                           User::find($findInvoice->order->user->id)->notify(new SMSNotifcations($smsmsg));
   
                       }catch(\Exception $e){
   
                           \Log::error('Error: '.$e->getMessage());
   
                       }
   
                   }
   
                   if(env('DEFAULT_SMS_CHANNEL') == 'twillo'){
   
                       try{
                           Twilosms::sendMessage($smsmsg, '+'.$findInvoice->order->user->phonecode.$findInvoice->order->user->mobile);
                       }catch(\Exception $e){
                           \Log::error('Twillo Error: '.$e->getMessage());
                       }
   
                   }
                }

            } catch (\Exception $e) {
            }

            return redirect()->route('return.order.index')->with('updated', 'Return Order Updated Successfully !');

        } else {
            return back()->with('warning', $response->message);
        }
    }

    /* Config function to get the braintree config data to process all the apis on braintree gateway */
    public function brainConfig()
    {

        return $gateway = new Braintree\Gateway([
            'environment' => env('BRAINTREE_ENV'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY'),
        ]);

    }

}
