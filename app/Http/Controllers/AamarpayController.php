<?php

namespace App\Http\Controllers;

use App\FailedTranscations;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AamarpayController extends Controller
{
    public function success(Request $request)
    {

        require_once 'price.php';

        try
        {

            $txn_id = $request->pg_txnid;

            $payment_method = $request->card_type;

            $payment_status = 'yes';

            $checkout = new PlaceOrderController;

            return $checkout->placeorder($txn_id, $payment_method, session()->get('order_id'), $payment_status);

        } catch (\Exception $e) {

            notify()->error($e->getMessage());
            $failedTranscations = new FailedTranscations();
            $failedTranscations->txn_id = 'AAMARPAY_FAILED_' . Str::uuid();
            $failedTranscations->user_id = auth()->id();
            $failedTranscations->save();
            return redirect(route('order.review'));
        }

    }
}
