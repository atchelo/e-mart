<?php
namespace App\Http\Controllers;

use App\Address;
use App\AddSubVariant;
use App\CanceledOrders;
use App\Config;
use App\CurrencyList;
use App\FullOrderCancelLog;
use App\Genral;
use App\Invoice;
use App\InvoiceDownload;
use App\Mail\FullOrderCancelMail;
use App\multiCurrency;
use App\Notifications\FullOrderCancelNotification;
use App\Notifications\FullOrderCancelNotificationAdmin;
use App\Notifications\SellerNotification;
use App\Notifications\SMSNotifcations;
use App\Order;
use App\OrderActivityLog;
use App\OrderWalletLogs;
use App\User;
use App\UserWalletHistory;
use Auth;
use Braintree;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Crypt;
use Illuminate\Http\Request;
use Mail;
use PayPal\Api\Amount;
use PayPal\Api\Refund;
use PayPal\Api\Sale;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PaytmWallet;
use Razorpay\Api\Api;
use Session;
use Twilosms;

class FullOrderCancelController extends Controller
{

    private $_api_context;

    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
        $this->defaultCurrency = multiCurrency::where('default_currency', '=', 1)->first();
        $this->wallet_system = Genral::first()->wallet_enable;
    }

    public function cancelOrder(Request $request, $id)
    {

        $orderID = Crypt::decrypt($id);

        $order = Order::findorfail($orderID);
        $finalAmount = 0;
        $status = 0;
        $invArray = collect();

        if (!isset($request->source)) {
            notify()->error('Please add bank account first !');
            return back();
        }

        foreach ($order->invoices as $value) {

            if ($value->variant->products->cancel_avl != '0') {

                $invArray->push($value->id);

                if ($order->discount != 0) {

                    $finalAmount = $finalAmount + ($value->qty * $value->price) + $value->tax_amount + $value->handlingcharge + $value->shipping - $value->discount;

                } else {

                    $finalAmount = $finalAmount + ($value->qty * $value->price) + $value->tax_amount + $value->handlingcharge + $value->shipping;

                }

            }

        }

        $finalAmount = round($finalAmount, 2);

        if ($order->user_id == Auth::user()->id || Auth::user()->role_id == 'a') {

            if ($order->payment_method != 'COD') {

                if ($request->source == 'bank') {

                    $cancelorderlog = new FullOrderCancelLog();

                    $cancelorderlog->order_id = $order->id;
                    $cancelorderlog->inv_id = $invArray;
                    $cancelorderlog->user_id = $order->user_id;
                    $cancelorderlog->comment = $request->comment;
                    $cancelorderlog->method_choosen = $request->source;
                    $cancelorderlog->amount = $finalAmount;
                    $cancelorderlog->bank_id = $request->bank_id;
                    $cancelorderlog->is_refunded = 'pending';
                    $cancelorderlog->transaction_id = 'TXNBNK' . str_random(10);
                    $cancelorderlog->txn_fee = null;
                    $cancelorderlog->save();

                    $status = 1;
                    /** Make a log entry in Admin Order Wallet logs */

                    if ($this->wallet_system == 1) {

                        $refunded_wallet_amount = sprintf("%.2f", currency($finalAmount, $from = $order->paid_in_currency, $to = $this->defaultCurrency->currency->code, $format = false));

                        $lastbalance = OrderWalletLogs::orderBy('id', 'DESC')->first();

                        $adminwalletlog = new OrderWalletLogs;
                        $adminwalletlog->wallet_txn_id = $cancelorderlog->transaction_id;
                        $adminwalletlog->note = 'Refund Payment for Order #' . $order->order_id;
                        $adminwalletlog->type = 'Debit';
                        $adminwalletlog->amount = $refunded_wallet_amount;
                        $adminwalletlog->balance = isset($lastbalance) ? $lastbalance->balance - $refunded_wallet_amount : $refunded_wallet_amount;
                        $adminwalletlog->save();

                    }

                    /** END */

                } elseif ($request->source == 'orignal') {

                    if ($order->payment_method == 'Wallet') {

                        if ($this->wallet_system != 1) {
                            notify()->info('Wallet System is deactive currently ! please contact site master regrading this issue !');
                            return back();
                        }

                        if (isset($order->user->wallet) && $order->user->wallet->status == 1) {

                            $cancelorderlog = new FullOrderCancelLog();
                            $cancelorderlog->order_id = $order->id;
                            $cancelorderlog->inv_id = $invArray;
                            $cancelorderlog->user_id = $order->user_id;
                            $cancelorderlog->comment = $request->comment;
                            $cancelorderlog->method_choosen = $request->source;
                            $cancelorderlog->amount = $finalAmount;
                            $cancelorderlog->is_refunded = 'completed';
                            $cancelorderlog->txn_id = 'WALLET' . str_random(10);
                            $cancelorderlog->txn_fee = null;
                            $cancelorderlog->save();

                            $status = 1;

                            $refunded_wallet_amount = sprintf("%.2f", currency($finalAmount, $from = $order->paid_in_currency, $to = $this->defaultCurrency->currency->code, $format = false));

                            /** Put Money back in users wallet */
                            $order->user->wallet()->update([
                                'balance' => $order->user->wallet->balance + $refunded_wallet_amount,
                            ]);

                            /** Adding Customer Wallet Log in History */

                            $walletlog = new UserWalletHistory;
                            $walletlog->wallet_id = $order->user->wallet->id;
                            $walletlog->type = 'Credit';
                            $walletlog->log = 'Refund Payment for order #' . $order->order_id;
                            $walletlog->amount = $refunded_wallet_amount;
                            $walletlog->txn_id = $cancelorderlog->txn_id;
                            $walletlog->save();
                            /** END */

                            /** Make a log entry in Admin Order Wallet logs */
                            $lastbalance = OrderWalletLogs::orderBy('id', 'DESC')->first();

                            $adminwalletlog = new OrderWalletLogs;
                            $adminwalletlog->wallet_txn_id = $walletlog->txn_id;
                            $adminwalletlog->note = 'Refund Payment for order #' . $order->order_id;
                            $adminwalletlog->type = 'Debit';
                            $adminwalletlog->amount = $refunded_wallet_amount;
                            $adminwalletlog->balance = isset($lastbalance) ? $lastbalance->balance - $refunded_wallet_amount : $refunded_wallet_amount;
                            $adminwalletlog->save();
                            /** END */

                        } else {
                            notify()->warning("Refund can't be proccesed as your wallet is deactive or not found !");
                            return back();
                        }

                    } elseif ($order->payment_method == 'PayPal') {

                        $fCurrency = multiCurrency::where('currency_symbol', '=', $order->paid_in)
                            ->first();

                        $setCurrency = CurrencyList::findOrFail($fCurrency->currency_id)->code;

                        $amt = new Amount();
                        $amt->setTotal($finalAmount)->setCurrency($setCurrency);
                        $saleId = $order->sale_id;
                        $refund = new Refund();
                        $refund->setAmount($amt);
                        $sale = new Sale();
                        $sale->setId($saleId);

                        try
                        {

                            $refundedSale = $sale->refund($refund, $this->_api_context);

                            $cancelorderlog = new FullOrderCancelLog();
                            $cancelorderlog->order_id = $order->id;
                            $cancelorderlog->inv_id = $invArray;
                            $cancelorderlog->user_id = $order->user_id;
                            $cancelorderlog->comment = $request->comment;
                            $cancelorderlog->method_choosen = $request->source;
                            $cancelorderlog->amount = $finalAmount;
                            $cancelorderlog->is_refunded = $refundedSale->state;
                            $cancelorderlog->txn_id = $refundedSale->id;
                            $cancelorderlog->txn_fee = $refundedSale->refund_from_transaction_fee['value'];
                            $cancelorderlog->save();

                            $status = 1;

                        } catch (PayPal\Exception\PayPalConnectionException $ex) {

                            return $ex->getData();

                        } catch (\Exception $ex) {
                            die($ex);
                        }

                    } elseif ($order->payment_method == 'Stripe') {

                        $stripe = new Stripe();
                        $stripe = Stripe::make(env('STRIPE_SECRET'));

                        $charge_id = $order->transaction_id;
                        $amount = $finalAmount;

                        try
                        {

                            $refund = $stripe->refunds()
                                ->create($charge_id, $amount, [

                                    'metadata' => [

                                        'reason' => $request->comment,

                                    ],

                                ]);

                            $cancelorderlog = new FullOrderCancelLog();
                            $cancelorderlog->order_id = $order->id;
                            $cancelorderlog->inv_id = $invArray;
                            $cancelorderlog->user_id = $order->user_id;
                            $cancelorderlog->comment = $request->comment;
                            $cancelorderlog->method_choosen = $request->source;
                            $cancelorderlog->amount = $finalAmount;
                            $cancelorderlog->is_refunded = 'completed';
                            $cancelorderlog->txn_id = $refund['id'];
                            $cancelorderlog->txn_fee = null;
                            $cancelorderlog->save();

                            $status = 1;

                        } catch (\Exception $e) {
                            $error = $e->getMessage();
                            Session::flash('deleted', $error);
                            notify()->error($error);
                            return back();
                        }

                    } elseif ($order->payment_method == 'Instamojo') {
                        //Instamojo Refund code
                        try
                        {

                            $ch = curl_init();
                            $api_key = env('IM_API_KEY');
                            $auth_token = env('IM_AUTH_TOKEN');
                            curl_setopt($ch, CURLOPT_URL, env('IM_REFUND_URL'));
                            curl_setopt($ch, CURLOPT_HEADER, false);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                            curl_setopt($ch, CURLOPT_HTTPHEADER,

                                array(
                                    "X-Api-Key:$api_key",
                                    "X-Auth-Token:$auth_token",
                                ));

                            $payload = array(
                                'transaction_id' => 'RFD_IM_' . str_random(10),
                                'payment_id' => $order->transaction_id,
                                'type' => 'QFL',
                                'refund_amount' => $finalAmount,
                                'body' => $request->comment,
                            );

                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
                            $response = curl_exec($ch);
                            curl_close($ch);

                            $conversion_rate = json_decode($response, true);

                            if (isset($conversion_rate['refund'])) {

                                $cancelorderlog = new FullOrderCancelLog();
                                $cancelorderlog->order_id = $order->id;
                                $cancelorderlog->inv_id = $invArray;
                                $cancelorderlog->user_id = $order->user_id;
                                $cancelorderlog->comment = $request->comment;
                                $cancelorderlog->method_choosen = $request->source;
                                $cancelorderlog->amount = $finalAmount;
                                $cancelorderlog->is_refunded = 'completed';
                                $cancelorderlog->txn_id = $conversion_rate['refund']['id'];
                                $cancelorderlog->txn_fee = null;
                                $cancelorderlog->save();

                                $status = 1;

                            } else {

                                Session::flash('warning', $result['message']);
                                notify()->error($result['message']);
                                return back();

                            }

                        } catch (\Exception $e) {
                            $error = $e->getMessage();
                            Session::flash('warning', $error);
                            notify()->error("$error");
                            return back();
                        }

                    } elseif ($order->payment_method == 'PayU') {
                        Session::flash('warning', 'Error In PAYU SIDE Will added soon when PAYU solve it use bank transfer method till that');
                        notify()->error('PayU Instant Refund will add soon !');
                        return back();
                    } elseif ($order->payment_method == 'Paytm') {
                        $refund = PaytmWallet::with('refund');

                        $refund->prepare(['order' => $order['order_id'], 'reference' => 'refund-order-' . $order['order_id'], 'amount' => $finalAmount, 'transaction' => $order->transaction_id]);

                        $refund->initiate();
                        $response = $refund->response();

                        if ($refund->isSuccessful()) {

                            $cancelorderlog = new FullOrderCancelLog();
                            $cancelorderlog->order_id = $order->id;
                            $cancelorderlog->inv_id = $invArray;
                            $cancelorderlog->user_id = $order->user_id;
                            $cancelorderlog->comment = $request->comment;
                            $cancelorderlog->method_choosen = $request->source;
                            $cancelorderlog->amount = $response['REFUNDAMOUNT'];
                            $cancelorderlog->is_refunded = 'completed';
                            $cancelorderlog->txn_id = $response['REFUNDID'];
                            $cancelorderlog->txn_fee = null;
                            $cancelorderlog->save();

                            $status = 1;

                        } else if ($refund->isFailed()) {

                            if ($response['STATUS'] == 'TXN_FAILURE') {

                                notify()->error($response['RESPMSG']);
                                return back();

                            }

                        } else if ($refund->isOpen()) {
                            #nocode

                        } else if ($refund->isPending()) {
                            #nocode

                        }

                    } elseif ($order->payment_method == 'Razorpay') {

                        $api = new Api(env('RAZOR_PAY_KEY'), env('RAZOR_PAY_SECRET'));
                        $payment = $api
                            ->payment
                            ->fetch($order->transaction_id);

                        try
                        {

                            $refund = $payment->refund(array('amount' => $finalAmount * 100));
                            $cancelorderlog = new FullOrderCancelLog();
                            $cancelorderlog->order_id = $order->id;
                            $cancelorderlog->inv_id = $invArray;
                            $cancelorderlog->user_id = $order->user_id;
                            $cancelorderlog->comment = $request->comment;
                            $cancelorderlog->method_choosen = $request->source;
                            $cancelorderlog->amount = $refund->amount / 100;
                            $cancelorderlog->is_refunded = 'completed';
                            $cancelorderlog->txn_id = $refund->id;
                            $cancelorderlog->txn_fee = null;
                            $cancelorderlog->save();

                            $status = 1;

                        } catch (\Exception $e) {
                            $error = $e->getMessage();
                            Session::flash('warning', $error);
                            notify()->error($error);
                            return back();
                        }

                    } elseif ($order->payment_method == 'Braintree') {

                        $gateway = $this->brainConfig();
                        $result = $gateway->transaction()->refund($order->transaction_id, $finalAmount);

                        if ($result->success == true) {

                            $cancelorderlog = new FullOrderCancelLog();
                            $cancelorderlog->order_id = $order->id;
                            $cancelorderlog->inv_id = $invArray;
                            $cancelorderlog->user_id = $order->user_id;
                            $cancelorderlog->comment = $request->comment;
                            $cancelorderlog->method_choosen = $request->source;
                            $cancelorderlog->amount = $result->transaction->amount;
                            $cancelorderlog->is_refunded = 'completed';
                            $cancelorderlog->txn_id = $result->transaction->id;
                            $cancelorderlog->txn_fee = null;
                            $cancelorderlog->save();

                            $status = 1;

                        } else {
                            $status = 0;
                            notify()->error($result->message);
                            return back();
                        }

                    } elseif ($order->payment_method == 'Paystack') {

                        $url = "https://api.paystack.co/refund";

                        $fields = [
                            'amount' => $finalAmount,
                            'transaction' => $order->transaction_id,
                            'customer_note' => $request->comment,
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
                            $status = 0;
                            notify()->error($result['message']);
                            return back();
                        } else {

                            $cancelorderlog = new FullOrderCancelLog();
                            $cancelorderlog->order_id = $order->id;
                            $cancelorderlog->inv_id = $invArray;
                            $cancelorderlog->user_id = $order->user_id;
                            $cancelorderlog->comment = $request->comment;
                            $cancelorderlog->method_choosen = $request->source;
                            $cancelorderlog->amount = $result['data']['transaction']['amount'] / 100;
                            $cancelorderlog->is_refunded = 'completed';
                            $cancelorderlog->txn_id = $result['data']['transaction']['id'];
                            $cancelorderlog->txn_fee = null;
                            $cancelorderlog->save();

                            $status = 1;
                        }
                    } else {
                        notify()->info('For Selected Payment Method Instant Refund is not available !');
                        return back();
                    }

                }

            } elseif ($order->payment_method == 'BankTransfer') {

                if ($request->source == 'bank') {
                    $cancelorderlog = new FullOrderCancelLog();
                    $cancelorderlog->order_id = $order->id;
                    $cancelorderlog->inv_id = $invArray;
                    $cancelorderlog->user_id = $order->user_id;
                    $cancelorderlog->comment = $request->comment;
                    $cancelorderlog->method_choosen = $request->source;
                    $cancelorderlog->amount = $finalAmount;
                    $cancelorderlog->bank_id = $request->bank_id;
                    $cancelorderlog->is_refunded = 'completed';
                    $cancelorderlog->txn_id = 'BANKT' . str_random(10);
                    $cancelorderlog->txn_fee = null;
                    $cancelorderlog->save();

                    $status = 1;
                }

            } else {

                $cancelorderlog = new FullOrderCancelLog();
                $cancelorderlog->order_id = $order->id;
                $cancelorderlog->inv_id = $invArray;
                $cancelorderlog->user_id = $order->user_id;
                $cancelorderlog->comment = $request->comment;
                $cancelorderlog->method_choosen = $request->source;
                $cancelorderlog->amount = $finalAmount;
                $cancelorderlog->is_refunded = 'completed';
                $cancelorderlog->txn_id = 'CANCOD' . str_random(10);
                $cancelorderlog->txn_fee = null;
                $cancelorderlog->bank_id = $request->bank_id;
                $cancelorderlog->save();

                $status = 1;
            }

            if ($status == 1) {

                $inv_cus = Invoice::first();

                foreach ($order->invoices as $value) {

                    if ($value
                        ->variant
                        ->products->cancel_avl != 0) {
                        if ($order->payment_method != 'COD' && $request->source != 'bank') {

                            InvoiceDownload::where('id', '=', $value->id)
                                ->update(['status' => 'refunded']);

                        }

                        if ($request->source == 'bank') {

                            InvoiceDownload::where('id', '=', $value->id)
                                ->update(['status' => 'Refund Pending']);
                        }

                        if ($order->payment_method == 'COD') {
                            InvoiceDownload::where('id', '=', $value->id)
                                ->update(['status' => 'canceled']);
                        }

                    }

                }

                foreach ($order->invoices as $value) {

                    if ($value
                        ->variant
                        ->products->cancel_avl != 0) {
                        $status = ucfirst('cancelled');

                        $create_activity = new OrderActivityLog();

                        $create_activity->order_id = $order->id;
                        $create_activity->inv_id = $value->id;
                        $create_activity->user_id = Auth::user()->id;
                        $create_activity->variant_id = $value->variant_id;
                        $create_activity->log = $status;

                        $create_activity->save();
                    }

                }

                /*Return back Qty*/
                foreach ($order->invoices as $value) {
                    if ($value
                        ->variant
                        ->products->cancel_avl != 0) {
                        $getpreviousStock = AddSubVariant::find($value->variant_id);

                        /*Adding Stock Back*/
                        $stock = $getpreviousStock->stock + $value->qty;

                        /*Updating Stock*/
                        $getpreviousStock->stock = $stock;
                        $getpreviousStock->save();
                    }
                }
                /*Returned*/

                $get_admins = User::where('role_id', '=', 'a')->get();
                $order_id = $order->order_id;
                $mstatus = ucfirst('cancelled');

                /*Sending notifcation to all admindesk*/
                \Notification::send($get_admins, new FullOrderCancelNotificationAdmin($inv_cus, $order_id, $mstatus));

                /*Sending notification to user*/
                User::findorfail($order->user_id)
                    ->notify(new FullOrderCancelNotification($inv_cus, $order_id, $mstatus));

                $config = Config::first();

                $orderiddb = $inv_cus->order_prefix . $order_id;

                if($config->sms_channel == '1'){

                    $smsmsg = 'Your Order #' . $orderiddb . ' has been ' . $status;

                    $smsmsg .= ' and amount ';

                    $smsmsg .= $order->paid_in_currency; // specify curreny code

                    $smsmsg .= $finalAmount; // specify amount

                    $smsmsg .= ' (IF Paid) is processed for refund to your choosen source ' . ucfirst($request->source) . ' account'; // specify source

                    $smsmsg .= '%0a - ' . config('app.name');

                    if(env('DEFAULT_SMS_CHANNEL') == 'msg91' && $config->msg91_enable == '1'){

                        try{
                            
                            User::find($order->user_id)->notify(new SMSNotifcations($smsmsg));
    
                        }catch(\Exception $e){
    
                            \Log::error('Error: '.$e->getMessage());
    
                        }

                    }

                    if(env('DEFAULT_SMS_CHANNEL') == 'twillo'){

                        try{
                            Twilosms::sendMessage($smsmsg, '+'.$order->user->phonecode.$order->user->mobile);
                        }catch(\Exception $e){
                            \Log::error('Twillo Error: '.$e->getMessage());
                        }

                    }
                }


                $venderSystem = Genral::first()->vendor_enable;

                /*Sending notification to vender*/
                if ($venderSystem == 1) {

                    if (is_array($order->vender_ids)) {

                        foreach ($order->vender_ids as $key => $v) {

                            $vender = User::find($v);

                            if (isset($vender)) {
                                if ($vender->role_id == 'v') {
                                    $msg = "Your Order $inv_cus
                                        ->order_prefix$order->order_id has been $mstatus";
                                    $url = route('seller.canceled.orders');
                                    $vender->notify(new SellerNotification($url, $msg));
                                }
                            }

                        }

                    }

                }
                /*end*/

                /*Send Mail to User*/
                $e = Address::findOrFail($order->delivery_address)->email;

                if (isset($e)) {
                    try {
                        Mail::to($e)->send(new FullOrderCancelMail($inv_cus, $order->order_id, $mstatus));
                    } catch (\Swift_TransportException $e) {

                    }
                }
                /*End*/
                Session::flash('updated', 'Following Order is Cancelled Successfully !');
                notify()->success('Following Order is Cancelled Successfully !');
                return back();

            }

        } else {
            Session::flash('warning', 'Unauthorized Action !');
            notify()->error('Unauthorized Action !');
            return back();
        }

    }

    public function singleOrderStatus(Request $request, $id)
    {
        $findCancelLog = CanceledOrders::findOrFail($id);

        $findCancelLog->is_refunded = $request->refund_status;

        $findCancelLog->amount = $request->amount;

        $findCancelLog->transaction_id = $request->transaction_id;

        $findCancelLog->txn_fee = $request->txn_fee;

        $singleorder = InvoiceDownload::findOrFail($findCancelLog->inv_id);

        $singleorder->status = $request->order_status;

        $findCancelLog->save();

        $singleorder->save();

        $newactivity = new OrderActivityLog();

        $newactivity->order_id = $findCancelLog->order_id;
        $newactivity->inv_id = $findCancelLog->inv_id;
        $newactivity->user_id = Auth::user()->id;
        $newactivity->variant_id = $findCancelLog
            ->singleorder->variant_id;
        $newactivity->log = ucfirst($request->order_status);
        $newactivity->save();

        return back()
            ->with('updated', 'Order Status Updated !');

    }

    public function fullOrderStatus(Request $request, $id)
    {

        $findCancelLog = FullOrderCancelLog::findOrFail($id);

        $findCancelLog->is_refunded = $request->refund_status;

        $findCancelLog->amount = $request->amount;

        $findCancelLog->txn_id = $request->transaction_id;

        $findCancelLog->txn_fee = $request->txn_fee;

        if (is_array($findCancelLog->inv_id)) {

            for ($i = 0; $i < count($findCancelLog->inv_id); $i++) {

                $singleorder = InvoiceDownload::findOrFail($findCancelLog->inv_id[$i]);
                $singleorder->status = $request->order_status[$i];
                $singleorder->save();

                $newactivity = new OrderActivityLog();

                $newactivity->order_id = $singleorder->order_id;
                $newactivity->inv_id = $singleorder->id;
                $newactivity->user_id = Auth::user()->id;
                $newactivity->variant_id = $singleorder->variant_id;
                $newactivity->log = ucfirst($request->order_status[$i]);
                $newactivity->save();

            }

        }

        $findCancelLog->save();

        return back()
            ->with('updated', 'Order Status Updated !');

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
