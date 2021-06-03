<?php
namespace App\Http\Controllers;

use App\Address;
use App\AddSubVariant;
use App\Cart;
use App\Config;
use App\Coupan;
use App\FailedTranscations;
use App\Genral;
use App\Invoice;
use App\InvoiceDownload;
use App\Mail\OrderMail;
use App\Notifications\OrderNotification;
use App\Notifications\SellerNotification;
use App\Notifications\SMSNotifcations;
use App\Notifications\UserOrderNotification;
use App\Order;
use App\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Mail;
use Razorpay\Api\Api;
use Redirect;
use Session;
use Twilosms;

class PayViaRazorPayController extends Controller
{

    public function payment(Request $request)
    {
        //Input items of form
        require_once 'price.php';
        $input = $request->all();

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

        //get API Configuration
        $api = new Api(env('RAZOR_PAY_KEY'), env('RAZOR_PAY_SECRET'));
        
        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        require_once 'price.php';

        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try
            {

                $response = $api
                    ->payment
                    ->fetch($input['razorpay_payment_id'])->capture(array(
                    'amount' => $payment['amount'],
                ));

                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                $txn_id = $payment->id;

                $payment_status = 'yes';

                $checkout = new PlaceOrderController;

                return $checkout->placeorder($txn_id,'Razorpay',session()->get('order_id'),$payment_status);
                

            } catch (\Exception $e) {
                notify()->error($e->getMessage());
                $sentfromlastpage = 0;
                $failedTranscations = new FailedTranscations;
                $failedTranscations->order_id = $input['razorpay_payment_id'];
                $failedTranscations->txn_id = $input['razorpay_payment_id'];
                $failedTranscations->user_id = Auth::user()->id;
                $failedTranscations->save();
                return redirect()->route('order.review');
            }

        }

    }
}
