<?php

namespace App\Http\Controllers;

use App\Address;

use App\FailedTranscations;
use App\Invoice;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class CashfreeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->apiEndpoint = env('CASHFREE_END_POINT');
    }

    public function pay(Request $request)
    {

        if (session()->get('currency')['id'] != 'INR') {
            notify()->error('Cashfree Only Support INR Payment !');
            return redirect(route('order.review'));
        }

        require_once 'price.php';

        $adrid = Session::get('address');

        $address = Address::findOrFail($adrid);

        $c = strlen($address->phone);

        if ($c < 10) {

            $sentfromlastpage = 0;
            notify()->error("Invalid Phone no. ");
            return view('front.checkout', compact('conversion_rate', 'sentfromlastpage'));
        }

        $cart_table = Auth::user()->cart;
        $total = 0;

        foreach ($cart_table as $cart) {

            if ($cart->product->tax_r != null && $cart->product->tax == 0) {

                if ($cart->ori_offer_price != 0) {
                    //get per product tax amount
                    $p = 100;
                    $taxrate_db = $cart->product->tax_r;
                    $vp = $p + $taxrate_db;
                    $taxAmnt = $cart->product->offer_price / $vp * $taxrate_db;
                    $taxAmnt = sprintf("%.2f", $taxAmnt);
                    $price = ($cart->ori_offer_price - $taxAmnt) * $cart->qty;

                } else {

                    $p = 100;
                    $taxrate_db = $cart->product->tax_r;
                    $vp = $p + $taxrate_db;
                    $taxAmnt = $cart->product->price / $vp * $taxrate_db;

                    $taxAmnt = sprintf("%.2f", $taxAmnt);

                    $price = ($cart->ori_price - $taxAmnt) * $cart->qty;
                }

            } else {

                if ($cart->semi_total != 0) {

                    $price = $cart->semi_total;

                } else {

                    $price = $cart->price_total;

                }
            }

            $total = $total + $price;

        }

        $total = sprintf("%.2f", $total * $conversion_rate);

        if (round($request->actualtotal, 2) != $total) {

            notify()->error('Payment has been modifed !','Please try again !');
            return redirect(route('order.review'));

        }

        $amount = round(Crypt::decrypt($request->amount), 2);

        $opUrl = $this->apiEndpoint . "/api/v1/order/create";

        $orderid = uniqid();

        session()->put('order_id',$orderid);

        $cf_request = array();
        $cf_request["appId"] = env('CASHFREE_APP_ID');
        $cf_request["secretKey"] = env('CASHFREE_SECRET_KEY');
        $cf_request["orderId"] = $orderid;
        $cf_request["orderAmount"] = $amount;
        $cf_request["orderNote"] = "Payment for Order $orderid";
        $cf_request["customerPhone"] = $address->phone;
        $cf_request["customerName"] = Auth::user()->name;
        $cf_request["customerEmail"] = Auth::user()->email;
        $cf_request["returnUrl"] = url('payviacashfree/success');

        $timeout = 20;

        $request_string = "";

        foreach ($cf_request as $key => $value) {
            $request_string .= $key . '=' . rawurlencode($value) . '&';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "$opUrl?");
        curl_setopt($ch, CURLOPT_POST, count($cf_request));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $curl_result = curl_exec($ch);
        curl_close($ch);

        $jsonResponse = json_decode($curl_result);

        if ($jsonResponse->{'status'} == "OK") {
            $paymentLink = $jsonResponse->{"paymentLink"};
            return redirect($paymentLink);
        } else {
            
            notify()->warning($jsonResponse->{'reason'});
            return redirect(route('order.review'));
        }
    }

    public function success(Request $request)
    {

        require_once 'price.php';

        if ($request->txStatus == 'CANCELLED') {
            Session::put('from-pay-page', 'yes');
            Session::put('page-reloaded', 'yes');
            notify()->warning($request->txMsg);
            return redirect(route('order.review'));
        }

        $response = Http::timeout(30)->withHeaders(["cache-control: no-cache"])->asForm()->post($this->apiEndpoint . '/api/v1/order/info/status', [
            'appId' => env('CASHFREE_APP_ID'),
            'secretKey' => env('CASHFREE_SECRET_KEY'),
            'orderId' => $request->orderId,
        ]);

        if ($response->successful()) {

            $result = $response->json();

            if ($result['orderStatus'] == 'PAID') {

                
                $txn_id = $result['referenceId'];

                $payment_status = 'yes';

                $checkout = new PlaceOrderController;

                return $checkout->placeorder($txn_id,'Cashfree',session()->get('order_id'),$payment_status);

                
            } else {
                notify()->error('Payment Failed !');
                $failedTranscations = new FailedTranscations();
                $failedTranscations->txn_id = 'CASHFREE_FAILED_' . Str::uuid();
                $failedTranscations->user_id = Auth::user()->id;
                $failedTranscations->save();
                return redirect(route('order.review'));
            }

        } else {
            notify()->error('Payment Failed !');
            $failedTranscations = new FailedTranscations();
            $failedTranscations->txn_id = 'CASHFREE_FAILED_' . Str::uuid();
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            return redirect(route('order.review'));
        }

    }
}
