<?php

namespace App\Http\Controllers;

use App\CanceledOrders;
use App\FullOrderCancelLog;
use App\Order;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use PayPal\Api\Refund;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PaytmWallet;
use Razorpay\Api\Api;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Developer: @nkit              =
=            Copyright (c) 2020            =
==========================================*/

class TrackRefundController extends Controller
{
    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
            $paypal_conf['client_id'],
            $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function readorder(Request $request)
    {
        $id = $request->id;
        $data = CanceledOrders::findorfail($id);
        $data->read_at = date('Y-m-d H:i:s');
        $data->save();
    }

    public function readfullorder(Request $request)
    {
        $id = $request->id;
        $data = FullOrderCancelLog::findorfail($id);
        $data->read_at = date('Y-m-d H:i:s');
        $data->save();
    }

    public function singleOrderRefundTrack(Request $request, $id)
    {
        $data = CanceledOrders::findorfail($id);
        $order = Order::findorfail($data->order->id);
       
        if ($order->payment_method == 'Stripe') {

            //Grab TXN ID
            $txnid = $order->transaction_id;
            $refundtxnid = $data->transaction_id;
            $paygatename = $order->payment_method;

            $stripe = Stripe::make(env('STRIPE_SECRET'));
            $refund = $stripe->refunds()->find($txnid, $refundtxnid);

            $response = $refund;

        } elseif ($order->payment_method == 'Instamojo') {

            $caseid = $data->transaction_id;
            $paygatename = $order->payment_method;

            $api_key = env('IM_API_KEY');
            $auth_token = env('IM_AUTH_TOKEN');

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/refunds/' . $caseid);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                array("X-Api-Key:$api_key",
                    "X-Auth-Token:$auth_token"));

            $response = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response, true);

        } elseif ($order->payment_method == 'PayPal') {

            $saleid = $data->transaction_id;
            $paygatename = $order->payment_method;

            $response = Refund::get($saleid, $this->_api_context);

        } elseif ($order->payment_method == 'PayU') {
            $paygatename = $order->payment_method;
        } elseif ($order->payment_method == 'Paytm') {

            $paygatename = $order->payment_method;
            $refundStatus = PaytmWallet::with('refund_status');

            $refundStatus->prepare([
                'order' => $order->order_id,
                'reference' => 'refund-order-' . $order['order_id'],
            ]);

            $refundStatus->check();

            $result = $refundStatus->response();

            if ($refundStatus->isSuccessful()) {
                $response = $result;
            } else if ($refundStatus->isFailed()) {
                return 'Error';
            }

        } elseif ($order->payment_method == 'Razorpay') {
            $paygatename = $order->payment_method;
            $api = new Api(env('RAZOR_PAY_KEY'), env('RAZOR_PAY_SECRET'));
            $response = $api->payment->fetch($order->transaction_id)->refunds();

        }elseif ($order->payment_method == 'Paystack') {
            $paygatename = $order->payment_method;
            $curl = curl_init();
            $key = env('PAYSTACK_SECRET_KEY');
            $curl = curl_init();
  
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.paystack.co/transaction/$order->transaction_id",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $key",
                "Cache-Control: no-cache",
              ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            if ($err) {
              echo "cURL Error #:" . $err;
            }

            $response = json_decode($response,true);
            
        }else{
            return response()->json(['code' => 404, 'msg' => "Refund Tracking is not available currently for $order->payment_method"]);
        }
        return view('admindesk.order.refundstats', compact('response', 'paygatename', 'order', 'data'));
    }

    public function fullOrderRefundTrack(Request $request, $id)
    {
        $data = FullOrderCancelLog::findorfail($id);
        $order = Order::findorfail($data->getorderinfo->id);

        if ($order->payment_method == 'Stripe') {

            //Grab TXN ID
            $txnid = $order->transaction_id;
            $refundtxnid = $data->txn_id;
            $paygatename = $order->payment_method;

            $stripe = Stripe::make(env('STRIPE_SECRET'));
            $refund = $stripe->refunds()->find($txnid, $refundtxnid);

            $response = $refund;

        } elseif ($order->payment_method == 'Instamojo') {

            $caseid = $data->txn_id;
            $paygatename = $order->payment_method;

            $api_key = env('IM_API_KEY');
            $auth_token = env('IM_AUTH_TOKEN');

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://test.instamojo.com/api/1.1/refunds/' . $caseid);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                array("X-Api-Key:$api_key",
                    "X-Auth-Token:$auth_token"));

            $response = curl_exec($ch);
            curl_close($ch);

            $response = json_decode($response, true);

        } elseif ($order->payment_method == 'PayPal') {

            $saleid = $data->txn_id;
            $paygatename = $order->payment_method;

            $response = Refund::get($saleid, $this->_api_context);

        } elseif ($order->payment_method == 'PayU') {
            $paygatename = $order->payment_method;
        } elseif ($order->payment_method == 'Paytm') {

            $paygatename = $order->payment_method;
            $refundStatus = PaytmWallet::with('refund_status');

            $refundStatus->prepare([
                'order' => $order->order_id,
                'reference' => 'refund-order-' . $order['order_id'],
            ]);

            $refundStatus->check();

            $result = $refundStatus->response();

            if ($refundStatus->isSuccessful()) {
                $response = $result;
            } else if ($refundStatus->isFailed()) {
                return 'Error';
            }
        } elseif ($order->payment_method == 'Razorpay') {
            $paygatename = $order->payment_method;
            $api = new Api(env('RAZOR_PAY_KEY'), env('RAZOR_PAY_SECRET'));
            $response = $api->payment->fetch($order->transaction_id)->refunds();
        } elseif ($order->payment_method == 'Paystack') {
            $paygatename = $order->payment_method;
            $curl = curl_init();
            $key = env('PAYSTACK_SECRET_KEY');
            $curl = curl_init();
  
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://api.paystack.co/transaction/$order->transaction_id",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 30,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer $key",
                "Cache-Control: no-cache",
              ),
            ));
            
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            
            if ($err) {
              echo "cURL Error #:" . $err;
            }

            $response = json_decode($response,true);
            
        }else{
            return response()->json(['code' => 404, 'msg' => "Refund Tracking is not available currently for $order->payment_method"]);
        }

        return view('admindesk.order.refundstatsfull', compact('response', 'paygatename', 'order', 'data'));
    }
}
