<?php

namespace App\Http\Controllers;

use App\FailedTranscations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Mollie\Laravel\Facades\Mollie;

class MolliePaymentController extends Controller
{
    public function pay(Request $request){

        $order_id = uniqid();

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

        $amount = sprintf("%.2f",Crypt::decrypt($request->amount));
 
        $total = sprintf("%.2f",$total * $conversion_rate);

        if (round($request->actualtotal, 2) != $total) {

            notify()->error('Payment has been modifed !','Please try again !');
            return redirect(route('order.review'));
        }

        try{

            $payment = Mollie::api()->payments->create([
                "amount" => [
                    "currency" => session()->get('currency')['id'],
                    "value" => $amount 
                ],
                "description" => "Payment for order $order_id",
                "redirectUrl" => route('mollie.callback'),
                "metadata" => [
                    "order_id" => "$order_id",
                ],
            ]);

            $payment = Mollie::api()->payments()->get($payment->id);
            Cookie::queue('payment_id', $payment->id,10);

            return redirect($payment->getCheckoutUrl(), 303);

        }catch(\Exception $e){

            notify()->error($e->getMessage());
            $failedTranscations = new FailedTranscations();
            $failedTranscations->txn_id = 'MOLLIE_FAILED_' . str_random(5);
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            return redirect(route('order.review'));

        }
    
        

    }

    public function callback(Request $request){

        require_once 'price.php';

        $payment = Mollie::api()->payments()->get(Cookie::get('payment_id'));

        if ($payment->isPaid()) {

            $txn_id = $payment->id;
                
            $payment_status = 'yes';

            $checkout = new PlaceOrderController;

            return $checkout->placeorder($txn_id,'Mollie',session()->get('order_id'),$payment_status);

        }else{
           
            notify()->error('Payment failed !');
            $failedTranscations = new FailedTranscations();
            $failedTranscations->txn_id = 'MOLLIE_FAILED_' . Str::uuid();
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            
            return redirect(route('order.review'));
        }

    }

   
}
