<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CanceledOrders;
use App\FullOrderCancelLog;
use Auth;
use App\Invoice;
use App\Order;
use App\AddSubVariant;
use App\Address;
use App\InvoiceDownload;
use Crypt;
use PayPal\Api\Amount;
use PayPal\Api\Refund;
use PayPal\Api\Sale;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Session;
use App\multiCurrency;
use App\CurrencyList;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use App\OrderActivityLog;
use Mail;
use App\Mail\FullOrderCancelMail;
use App\Notifications\FullOrderCancelNotification;
use App\Notifications\FullOrderCancelNotificationAdmin;
use App\Notifications\SellerNotification;
use App\User;
use App\Genral;
use PaytmWallet;

class SellerCancelOrderController extends Controller
{
    private $_api_context;

    public function __construct() {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function index(){

    	$sellercanorders = collect();

    	$allcanorders = CanceledOrders::with(['singleOrder.order','singleOrder.order.user','singleOrder','singleOrder.variant','singleOrder.variant.products','singleOrder.variant.variantimages'])->whereHas('singleOrder.order')->whereHas('singleOrder.variant.products')->whereHas('singleOrder.order.user')->whereHas('singleOrder.variant')->whereHas('singleOrder')->latest()->get();

        $allfullcanceledorders = FullOrderCancelLog::with(['getorderinfo','user','getorderinfo.invoices','getorderinfo.invoices.variant'])->whereHas('getorderinfo.invoices.variant')->whereHas('user')->whereHas('getorderinfo')->latest()->get();

        $unreadorder = collect();
        $unreadorder2 = collect();

    	/*partial cancel order section*/

            $allcanorders->each(function($value) use($sellercanorders) {
                if($value->singleOrder->vender_id == Auth::user()->id){

                    $sellercanorders->push($value);

                }
            });

            $sellercanorders->each(function($value) use($unreadorder) {
                if($value->read_at == NULL){
                    $unreadorder->push($value);
                }
            });
        /*end*/

        /*full order detect per seller section*/

            $sellerfullcanorders = collect();
            $total = 0;
        
            foreach ($allfullcanceledorders as $key => $forder) {
                 $order = Order::find($forder->order_id);

                 if(in_array(Auth::user()->id, $order->vender_ids)){
                    $sellerfullcanorders->push($forder);
                 }
            }

            foreach ($sellerfullcanorders as $key => $sorder) {

                if($sorder->read_at == NULL){
                    $unreadorder2->push($sorder);
                }
                
            }
        /*end*/
        
        $partialcount = count($unreadorder);
        $partialcount2 = count($unreadorder2);

    	$inv_cus = Invoice::first();


    	
    	return view('seller.order.cancelorders.index',compact('partialcount2','inv_cus','partialcount','sellercanorders','sellerfullcanorders'));

    }

    public function updatefullcancelorder(Request $request,$id){

         $forder = FullOrderCancelLog::findorfail($id);

         $findorder = Order::findorfail($forder->order_id);

         $empty = collect();

        

         foreach ($findorder->invoices as $key => $order) {
                
            foreach ($forder->inv_id as $key => $invid) {
                
                if($invid == $order->id && Auth::user()->id == $order->vender_id){
                        
                    $empty->push($order);

                }

            }

         }

            foreach ($empty as $k => $e) {
                
                $inv = InvoiceDownload::find($e->id);
                $inv->status = $request->order_status[$k];
                $inv->save();

                

            }

            return back()->with('updated','Order Status has been Updated !');



    }

    public function processfullorder(Request $request,$secureid){


        $orderID = Crypt::decrypt($secureid);

        $order = Order::findorfail($orderID);
        $finalAmount = 0;
        $status = 0;
        $invArray = collect();

        foreach ($order->invoices as $value) {

            if($value->variant->products->cancel_avl != 0 && Auth::user()->id == $value->vender_id){
                

                $invArray->push($value->id);
                $finalAmount = $finalAmount+$value->price+$value->tax_amount+$value->shipping;
                

            }
            
        }

       

        if (Auth::user()->role_id == 'a' ||  in_array(Auth::user()->id, $order->vender_ids)) {

           
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
                    $cancelorderlog->txn_id = 'TXNBNK' . str_random(10);
                    $cancelorderlog->txn_fee = NULL;
                    $cancelorderlog->save();

                    $status = 1;

                } elseif ($request->source == 'orignal') {

                    if ($order->payment_method == 'PayPal') {

                        $fCurrency = multiCurrency::where('currency_symbol', '=', $order->paid_in)->first();

                        $setCurrency = CurrencyList::findOrFail($fCurrency->currency_id)->code;

                        $amt = new Amount();
                        $amt->setTotal($finalAmount)
                            ->setCurrency($setCurrency);
                        $saleId = $order->sale_id;
                        $refund = new Refund();
                        $refund->setAmount($amt);
                        $sale = new Sale();
                        $sale->setId($saleId);

                        try {

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
                            
                        } catch (Exception $ex) {
                            die($ex);
                        }

                    } elseif ($order->payment_method == 'Stripe') {

                        $stripe = new Stripe();
                        $stripe = Stripe::make(env('STRIPE_SECRET'));

                        $charge_id = $order->transaction_id;
                        $amount = $finalAmount;

                        try {

                            $refund = $stripe->refunds()->create($charge_id, $amount, [

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
                            $cancelorderlog->txn_fee = NULL;
                            $cancelorderlog->save();

                            $status = 1;

                        } catch (\Exception $e) {
                            $error = $e->getMessage();
                            Session::flash('deleted', $error);
                            return back()->with('failure', $error);
                        }

                    } elseif ($order->payment_method == 'Instamojo') {

                        //Instamojo Refund code
                        try {

                            $ch = curl_init();
                            $api_key = env('IM_API_KEY');
                            $auth_token = env('IM_AUTH_TOKEN');
                            curl_setopt($ch, CURLOPT_URL, env('IM_REFUND_URL'));
                            curl_setopt($ch, CURLOPT_HEADER, FALSE);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
                            curl_setopt($ch, CURLOPT_HTTPHEADER,

                                array("X-Api-Key:$api_key",
                                    "X-Auth-Token:$auth_token"));

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
                                $cancelorderlog->txn_fee = NULL;
                                $cancelorderlog->save();

                                $status = 1;

                            } else {
                                Session::flash('warning', $conversion_rate['message']);
                                return back()->with('failure', $conversion_rate['message']);
                            }

                        } catch (\Exception $e) {
                            $error = $e->getMessage();
                            Session::flash('warning', $error);
                            return back()->with('failure', $error);
                        }

                    } elseif ($order->payment_method == 'PayU') {
                        Session::flash('warning', 'Error In PAYU SIDE Will added soon when PAYU solve it use bank transfer method till that');
                        return back()->with('failure', 'Error In PAYU SIDE Will added soon when PAYU solve it use bank transfer method till that');
                    }
                    elseif ($order->payment_method == 'Paytm') {
                        $refund = PaytmWallet::with('refund');

                        $refund->prepare(['order' => $order['order_id'], 'reference' => 'refund-order-' . $order['order_id'], 'amount' => $finalAmount, 'transaction' => $order->transaction_id]);

                        $refund->initiate();
                        $response = $refund->response();

                        if ($refund->isSuccessful())
                        {

                            $cancelorderlog = new FullOrderCancelLog();
                            $cancelorderlog->order_id = $order->id;
                            $cancelorderlog->inv_id = $invArray;
                            $cancelorderlog->user_id = $order->user_id;
                            $cancelorderlog->comment = $request->comment;
                            $cancelorderlog->method_choosen = $request->source;
                            $cancelorderlog->amount = $response['REFUNDAMOUNT'];
                            $cancelorderlog->is_refunded = 'completed';
                            $cancelorderlog->txn_id = $response['REFUNDID'];
                            $cancelorderlog->txn_fee = NULL;
                            $cancelorderlog->save();

                            $status = 1;

                        }
                        else if ($refund->isFailed())
                        {

                            if ($response['STATUS'] == 'TXN_FAILURE')
                            {

                                notify()->error($response['RESPMSG']);
                                return back();

                            }

                        }
                        else if ($refund->isOpen())
                        {
                            #nocode
                            
                        }
                        else if ($refund->isPending())
                        {
                            #nocode
                            
                        }
                    }

                }

            }elseif($order->payment_method == 'BankTransfer'){

                if($request->source == 'bank'){
                    $cancelorderlog = new FullOrderCancelLog();
                    $cancelorderlog->order_id = $order->id;
                    $cancelorderlog->inv_id = $invArray;
                    $cancelorderlog->user_id = $order->user_id;
                    $cancelorderlog->comment = $request->comment;
                    $cancelorderlog->method_choosen = $request->source;
                    $cancelorderlog->amount = $finalAmount;
                    $cancelorderlog->is_refunded = 'completed';
                    $cancelorderlog->txn_id = 'BANKT' . str_random(10);
                    $cancelorderlog->txn_fee = NULL;
                    $cancelorderlog->save();

                    $status = 1;
                }

            }else {

                $cancelorderlog = new FullOrderCancelLog();
                $cancelorderlog->order_id = $order->id;
                $cancelorderlog->inv_id = $invArray;
                $cancelorderlog->user_id = $order->user_id;
                $cancelorderlog->comment = $request->comment;
                $cancelorderlog->method_choosen = $request->source;
                $cancelorderlog->amount = $finalAmount;
                $cancelorderlog->is_refunded = 'completed';
                $cancelorderlog->txn_id = 'CANCOD' . str_random(10);
                $cancelorderlog->txn_fee = NULL;
                $cancelorderlog->save();

                $status = 1;
            }

            if ($status == 1) {

                $inv_cus = Invoice::first();

                foreach ($order->invoices as $value) {

                    if($value->variant->products->cancel_avl != 0 && Auth::user()->id == $value->vender_id){
                        
                        if ($order->payment_method != 'COD' && $request->source != 'bank') {

                        InvoiceDownload::where('id', '=', $value->id)->update(['status' => 'refunded']);

                        }

                        if ($request->source == 'bank') {

                            InvoiceDownload::where('id', '=', $value->id)->update(['status' => 'Refund Pending']);
                        }

                        if ($order->payment_method == 'COD') {
                            InvoiceDownload::where('id', '=', $value->id)->update(['status' => 'canceled']);
                        }

                    }
                    

                }

                foreach ($order->invoices as $value) {

                    if($value->variant->products->cancel_avl != 0 && Auth::user()->id == $value->vender_id){
                    
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
                        if($value->variant->products->cancel_avl != 0 && Auth::user()->id == $value->vender_id){
                            $getpreviousStock = AddSubVariant::find($value->variant_id);

                        /*Adding Stock Back*/
                            $stock = $getpreviousStock->stock+$value->qty;

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

                /*Sending notifcation to user*/
                User::findorfail($order->user_id)->notify(new FullOrderCancelNotification($inv_cus, $order_id, $mstatus));

                $venderSystem = Genral::first()->vendor_enable;

                /*Sending notification to vender*/
                    if($venderSystem == 1){

                        if(is_array($order->vender_ids)){

                            foreach ($order->vender_ids as $key => $v) {
                                 
                                 $vender = User::find($v);

                                 if(isset($vender)){
                                    if($vender->role_id == 'v'){
                                        $msg = "Your Order $inv_cus->order_prefix$order_id has been $mstatus";
                                        $url = route('seller.canceled.orders');
                                        $vender->notify(new SellerNotification($url,$msg));
                                    }
                                 }

                            }

                        }   

                    }
                /*end*/

                /*Send Mail to User*/
                $e = Address::findOrFail($order->delivery_address)->email;

                if (isset($e)) {
                    Mail::to($e)->send(new FullOrderCancelMail($inv_cus, $order->order_id, $mstatus));
                }
                /*End*/
                Session::flash('updated', 'Following Order is Cancelled Successfully !');
                return back()->with('success', 'Following Order is Cancelled Successfully !');

            }

        } else {
            Session::flash('warning', '401 Unauthorized Action !');
            return back()->with('failure', '401 Unauthorized Action !');
        }
    }
}
