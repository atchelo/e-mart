<?php

use App\Commission;
use App\CommissionSetting;

class ProductPrice
{
    public static function getprice($pro,$orivar){

        require base_path().'/app/Http/Controllers/price.php';

        $convert_price = 0.00;
        $show_price = 0.00;
        $customer_price = 0;

        $commision_setting = CommissionSetting::first();

        if ($commision_setting->type == "flat") {

            $commission_amount = $commision_setting->rate;

            if ($commision_setting->p_type == 'f') {

                if ($pro->tax_r != '') {

                    $cit = $commission_amount * $pro->tax_r / 100;
                    $totalprice = $pro->vender_price + $orivar->price + $commission_amount + $cit;
                    $totalsaleprice = $pro->vender_offer_price + $cit + $orivar->price +
                        $commission_amount;

                    if ($pro->vender_offer_price == null) {
                        $show_price = $totalprice;
                        $customer_price = $totalprice;
                    } else {
                        $customer_price = $totalsaleprice;
                        $convert_price = $totalsaleprice == '' ? $totalprice : $totalsaleprice;
                        $show_price = $totalprice;
                    }

                } else {
                    $totalprice = $pro->vender_price + $orivar->price + $commission_amount;
                    $totalsaleprice = $pro->vender_offer_price + $orivar->price + $commission_amount;

                    if ($pro->vender_offer_price == null) {
                        $show_price = $totalprice;
                        $customer_price = $totalprice;
                    } else {
                        $customer_price = $totalsaleprice;
                        $convert_price = $totalsaleprice == '' ? $totalprice : $totalsaleprice;
                        $show_price = $totalprice;
                    }

                }

            } else {

                $totalprice = ($pro->vender_price + $orivar->price) * $commission_amount;

                $totalsaleprice = ($pro->vender_offer_price + $orivar->price) * $commission_amount;

                $buyerprice = ($pro->vender_price + $orivar->price) + ($totalprice / 100);

                $buyersaleprice = ($pro->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                if ($pro->vender_offer_price == null) {
                    $show_price = round($buyerprice, 2);
                    $customer_price = $show_price;
                } else {
                    $customer_price = round($buyersaleprice, 2);

                    $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                    $show_price = $buyerprice;
                }

            }
        } else {

            $comm = Commission::where('category_id', $pro->category_id)->first();
            if (isset($comm)) {
                if ($comm->type == 'f') {

                    if ($pro->tax_r != '') {

                        $cit = $comm->rate * $pro['tax_r'] / 100;

                        $price = $pro->vender_price + $comm->rate + $orivar->price + $cit;

                        if ($pro->vender_offer_price != null) {
                            $offer = $pro->vender_offer_price + $comm->rate + $orivar->price + $cit;
                        } else {
                            $offer = $pro->vender_offer_price;
                        }

                        if ($pro->vender_offer_price == null) {
                            $show_price = $price;
                            $customer_price = $show_price;
                        } else {

                            $convert_price = $offer;
                            $show_price = $price;
                            $customer_price = $convert_price;
                        }

                    } else {

                        $price = $pro->vender_price + $comm->rate + $orivar->price;

                        if ($pro->vender_offer_price != null) {
                            $offer = $pro->vender_offer_price + $comm->rate + $orivar->price;
                        } else {
                            $offer = $pro->vender_offer_price;
                        }

                        if ($pro->vender_offer_price == 0 || $pro->vender_offer_price == null) {
                            $show_price = $price;
                            $customer_price = $show_price;
                        } else {

                            $convert_price = $offer;
                            $show_price = $price;
                            $customer_price = $convert_price;
                        }

                    }

                } else {

                    $commission_amount = $comm->rate;

                    $totalprice = ($pro->vender_price + $orivar->price) * $commission_amount;

                    $totalsaleprice = ($pro->vender_offer_price + $orivar->price) * $commission_amount;

                    $buyerprice = ($pro->vender_price + $orivar->price) + ($totalprice / 100);

                    $buyersaleprice = ($pro->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                    if ($pro->vender_offer_price == null) {
                        $show_price = round($buyerprice, 2);
                        $customer_price = $show_price;
                    } else {
                        $convert_price = round($buyersaleprice, 2);
                        $customer_price = $convert_price;
                        $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                        $show_price = round($buyerprice, 2);
                    }

                }
            } else {
                $commission_amount = 0;

                $totalprice = ($pro->vender_price + $orivar->price) * $commission_amount;

                $totalsaleprice = ($pro->vender_offer_price + $orivar->price) * $commission_amount;

                $buyerprice = ($pro->vender_price + $orivar->price) + ($totalprice / 100);

                $buyersaleprice = ($pro->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                if ($pro->vender_offer_price == null) {
                    $show_price = round($buyerprice, 2);
                    $customer_price = $show_price;
                } else {
                    $convert_price = round($buyersaleprice, 2);
                    $customer_price = $convert_price;
                    $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                    $show_price = round($buyerprice, 2);
                }
            }
        }

        $convert_price = sprintf("%.2f", $convert_price); //Offer Price
        $show_price = sprintf('%.2f', $show_price); // Main Price

        if ($convert_price == 0) {
            $convert_price = 0;
        }

        return response()->json(['mainprice' => $show_price, 'offerprice' => $convert_price,'customer_price' => $customer_price]);
    }
}