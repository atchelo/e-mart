<?php

namespace App\Http\Controllers;

use App\Address;
use App\FailedTranscations;
use App\Library\SslCommerz\SslCommerzNotification;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;

class SslCommerzPaymentController extends Controller
{

    public function index(Request $request)
    {
        require_once 'price.php';

        if(session()->get('currency')['id'] !='BDT'){
            notify()->error('Sorry ONLY BDT (Takka) currency supported !');
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

            notify()->error('Payment has been modifed !','Please try again !');
            return redirect(route('order.review'));

        }

        if (round(Crypt::decrypt($request->amount), 2) < 10) {

            notify()->error('Amount is less than 10 not allowed');
            return redirect(route('order.review'));
        }

        $adrid = Session::get('address');

        $address = Address::find($adrid);

        if (!$address) {

            notify()->error('Payment has been modifed !','Please try again !');
            return redirect(route('order.review'));
        }

        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] =  round(Crypt::decrypt($request->amount), 2); # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = uniqid(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $address->name;
        $post_data['cus_email'] = $address->email;
        $post_data['cus_add1'] = $address->address;
        $post_data['cus_add2'] = "";
        $post_data['cus_city'] = $address->getcity->name;
        $post_data['cus_state'] = $address->getstate->name;
        $post_data['cus_postcode'] = $address->pin_code;
        $post_data['cus_country'] = $address->getCountry->nicename;
        $post_data['cus_phone'] = $address->phone;
        $post_data['cus_fax'] = "";

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = $address->name;
        $post_data['ship_add1'] = $address->address;
        $post_data['ship_add2'] = $address->address;
        $post_data['ship_city'] = $address->getcity->name;
        $post_data['ship_state'] = $address->getstate->name;
        $post_data['ship_postcode'] = $address->pin_code;
        $post_data['ship_phone'] = $address->phone;
        $post_data['ship_country'] = $address->getCountry->nicename;

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "sddf";
        $post_data['product_category'] = "dfddf";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = "ref001";
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }

    }

    public function success(Request $request)
    {
       
        require_once 'price.php';

       

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $payment_method = $request->card_issuer;
        $sslc = new SslCommerzNotification();

        $validation = $sslc->orderValidate($tran_id, $amount, $currency, $request->all());

        if ($validation == true) {

            $payment_status = 'yes';

            $checkout = new PlaceOrderController;

            return $checkout->placeorder($tran_id,$payment_method,session()->get('order_id'),$payment_status);

        } else {
            $failedTranscations = new FailedTranscations();
            $failedTranscations->txn_id = $tran_id;
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            notify()->error('Payment Failed !');
            return redirect(route('order.review'));
        }

    }

    public function fail(Request $request)
    {

        $failedTranscations = new FailedTranscations();
        $failedTranscations->txn_id = $request->input('tran_id');
        $failedTranscations->user_id = auth()->id();
        $failedTranscations->save();

        notify()->error('Payment failed !');
        return redirect(route('order.review'));

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        notify()->error('Payment canceled !',$tran_id);
        return redirect(route('order.review'));

    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($tran_id, $order_details->amount, $order_details->currency, $request->all());
                if ($validation == true) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                     */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                     */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Failed']);

                    echo "validation Fail";
                }

            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}
