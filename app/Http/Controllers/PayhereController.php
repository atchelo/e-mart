<?php

namespace App\Http\Controllers;

use App\FailedTranscations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PayhereController extends Controller
{

    public function callback(Request $request)
    {

        $authcode = base64_encode(env('PAYHERE_BUISNESS_APP_CODE') . ':' . env('PAYHERE_APP_SECRET'));

        require_once 'price.php';

        if (env('PAYHERE_MODE') == 'sandbox') {
            $tokenurl = 'https://sandbox.payhere.lk/merchant/v1/oauth/token';
        } else {
            $tokenurl = 'https://www.payhere.lk/merchant/v1/oauth/token';
        }

        $response = Http::asForm()->withHeaders([
            'Authorization' => 'Basic ' . $authcode,
        ])->post($tokenurl, [
            'grant_type' => 'client_credentials',
        ]);

        if ($response->successful()) {

            $result = $response->json();
            $accessToken = $result['access_token'];

            if (env('PAYHERE_MODE') == 'sandbox') {
                $orderurl = 'https://sandbox.payhere.lk/merchant/v1/payment/search?order_id=';
            } else {
                $orderurl = 'https://www.payhere.lk/merchant/v1/payment/search?order_id=';
            }

            $paymentStatus = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($orderurl . $request->order_id);

            $status = $paymentStatus->json();

            if ($status['data'] == null) {

                notify()->error("Payment Failed ! Try Again");
                $failedTranscations = new FailedTranscations();
                $failedTranscations->txn_id = 'PAYHERE_FAILED_' . str_random(5);
                $failedTranscations->user_id = Auth::user()->id;
                $failedTranscations->save();
                return redirect(route('order.review'));

            } else {

                $txnid = $status['data'][0]['payment_id'];
                $order_id = $request->order_id;
                $payment_status = 'yes';

                $checkout = new PlaceOrderController;

                return $checkout->placeorder($txnid, 'Payhere', $order_id, $payment_status);
            }

        } else {
            $failedTranscations = new FailedTranscations();
            $failedTranscations->txn_id = 'PAYHERE_FAILED_' . str_random(5);
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            notify()->error($response['msg']);
            return redirect(route('order.review'));
        }

    }
}
