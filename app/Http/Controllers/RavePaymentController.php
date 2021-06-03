<?php

namespace App\Http\Controllers;


use App\FailedTranscations;
use Auth;
use Illuminate\Http\Request;
use Rave;
use Illuminate\Support\Str;

class RavePaymentController extends Controller
{
    public function pay(Request $request){

        require_once 'price.php';

        $cart_table = Auth::user()->cart;
        $total = 0;
        $total = sprintf("%.2f",$total * $conversion_rate);

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

        $total = sprintf("%.2f",$total * $conversion_rate);

        if (sprintf("%.2f",$request->actualtotal) != $total) {
            notify()->error('Payment has been modifed !','Please try again !');
            return redirect(route('order.review'));

        }

        if(session()->get('currency')['id'] != 'NGN'){
            notify()->warning('Currency not supported !');
            return redirect(route('order.review'));
        }

        Rave::initialize(route('rave.callback'));
    }

    public function callback(Request $request){

        require_once 'price.php';

        $result = json_decode($request->resp, true);

        $txn_id = $result['tx']['txRef'];

        $data = Rave::verifyTransaction($txn_id);

        if ($data->status == 'success') {

            $payment_status = 'yes';

            $checkout = new PlaceOrderController;

            return $checkout->placeorder($txn_id,'Rave',session()->get('order_id'),$payment_status);

        }else{

            notify()->error('Payment Failed !');
            $failedTranscations = new FailedTranscations();
            $failedTranscations->txn_id = 'RAVE_FAILED_' . Str::uuid();
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            return redirect(route('order.review'));
            
        }

    }
}
