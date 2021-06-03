<?php

use App\ShippingWeight;

class GuestCartShipping
{
    public static function shipping($variant,$cart)
    {
        $shipping = 0;

        $free_shipping = App\Shipping::where('id',$variant->products->shipping_id)->first();

        if (!empty($free_shipping)) {
           
            if ($free_shipping->name == "Shipping Price") {
               
                $weight = ShippingWeight::first();
                $pro_weight = $variant->weight;

                

                if ($weight->weight_to_0 >= $pro_weight) {
                    
                    if ($weight->per_oq_0 == 'po') {
                        $shipping = $shipping + $weight->weight_price_0;
                    } else {
                        $shipping = $shipping + $weight->weight_price_0 * $cart['qty'];
                    }
                } elseif ($weight->weight_to_1 >= $pro_weight) {
                    
                    if ($weight->per_oq_1 == 'po') {
                        $shipping = $shipping + $weight->weight_price_1;
                    } else {
                        $shipping = $shipping + $weight->weight_price_1 * $cart['qty'];
                    }
                } elseif ($weight->weight_to_2 >= $pro_weight) {
                    if ($weight->per_oq_2 == 'po') {
                        $shipping = $shipping + $weight->weight_price_2;
                    } else {
                        $shipping = $shipping + $weight->weight_price_2 * $cart['qty'];
                    }
                } elseif ($weight->weight_to_3 >= $pro_weight) {
                    if ($weight->per_oq_3 == 'po') {
                        $shipping = $shipping + $weight->weight_price_3;
                    } else {
                        $shipping = $shipping + $weight->weight_price_3 * $cart['qty'];
                    }
                } else {
                    if ($weight->per_oq_4 == 'po') {
                        $shipping = $shipping + $weight->weight_price_4;
                    } else {
                        $shipping = $shipping + $weight->weight_price_4 * $cart['qty'];
                    }

                }


            } else {

                $shipping = $shipping + $free_shipping->price;

            }
        }

        return $shipping;

    }
}
