<?php

namespace App\Http\Controllers;

use App\Cart;
use Auth;
use Illuminate\Http\Request;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class VerifyPaymentController extends Controller
{
    public function paymentReVerify(Request $request)
    {

        require_once 'price.php';

        if ($request->ajax()) {
            $ordertotal = round($request->carttotal, 2);

            $cart_table = Auth::user()->cart;
            $total = 0;

            foreach ($cart_table as $key => $val) {

                if ($val->product->tax_r != null && $val->product->tax == 0) {

                    if ($val->ori_offer_price != 0) {
                        //get per product tax amount
                        $p = 100;
                        $taxrate_db = $val->product->tax_r;
                        $vp = $p + $taxrate_db;
                        $taxAmnt = $val->product->offer_price / $vp * $taxrate_db;
                        $taxAmnt = sprintf("%.2f", $taxAmnt);
                        $price = ($val->ori_offer_price - $taxAmnt) * $val->qty;

                    } else {

                        $p = 100;
                        $taxrate_db = $val->product->tax_r;
                        $vp = $p + $taxrate_db;
                        $taxAmnt = $val->product->price / $vp * $taxrate_db;

                        $taxAmnt = sprintf("%.2f", $taxAmnt);

                        $price = ($val->ori_price - $taxAmnt) * $val->qty;
                    }

                } else {

                    if ($val->semi_total != 0) {

                        $price = $val->semi_total;

                    } else {

                        $price = $val->price_total;

                    }
                }

                $total = $total + $price;

            }

            $total = round($total * $conversion_rate, 2);

            if ($ordertotal == $total) {
                return response()->json([200, 'Total matched']);
            } else {
                \Session::put('re-verify', 'yes');
                return response()->json([401, 'Total not matched']);
            }
        }
    }

}
