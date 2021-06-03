<?php

namespace App\Jobs;

use App\Cart;
use App\Shipping;
use Auth;
use DB;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ShippingUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \DB::reconnect('mysql');

        if (count(Auth::user()->cart) > 0) {
            foreach (Auth::user()->cart as $row) {

                /*reset data*/

                $free_shipping = Shipping::where('id', $row->product->shipping_id)->first();

                if (!empty($free_shipping)) {
                    if ($free_shipping->name == "Shipping Price") {
                        $weight = Shipping::first();
                        $pro_weight = $row->variant->weight;
                        if ($weight->weight_to_0 >= $pro_weight) {
                            if ($weight->per_oq_0 == 'po') {
                                $per_shipping = $weight->weight_price_0;

                                Cart::where('id', $row->id)
                                    ->update(array('shipping' => $per_shipping, 'ship_type' => null));
                            } else {
                                $per_shipping = $weight->weight_price_0 * $row->qty;

                                Cart::where('id', $row->id)
                                    ->update(array('shipping' => $per_shipping, 'ship_type' => null));
                            }
                        } elseif ($weight->weight_to_1 >= $pro_weight) {

                            if ($weight->per_oq_1 == 'po') {
                                $per_shipping = $weight->weight_price_1;

                                Cart::where('id', $row->id)
                                    ->update(array('shipping' => $per_shipping, 'ship_type' => null));
                            } else {
                                $per_shipping = $weight->weight_price_1 * $row->qty;

                                Cart::where('id', $row->id)
                                    ->update(array('shipping' => $per_shipping, 'ship_type' => null));
                            }
                        } elseif ($weight->weight_to_2 >= $pro_weight) {
                            if ($weight->per_oq_2 == 'po') {
                                $per_shipping = $weight->weight_price_2;

                                Cart::where('id', $row->id)
                                    ->update(array('shipping' => $per_shipping, 'ship_type' => null));
                            } else {

                                $per_shipping = $weight->weight_price_2 * $row->qty;
                                Cart::where('id', $row->id)
                                    ->update(array('shipping' => $per_shipping, 'ship_type' => null));
                            }
                        } elseif ($weight->weight_to_3 >= $pro_weight) {
                            if ($weight->per_oq_3 == 'po') {
                                $per_shipping = $weight->weight_price_3;

                                Cart::where('id', $row->id)
                                    ->update(array('shipping' => $per_shipping, 'ship_type' => null));
                            } else {
                                $per_shipping = $weight->weight_price_3 * $row->qty;

                                Cart::where('id', $row->id)
                                    ->update(array('shipping' => $per_shipping, 'ship_type' => null));
                            }
                        } else {
                            if ($weight->per_oq_4 == 'po') {
                                $per_shipping = $weight->weight_price_4;

                                Cart::where('id', $row->id)
                                    ->update(array('shipping' => $per_shipping, 'ship_type' => null));
                            } else {

                                $per_shipping = $weight->weight_price_4 * $row->qty;

                                Cart::where('id', $row->id)
                                    ->update(array('shipping' => $per_shipping, 'ship_type' => null));

                            }

                        }
                        //echo

                    } else {
                        $per_shipping = $free_shipping->price;

                        Cart::where('id', $row->id)
                            ->update(array('shipping' => $per_shipping, 'ship_type' => null));

                    }
                } else {
                    Cart::where('id', $row->id)
                        ->update(array('shipping' => 0, 'ship_type' => null));

                }

                if (isset($total)) {
                    if ($genrals_settings->cart_amount != 0 || $genrals_settings->cart_amount != '') {

                        if ($total * $conversion_rate >= $genrals_settings->cart_amount * $conversion_rate) {

                            DB::table('carts')->where('user_id', '=', Auth::user()->id)->update(array('shipping' => 0));

                        }

                    }
                }

            }
        }

        DB::disconnect('mysql');
    }
}
