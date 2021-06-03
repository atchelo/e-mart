<?php
namespace App\Http\Controllers;

use App\Cod;
use Auth;
use Illuminate\Http\Request;

class CodController extends Controller
{

    //For payment using cod

    public function payviacod(Request $request)
    {

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

        $total = sprintf("%.2f", $total * $conversion_rate);

        if (round($request->actualtotal, 2) != $total) {

            notify()->error('Payment has been modifed !', 'Please try again !');
            return redirect(route('order.review'));

        }

        $txn_id = $inv_cus->cod_prefix . str_random(10) . $inv_cus->cod_postfix;

        $payment_status = 'no';

        $checkout = new PlaceOrderController;

        return $checkout->placeorder($txn_id, 'COD', session()->get('order_id'), $payment_status);

    }
    #end

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cod  $cod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $cat = Cod::where('order_id', $id)->first();
        if (empty($cat)) {
            $data = Cod::create($input);

            $data->save();
            return redirect('admindesk/cod')
                ->with("updated", "Cod Setting Has Been Updated");
        } else {
            $cat->update($input);
            return redirect('admindesk/cod')->with("updated", "Cod Setting Has Been Updated");
        }
    }

    public function editupdateOn(Request $request, $id)
    {
        $input = $request->all();
        $cat = Cod::where('order_id', $id)->first();
        if (empty($cat)) {
            $data = Cod::create($input);

            $data->save();
            return redirect('vender/cod')
                ->with("updated", "Cod Setting Has Been Updated");
        } else {
            $cat->update($input);
            return redirect('vender/cod')->with("updated", "Cod Setting Has Been Updated");
        }
    }
}
