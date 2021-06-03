<?php
namespace App\Http\Controllers;

use App\Address;
use App\FailedTranscations;
use App\Invoice;
use Auth;
use Crypt;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Str;

class InstamojoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function payment(Request $request)
    {   

    
        require_once 'price.php';

        $adrid = Session::get('address');

        $address = Address::find($adrid);

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
        
       
        $total = sprintf("%.2f",$total * $conversion_rate);

        if (round($request->actualtotal, 2) != $total) {

            notify()->error('Payment has been modifed !','Please try again !');
            return redirect(route('order.review'));

        }

        $inv_cus = Invoice::first();

        $order_id = Session::get('order_id');

        $amount = round(Crypt::decrypt($request->amount), 2);

        $api = new \Instamojo\Instamojo(config('services.instamojo.api_key'), config('services.instamojo.auth_token'), config('services.instamojo.url'));

        try
        {

            $url = url('/paidsuccess');
            $response = $api->paymentRequestCreate(array(
                "purpose" => "Payment For Order $inv_cus->order_prefix $order_id",
                "amount" => $amount,
                "buyer_name" => Auth::user()->name,
                "send_email" => true,
                "send_sms" => true,
                "email" => $address->email,
                "phone" => $address->phone,
                "redirect_url" => $url,
            ));

            header('Location: ' . $response['longurl']);

            exit();
        } catch (\Exception $e) {
            print('Error: ' . $e->getMessage());
            $failedTranscations = new FailedTranscations;
            $failedTranscations->order_id = $order_id;
            $failedTranscations->txn_id = 'INSTAMOJO_FAILED_' . str_rand(5);
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
        }

    }

    public function success(Request $request)
    {

        try
        {

            $api = new \Instamojo\Instamojo(config('services.instamojo.api_key'), config('services.instamojo.auth_token'), config('services.instamojo.url'));

            $response = $api->paymentRequestStatus(request('payment_request_id'));

            if (!isset($response['payments'][0]['status'])) {

                notify()->error('Payment Failed !');

                return redirect(route('order.review'));

            } else if ($response['payments'][0]['status'] != 'Credit') {

                notify()->error('Payment Failed !');
                return redirect(route('order.review'));

            } else {

                $txn_id = $response['payments'][0]['payment_id'];

                $payment_method = 'Instamojo';

                $order_id = session()->get('order_id');

                $payment_status = 'yes';

                $checkout = new PlaceOrderController;

                return $checkout->placeorder($txn_id,$payment_method,$order_id,$payment_status);

            }
        } catch (\Exception $e) {

            notify()->error($e->getMessage());
            $failedTranscations = new FailedTranscations;
            $failedTranscations->txn_id = 'INSTAMOJO_FAILED_' . Str::uuid();
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            return redirect(route('order.review'));
        }

    }

    #endoflast

}
