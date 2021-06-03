<?php

namespace App\Http\Controllers;

use App\FailedTranscations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Paystack;
use Illuminate\Support\Str;

class PaystackController extends Controller
{
    public function pay(Request $request){
        require 'price.php';
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

        $total = sprintf("%.2f",$total*$conversion_rate);

        if (round($request->actualtotal, 2) != $total) {

            notify()->error('Payment has been modifed !','Please try again !');
            return redirect(route('order.review'));

        }


        if (Session::get('currency')['id'] != 'NGN') {
            notify()->error('Paystack only support NGN currency.');
            return redirect(route('order.review'));
        }

        /** If Payment is valid than redirect to thier Paystack Payment Page */
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e){
            
            notify()->error($e->getMessage());
            return redirect(route('order.review'));
        }
    }

    public function callback(){
        
        $paymentDetails = Paystack::getPaymentData();
        

        if($paymentDetails['data']['status'] == 'success'){

            $txn_id = $paymentDetails['data']['id'];
            
            $payment_status = 'yes';

            $checkout = new PlaceOrderController;

            return $checkout->placeorder($txn_id,'Paystack',session()->get('order_id'),$payment_status);

        }else {
            $failedTranscations = new FailedTranscations();
            $failedTranscations->order_id = session()->get('order_id');
            $failedTranscations->txn_id = 'PAYSTACK_FAILED_' . Str::uuid();
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            notify()->error($paymentDetails['data']['message']);
            return redirect(route('order.review'));
        }

    }
}
