<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Obydul\LaraSkrill\SkrillClient;
use Obydul\LaraSkrill\SkrillRequest;

class SkrillController extends Controller
{
    private $skrilRequest;

    public function __construct()
    {
        // skrill config
        $this->skrilRequest = new SkrillRequest();
        $this->skrilRequest->pay_to_email = env('SKRILL_MERCHANT_EMAIL'); // merchant email
        $this->skrilRequest->return_url = route('skrill.success');
        $this->skrilRequest->cancel_url = url('/checkout');
        $this->skrilRequest->logo_url = url('/images/genral/logo.png'); // optional
        $this->skrilRequest->status_url = 'IPN URL or Email';
        $this->skrilRequest->status_url2 = 'IPN URL or Email'; // optional
    }

    public function pay(Request $request)
    {

        require_once 'price.php';

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

        $amount = sprintf("%.2f", Crypt::decrypt($request->amount));

        if (round($request->actualtotal, 2) != $total) {

            notify()->error('Payment has been modifed !', 'Please try again !');
            return redirect(route('order.review'));

        }

        // Create object instance
        $request = new SkrillRequest();
        $client = new SkrillClient($request);
        $sid = $client->generateSID();

        $jsonSID = json_decode($sid);

        if ($jsonSID != null && $jsonSID->code == "BAD_REQUEST") {
            return $jsonSID->message;
        }

        $order_id = uniqid();

        session()->put('order_id',$order_id);
        // create object instance of SkrillRequest
        $this->skrilRequest->transaction_id = str_random(5); // generate transaction id
        $this->skrilRequest->amount = $amount;
        $this->skrilRequest->currency = session()->get('currency')['id'];
        $this->skrilRequest->language = session()->get('changed_language');
        $this->skrilRequest->prepare_only = '1';
        $this->skrilRequest->merchant_fields = 'site_name, customer_email';
        $this->skrilRequest->site_name = config('app.name');
        $this->skrilRequest->customer_email = Auth::user()->email;
        $this->skrilRequest->detail1_description = "Payment for order $order_id";

        // create object instance of SkrillClient
        $client = new SkrillClient($this->skrilRequest);
        $sid = $client->generateSID(); //return SESSION ID

        // handle error
        $jsonSID = json_decode($sid);
        if ($jsonSID != null && $jsonSID->code == "BAD_REQUEST") {
            return $jsonSID->message;
        }

        // do the payment
        $redirectUrl = $client->paymentRedirectUrl($sid); //return redirect url
        return Redirect::to($redirectUrl); // redirect user to Skrill payment page
    }

    public function success(Request $request)
    {
        require_once 'price.php';

        $txn_id = $request->transaction_id;

        $payment_status = 'yes';

        $checkout = new PlaceOrderController;

        return $checkout->placeorder($txn_id,'Skrill',session()->get('order_id'),$payment_status);
    }
}
