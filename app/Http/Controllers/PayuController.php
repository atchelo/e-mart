<?php
namespace App\Http\Controllers;

use App\Address;
use App\FailedTranscations;
use App\Invoice;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tzsk\Payu\Concerns\Attributes;
use Tzsk\Payu\Concerns\Customer;
use Tzsk\Payu\Concerns\Transaction;
use Tzsk\Payu\Facades\Payu;
use Illuminate\Support\Str;

class PayuController extends Controller
{

    public function refund()
    {

        $ch = curl_init();
        $postUrl = 'https://test.payumoney.com/treasury/merchant/refundPayment?merchantKey=kOFGXHRT&paymentId=249863078&refundAmount=224';

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $postUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'authorization: 6+m8xqo3Kmhr+FNF3QkGn+rzLxCn2LI3idnZuumgiVY=',
        ));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);

        $result = json_decode($output, true);

        return $result;

    }

    public function payment(Request $request)
    {
        require_once 'price.php';

        $amount = Crypt::decrypt($request->amount);

        $inv_cus = Invoice::first();
        $order_id = Session::get('order_id');

        if (Session::get('currency')['id'] != 'INR') {
            notify()->error('Currency is in ' . strtoupper(Session::get('currency')['id']) . ' and payumoney only support INR currency.');
            return redirect(route('order.review'));
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

            notify()->error('Payment has been modifed !', 'Please try again !');
            return redirect(route('order.review'));

        }

        $txnid = strtoupper(str_random(8));
        Session::put('gen_txn', $txnid);

        $adrid = Session::get('address');

        $address = Address::find($adrid);

        $customer = Customer::make()
        ->firstName($address->name)
        ->email($address->email)
        ->phone($address->phone);

        $attributes = Attributes::make()
        ->udf1("Payment For Order $inv_cus->order_prefix $order_id");

        $transaction = Transaction::make()
        ->charge($amount)
        ->for('Product')
        ->with($attributes)
        ->to($customer);



        return Payu::initiate($transaction)->redirect(url('payment/status'));

    }

    public function status()
    {
        require_once 'price.php';

        $payment = Payu::capture();  

        if ( $payment->successful() ) {

            $txn_id = $payment->response('payuMoneyId');

            $payment_status = 'yes';

            $checkout = new PlaceOrderController;

            return $checkout->placeorder($txn_id,'PayU',session()->get('order_id'),$payment_status);

        } else {

            notify()->error("Payment not done due to some payumoney server issue !");
            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = 'PAYU_FAILED_' . Str::uuid();
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            return redirect(route('order.review'));

        }

    }
}
