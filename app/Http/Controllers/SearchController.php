<?php
namespace App\Http\Controllers;

use App\Commission;
use App\CommissionSetting;
use App\Genral;
use App\Product;
use Illuminate\Http\Request;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class SearchController extends Controller
{
    public function ajaxSearch(Request $request)
    {

        require_once 'price.php';

        $search = $request->search;
        $result = array();
        $variant = array();
        $ar = array();
        $imageurl = url('variantimages/thumbnails/');
        $infourl = url('images');

        if ($request->catid == 'all') {
            $query = Product::where('tags', 'LIKE', '%' . $search . '%')
                ->orWhere('name', 'LIKE', '%' . $search . '%')
                ->where('status','=','1')
                ->get();
        } else {
            $query = Product::where('tags', 'LIKE', '%' . $search . '%')
                ->where('category_id', '=', $request->catid)
                ->where('name', 'LIKE', '%' . $search . '%')
                ->where('status','=','1')
                ->with('subvariants')
                ->get();
        }

        if (count($query) < 1) {

            $result[] = ['id' => 1, 'value' => 'No Result found', 'img' => $infourl . '/info.png', 'url' => '#'];
        } else {

            $price_array = array();
            $price_login = Genral::findOrFail(1)->login;

            foreach ($query->unique('child') as $searchresult) {

                foreach ($searchresult->subcategory->products as $old) {

                    foreach ($old->subvariants as $orivar) {

                        if ($price_login == 0 || Auth::check()) {

                            $convert_price = 0;
                            $show_price = 0;

                            $commision_setting = CommissionSetting::first();

                            if ($commision_setting->type == "flat") {

                                $commission_amount = $commision_setting->rate;
                                if ($commision_setting->p_type == 'f') {

                                    if ($old->tax_r != '') {
                                        $cit = $commission_amount * $old->tax_r / 100;
                                        $totalprice = $old->vender_price + $orivar->price + $commission_amount + $cit;
                                        $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount + $cit;
                                    } else {
                                        $totalprice = $old->vender_price + $orivar->price + $commission_amount;
                                        $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;
                                    }

                                    if ($old->vender_offer_price == 0) {
                                        $totalprice;
                                        array_push($price_array, $totalprice);
                                    } else {
                                        $totalsaleprice;
                                        $convert_price = $totalsaleprice == '' ? $totalprice : $totalsaleprice;
                                        $show_price = $totalprice;
                                        array_push($price_array, $totalsaleprice);

                                    }

                                } else {

                                    $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                    $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                    $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                    $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                    if ($old->vender_offer_price == 0) {
                                        $bprice = round($buyerprice, 2);

                                        array_push($price_array, $bprice);
                                    } else {
                                        $bsprice = round($buyersaleprice, 2);
                                        $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                        $show_price = $buyerprice;
                                        array_push($price_array, $bsprice);

                                    }

                                }
                            } else {

                                $comm = Commission::where('category_id', $old->category_id)->first();
                                if (isset($comm)) {
                                    if ($comm->type == 'f') {

                                        if ($old->tax_r != '') {
                                            $cit = $comm->rate * $old->tax_r / 100;
                                            $price = $old->vender_price + $comm->rate + $orivar->price + $cit;
                                            $offer = $old->vender_offer_price + $comm->rate + $orivar->price + $cit;
                                        } else {
                                            $price = $old->vender_price + $comm->rate + $orivar->price;
                                            $offer = $old->vender_offer_price + $comm->rate + $orivar->price;
                                        }

                                        $convert_price = $offer == '' ? $price : $offer;
                                        $show_price = $price;

                                        if ($old->vender_offer_price == 0) {

                                            array_push($price_array, $price);
                                        } else {
                                            array_push($price_array, $offer);
                                        }

                                    } else {

                                        $commission_amount = $comm->rate;

                                        $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                        $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                        $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                        $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                        if ($old->vender_offer_price == 0) {
                                            $bprice = round($buyerprice, 2);
                                            array_push($price_array, $bprice);
                                        } else {
                                            $bsprice = round($buyersaleprice, 2);
                                            $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                            $show_price = round($buyerprice, 2);
                                            array_push($price_array, $bsprice);
                                        }

                                    }
                                } else {
                                    $commission_amount = 0;

                                    $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                    $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                    $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                    $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                    if ($old->vender_offer_price == 0) {
                                        $bprice = round($buyerprice, 2);
                                        array_push($price_array, $bprice);
                                    } else {
                                        $bsprice = round($buyersaleprice, 2);
                                        $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                        $show_price = round($buyerprice, 2);
                                        array_push($price_array, $bsprice);
                                    }
                                }
                            }

                        }

                    }

                }

                if ($price_array != null) {
                    $firstsub = min($price_array);
                    $startp = round($firstsub);
                    if ($startp >= $firstsub) {
                        $startp = $startp - 1;
                    } else {
                        $startp = $startp;
                    }

                    $lastsub = max($price_array);
                    $endp = round($lastsub);

                    if ($endp <= $lastsub) {
                        $endp = $endp + 1;
                    } else {
                        $endp = $endp;
                    }

                } else {
                    $startp = 0.00;
                    $endp = 0.00;
                }

                if (isset($firstsub)) {
                    if ($firstsub == $lastsub) {
                        $startp = 0.00;
                    }
                }

                unset($price_array);

                $price_array = array();

                $url = url('shop?category=' . $searchresult
                        ->category->id . '&sid=' . $searchresult
                        ->subcategory->id . '&start=' . $startp * $conversion_rate . '&end=' . $endp * $conversion_rate . '&keyword=' . $request->search);

                $result[] = ['id' => $searchresult->id, 'value' => $request->search . ' in ' . $searchresult
                            ->subcategory->title, 'img' => $imageurl . '/' . $searchresult->subvariants[0]
                            ->variantimages['main_image'], 'url' => $url];
                }

            }

            return response()->json($result);
    }
}
