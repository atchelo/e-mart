<?php
namespace App\Http\Controllers;


use App\User;
use Braintree;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class BrainTreeController extends Controller
{

    public function accesstoken()
    {
        $gateway = $this->brainConfig();
        $clientToken = $gateway->clientToken()->generate();
        return response()->json(array('client' => $clientToken));
    }

    public function process(Request $request)
    {
        require 'price.php';
        $gateway = $this->brainConfig();

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

        $response = $gateway->transaction()->sale([
            'amount' => Crypt::decrypt($request->amount),
            'paymentMethodNonce' => $request->payment_method_nonce,
            'customerId' => $this->createCustomer(),
            'options' => [
                'submitForSettlement' => true,
            ],
        ]);

        require_once 'price.php';

        /** Checking If Payment is successfull or not */
        if ($response->success == true) {

           
            $txn_id = $response->transaction->id;

            $payment_status = 'yes';

            $checkout = new PlaceOrderController;

            return $checkout->placeorder($txn_id,'Braintree',session()->get('order_id'),$payment_status);

            
        } else {

            notify()->error($response->message);
            return redirect(route('order.review'));
        }
    }

    public function createCustomer()
    {

        if (!Auth::user()->braintree_id) {

            $gateway = $this->brainConfig();

            $result = $gateway->customer()->create([
                'firstName' => Auth::user()->name,
                'email' => Auth::user()->email,
            ]);

            if ($result->success) {
                User::where('id', Auth::user()->id)->update(['braintree_id' => $result->customer->id]);
                return $result->customer->id;
            }

        } else {
            return Auth::user()->braintree_id;
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
