@extends('front.layout.master')
@section('title','Filter Products | ')
@section('body')
<br>
@php
  $last_cat = 0;
  $first_cat = 0;
  $price_login = App\Genral::first()->login;
  $price_array = array();
  $convert_price = 0;
  $show_price = 0;

$all_brands_products = array();
if ($tag != '')
{

    try
    {
        if ($chid != '')
        {
            if ($brand_names != '')
            {
                $get_all_products = App\Product::query();
                if (is_array($brand_names))
                {
                    foreach ($brand_names as $brands_all)
                    {
                        $all_products_brands = $get_all_products->where('brand_id', $brands_all)->where('tags', $tag)->where('grand_id', $chid)->get();
                        foreach ($all_products_brands as $zx)
                        {
                            array_push($all_brands_products, $zx);
                        }
                    }
                   
                    
                }
                if ($all_brands_products == null)
                {
                    $first_cat = 0;
                    $last_cat = 0;
                }
                else
                {
                    $productsfor_price = $all_brands_products;
                }
            }
            else
            {
                $productsfor_price = App\Product::where('tags', $tag)->where('grand_id', $chid)->get();
            }
            foreach ($productsfor_price as $old)
            {

                foreach ($old->subvariants as $orivar)
                {
                    if ($price_login == 0 || Auth::user())
                    {

                        $commision_setting = App\CommissionSetting::first();

                        if ($commision_setting->type == "flat")
                        {

                            $commission_amount = $commision_setting->rate;
                            if ($commision_setting->p_type == 'f')
                            {

                                if ($old->tax_r != '')
                                {
                                    $cit = $commission_amount * $old->tax_r / 100;
                                    $totalprice = $old->vender_price + $orivar->price + $commission_amount + $cit;
                                    $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount + $cit;
                                }
                                else
                                {
                                    $totalprice = $old->vender_price + $orivar->price + $commission_amount;
                                    $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;
                                }

                                if ($old->vender_offer_price == 0)
                                {
                                    $totalprice;
                                    array_push($price_array, $totalprice);
                                }
                                else
                                {
                                    $totalsaleprice;
                                    $convert_price = $totalsaleprice == '' ? $totalprice : $totalsaleprice;
                                    $show_price = $totalprice;
                                    array_push($price_array, $totalsaleprice);

                                }

                            }
                            else
                            {

                                $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                if ($old->vender_offer_price == 0)
                                {
                                    $bprice = round($buyerprice, 2);

                                    array_push($price_array, $bprice);
                                }
                                else
                                {
                                    $bsprice = round($buyersaleprice, 2);

                                    $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                    $show_price = $buyerprice;
                                    array_push($price_array, $bsprice);

                                }

                            }
                        }
                        else
                        {

                            $comm = App\Commission::where('category_id', $old->category_id)
                                ->first();

                            if (isset($comm))
                            {
                                if ($comm->type == 'f')
                                {

                                    if ($old->tax_r != '')
                                    {
                                        $cit = $comm->rate * $old->tax_r / 100;
                                        $price = $old->vender_price + $comm->rate + $orivar->price + $cit;
                                        $offer = $old->vender_offer_price + $comm->rate + $orivar->price + $cit;
                                    }
                                    else
                                    {
                                        $price = $old->vender_price + $comm->rate + $orivar->price;
                                        $offer = $old->vender_offer_price + $comm->rate + $orivar->price;
                                    }

                                    $convert_price = $offer == '' ? $price : $offer;
                                    $show_price = $price;

                                    if ($old->vender_offer_price == 0)
                                    {
                                        array_push($price_array, $price);
                                    }
                                    else
                                    {
                                        array_push($price_array, $offer);
                                    }
                                }
                                else
                                {

                                    $commission_amount = $comm->rate;

                                    $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                    $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                    $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                    $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                    if ($old->vender_offer_price == 0)
                                    {
                                        $bprice = round($buyerprice, 2);
                                        array_push($price_array, $bprice);
                                    }
                                    else
                                    {
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
            }
            if ($price_array != null)
            {
                $first_cat = min($price_array);
                $last_cat = max($price_array);
            }
            unset($price_array);
            $price_array = array();
        }
        else
        {
            if ($sid != '')
            {
                if ($brand_names != '')
                {
                    $get_all_products = App\Product::query();
                    if (is_array($brand_names))
                    {
                        foreach ($brand_names as $brands_all)
                        {
                            $all_products_brands = $get_all_products->where('brand_id', $brands_all)->where('tags', $tag)->where('child', $sid)->get();
                            foreach ($all_products_brands as $zx)
                            {
                                array_push($all_brands_products, $zx);
                            }
                        }
                        
                    }
                    if ($all_brands_products == null)
                    {
                        $first_cat = 0;
                        $last_cat = 0;
                    }
                    else
                    {
                        $productsfor_price = $all_brands_products;
                    }
                }
                else
                {
                    $productsfor_price = App\Product::where('tags', $tag)->where('child', $sid)->get();
                }
                foreach ($productsfor_price as $old)
                {

                    foreach ($old->subvariants as $orivar)
                    {
                        if ($price_login == 0 || Auth::user())
                        {

                            $convert_price = 0;
                            $show_price = 0;

                            $commision_setting = App\CommissionSetting::first();

                            if ($commision_setting->type == "flat")
                            {

                                $commission_amount = $commision_setting->rate;
                                if ($commision_setting->p_type == 'f')
                                {

                                    if ($old->tax_r != '')
                                    {
                                        $cit = $commission_amount * $old->tax_r / 100;
                                        $totalprice = $old->vender_price + $orivar->price + $commission_amount + $cit;
                                        $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount + $cit;
                                    }
                                    else
                                    {
                                        $totalprice = $old->vender_price + $orivar->price + $commission_amount;
                                        $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;
                                    }

                                    if ($old->vender_offer_price == 0)
                                    {
                                        $totalprice;
                                        array_push($price_array, $totalprice);
                                    }
                                    else
                                    {
                                        $totalsaleprice;

                                        $convert_price = $totalsaleprice == '' ? $totalprice : $totalsaleprice;
                                        $show_price = $totalprice;
                                        array_push($price_array, $totalsaleprice);

                                    }

                                }
                                else
                                {

                                    $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                    $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                    $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                    $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                    if ($old->vender_offer_price == 0)
                                    {
                                        $bprice = round($buyerprice, 2);
                                        array_push($price_array, $bprice);
                                    }
                                    else
                                    {
                                        $bsprice = round($buyersaleprice, 2);
                                        $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                        $show_price = $buyerprice;
                                        array_push($price_array, $bsprice);

                                    }

                                }
                            }
                            else
                            {

                                $comm = App\Commission::where('category_id', $old->category_id)
                                    ->first();
                                if (isset($comm))
                                {
                                    if ($comm->type == 'f')
                                    {

                                        if ($old->tax_r != '')
                                        {
                                            $cit = $comm->rate * $old->tax_r / 100;
                                            $price = $old->vender_price + $comm->rate + $orivar->price + $cit;
                                            $offer = $old->vender_offer_price + $comm->rate + $orivar->price + $cit;
                                        }
                                        else
                                        {
                                            $price = $old->vender_price + $comm->rate + $orivar->price;
                                            $offer = $old->vender_offer_price + $comm->rate + $orivar->price;
                                        }

                                        $convert_price = $offer == '' ? $price : $offer;
                                        $show_price = $price;

                                        if ($old->vender_offer_price == 0)
                                        {

                                            array_push($price_array, $price);
                                        }
                                        else
                                        {
                                            array_push($price_array, $offer);
                                        }
                                    }
                                    else
                                    {

                                        $commission_amount = $comm->rate;

                                        $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                        $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                        $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                        $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                        if ($old->vender_offer_price == 0)
                                        {
                                            $bprice = round($buyerprice, 2);
                                            array_push($price_array, $bprice);
                                        }
                                        else
                                        {
                                            $bsprice = round($buyersaleprice, 2);

                                            $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                            $show_price = round($buyerprice, 2);
                                            array_push($price_array, $bsprice);
                                        }
                                    }
                                }else{
                                        $commission_amount = 0;

                                        $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                        $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                        $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                        $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                        if ($old->vender_offer_price == 0)
                                        {
                                            $bprice = round($buyerprice, 2);
                                            array_push($price_array, $bprice);
                                        }
                                        else
                                        {
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
                if ($price_array != null)
                {
                    $first_cat = min($price_array);
                    $last_cat = max($price_array);
                }
                unset($price_array);
                $price_array = array();
            }
            else
            {
                if ($brand_names != '')
                {
                    $get_all_products = App\Product::query();
                    if (is_array($brand_names))
                    {
                        foreach ($brand_names as $brands_all)
                        {
                            $all_products_brands = $get_all_products->where('brand_id', $brands_all)->where('tags', $tag)->where('category_id', $catid)->get();
                            foreach ($all_products_brands as $zx)
                            {
                                array_push($all_brands_products, $zx);
                            }
                        }

                    }
                    if ($all_brands_products == null)
                    {
                        $first_cat = 0;
                        $last_cat = 0;
                    }
                    else
                    {
                        $productsfor_price = $all_brands_products;
                    }
                }
                else
                {

                    $productsfor_price = App\Product::where('tags', $tag)->where('category_id', $catid)->get();
                }
                foreach ($productsfor_price as $old)
                {

                    foreach ($old->subvariants as $orivar)
                    {
                        if ($price_login == 0 || Auth::user())
                        {

                            $commision_setting = App\CommissionSetting::first();

                            if ($commision_setting->type == "flat")
                            {

                                $commission_amount = $commision_setting->rate;
                                if ($commision_setting->p_type == 'f')
                                {

                                    if ($old->tax_r != '')
                                    {
                                        $cit = $commission_amount * $old->tax_r / 100;
                                        $totalprice = $old->vender_price + $orivar->price + $commission_amount + $cit;
                                        $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount + $cit;
                                    }
                                    else
                                    {
                                        $totalprice = $old->vender_price + $orivar->price + $commission_amount;
                                        $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;
                                    }

                                    if ($old->vender_offer_price == 0)
                                    {
                                        $totalprice;
                                        array_push($price_array, $totalprice);
                                    }
                                    else
                                    {
                                        $totalsaleprice;
                                        $convert_price = $totalsaleprice == '' ? $totalprice : $totalsaleprice;
                                        $show_price = $totalprice;
                                        array_push($price_array, $totalsaleprice);

                                    }

                                }
                                else
                                {

                                    $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                    $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                    $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                    $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                    if ($old->vender_offer_price == 0)
                                    {
                                        $bprice = round($buyerprice, 2);

                                        array_push($price_array, $bprice);
                                    }
                                    else
                                    {
                                        $bsprice = round($buyersaleprice, 2);
                                        $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                        $show_price = $buyerprice;
                                        array_push($price_array, $bsprice);

                                    }

                                }
                            }
                            else
                            {

                                $comm = App\Commission::where('category_id', $old->category_id)
                                    ->first();
                                if (isset($comm))
                                {
                                    if ($comm->type == 'f')
                                    {

                                        if ($old->tax_r != '')
                                        {
                                            $cit = $comm->rate * $old->tax_r / 100;
                                            $price = $old->vender_price + $comm->rate + $orivar->price + $cit;
                                            $offer = $old->vender_offer_price + $comm->rate + $orivar->price + $cit;
                                        }
                                        else
                                        {
                                            $price = $old->vender_price + $comm->rate + $orivar->price;
                                            $offer = $old->vender_offer_price + $comm->rate + $orivar->price;
                                        }

                                        $convert_price = $offer == '' ? $price : $offer;
                                        $show_price = $price;

                                        if ($old->vender_offer_price == 0)
                                        {

                                            array_push($price_array, $price);
                                        }
                                        else
                                        {
                                            array_push($price_array, $offer);
                                        }
                                    }
                                    else
                                    {

                                        $commission_amount = $comm->rate;

                                        $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                        $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                        $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                        $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                        if ($old->vender_offer_price == 0)
                                        {
                                            $bprice = round($buyerprice, 2);
                                            array_push($price_array, $bprice);
                                        }
                                        else
                                        {
                                            $bsprice = round($buyersaleprice, 2);
                                            $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                            $show_price = round($buyerprice, 2);
                                            array_push($price_array, $bsprice);
                                        }
                                    }
                                }else{
                                        $commission_amount = 0;

                                        $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                        $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                        $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                        $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                        if ($old->vender_offer_price == 0)
                                        {
                                            $bprice = round($buyerprice, 2);
                                            array_push($price_array, $bprice);
                                        }
                                        else
                                        {
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
                if ($price_array != null)
                {
                    $first_cat = min($price_array);
                    $last_cat = max($price_array);
                }
                unset($price_array);
                $price_array = array();
            }
        }

    }
    catch(Exception $e)
    {
        $last_cat = 0;
        $first_cat = 0;
    }

}

else
{

    try
    {
        if ($chid != '')
        {
            if ($brand_names != '')
            {
                $get_all_products = App\Product::query();
                if (is_array($brand_names))
                {
                    foreach ($brand_names as $brands_all)
                    {
                        $all_products_brands = $get_all_products->where('brand_id', $brands_all)->where('grand_id', $chid)->get();
                        foreach ($all_products_brands as $zx)
                        {
                            array_push($all_brands_products, $zx);
                        }
                    }

                }
                if ($all_brands_products == null)
                {
                    $first_cat = 0;
                    $last_cat = 0;
                }
                else
                {
                    $productsfor_price = $all_brands_products;
                }
            }
            else
            {
                $productsfor_price = App\Product::where('grand_id', $chid)->get();
            }
            foreach ($productsfor_price as $old)
            {

                foreach ($old->subvariants as $orivar)
                {
                    if ($price_login == 0 || Auth::user())
                    {

                        $commision_setting = App\CommissionSetting::first();

                        if ($commision_setting->type == "flat")
                        {

                            $commission_amount = $commision_setting->rate;
                            if ($commision_setting->p_type == 'f')
                            {

                                if ($old->tax_r != '')
                                {
                                    $cit = $commission_amount * $old->tax_r / 100;
                                    $totalprice = $old->vender_price + $orivar->price + $commission_amount + $cit;
                                    $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount + $cit;
                                }
                                else
                                {
                                    $totalprice = $old->vender_price + $orivar->price + $commission_amount;
                                    $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;
                                }

                                if ($old->vender_offer_price == 0)
                                {
                                    $totalprice;
                                    array_push($price_array, $totalprice);
                                }
                                else
                                {
                                    $totalsaleprice;
                                    $convert_price = $totalsaleprice == '' ? $totalprice : $totalsaleprice;
                                    $show_price = $totalprice;
                                    array_push($price_array, $totalsaleprice);

                                }

                            }
                            else
                            {

                                $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                if ($old->vender_offer_price == 0)
                                {
                                    $bprice = round($buyerprice, 2);

                                    array_push($price_array, $bprice);
                                }
                                else
                                {
                                    $bsprice = round($buyersaleprice, 2);
                                    $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                    $show_price = $buyerprice;
                                    array_push($price_array, $bsprice);

                                }

                            }
                        }
                        else
                        {

                            $comm = App\Commission::where('category_id', $old->category_id)
                                ->first();
                            if (isset($comm))
                            {
                                if ($comm->type == 'f')
                                {

                                    if ($old->tax_r != '')
                                    {
                                        $cit = $comm->rate * $old->tax_r / 100;
                                        $price = $old->vender_price + $comm->rate + $orivar->price + $cit;
                                        $offer = $old->vender_offer_price + $comm->rate + $orivar->price + $cit;
                                    }
                                    else
                                    {
                                        $price = $old->vender_price + $comm->rate + $orivar->price;
                                        $offer = $old->vender_offer_price + $comm->rate + $orivar->price;
                                    }

                                    $convert_price = $offer == '' ? $price : $offer;
                                    $show_price = $price;

                                    if ($old->vender_offer_price == 0)
                                    {

                                        array_push($price_array, $price);
                                    }
                                    else
                                    {
                                        array_push($price_array, $offer);
                                    }
                                }
                                else
                                {

                                    $commission_amount = $comm->rate;

                                    $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                    $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                    $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                    $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                    if ($old->vender_offer_price == 0)
                                    {
                                        $bprice = round($buyerprice, 2);
                                        array_push($price_array, $bprice);
                                    }
                                    else
                                    {
                                        $bsprice = round($buyersaleprice, 2);
                                        $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                        $show_price = round($buyerprice, 2);
                                        array_push($price_array, $bsprice);
                                    }
                                }
                            }else{
                                    $commission_amount = 0;

                                    $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                    $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                    $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                    $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                    if ($old->vender_offer_price == 0)
                                    {
                                        $bprice = round($buyerprice, 2);
                                        array_push($price_array, $bprice);
                                    }
                                    else
                                    {
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
            if ($price_array != null)
            {
                $first_cat = min($price_array);
                $last_cat = max($price_array);
            }
            unset($price_array);
            $price_array = array();
        }
        else
        {
            if ($sid != '')
            {
                if ($brand_names != '')
                {
                    $get_all_products = App\Product::query();
                    if (is_array($brand_names))
                    {
                        foreach ($brand_names as $brands_all)
                        {
                            $all_products_brands = $get_all_products->where('brand_id', $brands_all)->where('child', $sid)->get();
                            foreach ($all_products_brands as $zx)
                            {
                                array_push($all_brands_products, $zx);
                            }
                        }

                    }
                    if ($all_brands_products == null)
                    {
                        $first_cat = 0;
                        $last_cat = 0;
                    }
                    else
                    {
                        $productsfor_price = $all_brands_products;
                    }
                }
                else
                {
                    $productsfor_price = App\Product::where('child', $sid)->get();
                }
                foreach ($productsfor_price as $old)
                {

                    foreach ($old->subvariants as $orivar)
                    {
                        if ($price_login == 0 || Auth::user())
                        {

                            $commision_setting = App\CommissionSetting::first();

                            if ($commision_setting->type == "flat")
                            {

                                $commission_amount = $commision_setting->rate;
                                if ($commision_setting->p_type == 'f')
                                {

                                    if ($old->tax_r != '')
                                    {
                                        $cit = $commission_amount * $old->tax_r / 100;
                                        $totalprice = $old->vender_price + $orivar->price + $commission_amount + $cit;
                                        $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount + $cit;
                                    }
                                    else
                                    {
                                        $totalprice = $old->vender_price + $orivar->price + $commission_amount;
                                        $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;
                                    }

                                    if ($old->vender_offer_price == 0)
                                    {
                                        $totalprice;
                                        array_push($price_array, $totalprice);
                                    }
                                    else
                                    {
                                        $totalsaleprice;
                                        $convert_price = $totalsaleprice == '' ? $totalprice : $totalsaleprice;
                                        $show_price = $totalprice;
                                        array_push($price_array, $totalsaleprice);

                                    }

                                }
                                else
                                {

                                    $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                    $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                    $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                    $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                    if ($old->vender_offer_price == 0)
                                    {
                                        $bprice = round($buyerprice, 2);

                                        array_push($price_array, $bprice);
                                    }
                                    else
                                    {
                                        $bsprice = round($buyersaleprice, 2);
                                        $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                        $show_price = $buyerprice;
                                        array_push($price_array, $bsprice);

                                    }

                                }
                            }
                            else
                            {

                                $comm = App\Commission::where('category_id', $old->category_id)
                                    ->first();
                                if (isset($comm))
                                {
                                    if ($comm->type == 'f')
                                    {

                                        if ($old->tax_r != '')
                                        {
                                            $cit = $comm->rate * $old->tax_r / 100;
                                            $price = $old->vender_price + $comm->rate + $orivar->price + $cit;
                                            $offer = $old->vender_offer_price + $comm->rate + $orivar->price + $cit;
                                        }
                                        else
                                        {
                                            $price = $old->vender_price + $comm->rate + $orivar->price;
                                            $offer = $old->vender_offer_price + $comm->rate + $orivar->price;
                                        }

                                        $convert_price = $offer == '' ? $price : $offer;
                                        $show_price = $price;

                                        if ($old->vender_offer_price == 0)
                                        {

                                            array_push($price_array, $price);
                                        }
                                        else
                                        {
                                            array_push($price_array, $offer);
                                        }
                                    }
                                    else
                                    {

                                        $commission_amount = $comm->rate;

                                        $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                        $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                        $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                        $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                        if ($old->vender_offer_price == 0)
                                        {
                                            $bprice = round($buyerprice, 2);
                                            array_push($price_array, $bprice);
                                        }
                                        else
                                        {
                                            $bsprice = round($buyersaleprice, 2);
                                            $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                            $show_price = round($buyerprice, 2);
                                            array_push($price_array, $bsprice);
                                        }
                                    }
                                }else{
                                        $commission_amount = 0;

                                        $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                        $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                        $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                        $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                        if ($old->vender_offer_price == 0)
                                        {
                                            $bprice = round($buyerprice, 2);
                                            array_push($price_array, $bprice);
                                        }
                                        else
                                        {
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
                if ($price_array != null)
                {
                    $first_cat = min($price_array);
                    $last_cat = max($price_array);
                }
                unset($price_array);
                $price_array = array();
            }
            else
            {

                if ($brand_names != '')
                {
                    $get_all_products = App\Product::query();
                    if (is_array($brand_names))
                    {
                        foreach ($brand_names as $brands_all)
                        {
                            $all_products_brands = $get_all_products->where('brand_id', $brands_all)->where('category_id', $catid)->get();
                            foreach ($all_products_brands as $zx)
                            {
                                array_push($all_brands_products, $zx);
                            }
                        }

                    }

                    if ($all_brands_products == null)
                    {
                        $first_cat = 0;
                        $last_cat = 0;
                    }
                    else
                    {
                        $productsfor_price = $all_brands_products;
                    }
                }
                else
                {
                    $productsfor_price = App\Product::where('category_id', $catid)->get();
                }
                foreach ($productsfor_price as $old)
                {

                    foreach ($old->subvariants as $orivar)
                    {
                        if ($price_login == 0 || Auth::user())
                        {

                            $commision_setting = App\CommissionSetting::first();

                            if ($commision_setting->type == "flat")
                            {

                                $commission_amount = $commision_setting->rate;
                                if ($commision_setting->p_type == 'f')
                                {

                                    if ($old->tax_r != '')
                                    {
                                        $cit = $commission_amount * $old->tax_r / 100;
                                        $totalprice = $old->vender_price + $orivar->price + $commission_amount + $cit;
                                        $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount + $cit;
                                    }
                                    else
                                    {
                                        $totalprice = $old->vender_price + $orivar->price + $commission_amount;
                                        $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;
                                    }

                                    if ($old->vender_offer_price == 0)
                                    {
                                        $totalprice;
                                        array_push($price_array, $totalprice);
                                    }
                                    else
                                    {
                                        $totalsaleprice;
                                        $convert_price = $totalsaleprice == '' ? $totalprice : $totalsaleprice;
                                        $show_price = $totalprice;
                                        array_push($price_array, $totalsaleprice);

                                    }

                                }
                                else
                                {

                                    $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                    $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                    $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                    $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                    if ($old->vender_offer_price == 0)
                                    {
                                        $bprice = round($buyerprice, 2);

                                        array_push($price_array, $bprice);
                                    }
                                    else
                                    {
                                        $bsprice = round($buyersaleprice, 2);
                                        $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                        $show_price = $buyerprice;
                                        array_push($price_array, $bsprice);

                                    }

                                }
                            }
                            else
                            {

                                $comm = App\Commission::where('category_id', $old->category_id)
                                    ->first();
                                if (isset($comm))
                                {
                                    if ($comm->type == 'f')
                                    {

                                        if ($old->tax_r != '')
                                        {
                                            $cit = $comm->rate * $old->tax_r / 100;
                                            $price = $old->vender_price + $comm->rate + $orivar->price + $cit;
                                            $offer = $old->vender_offer_price + $comm->rate + $orivar->price + $cit;
                                        }
                                        else
                                        {
                                            $price = $old->vender_price + $comm->rate + $orivar->price;
                                            $offer = $old->vender_offer_price + $comm->rate + $orivar->price;
                                        }

                                        $convert_price = $offer == '' ? $price : $offer;
                                        $show_price = $price;

                                        if ($old->vender_offer_price == 0)
                                        {

                                            array_push($price_array, $price);
                                        }
                                        else
                                        {
                                            array_push($price_array, $offer);
                                        }
                                    }
                                    else
                                    {

                                        $commission_amount = $comm->rate;

                                        $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                        $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                        $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                        $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                        if ($old->vender_offer_price == 0)
                                        {
                                            $bprice = round($buyerprice, 2);
                                            array_push($price_array, $bprice);
                                        }
                                        else
                                        {
                                            $bsprice = round($buyersaleprice, 2);
                                            $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                                            $show_price = round($buyerprice, 2);
                                            array_push($price_array, $bsprice);
                                        }
                                    }
                                }else{
                                        $commission_amount = 0;

                                        $totalprice = ($old->vender_price + $orivar->price) * $commission_amount;

                                        $totalsaleprice = ($old->vender_offer_price + $orivar->price) * $commission_amount;

                                        $buyerprice = ($old->vender_price + $orivar->price) + ($totalprice / 100);

                                        $buyersaleprice = ($old->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                                        if ($old->vender_offer_price == 0)
                                        {
                                            $bprice = round($buyerprice, 2);
                                            array_push($price_array, $bprice);
                                        }
                                        else
                                        {
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
                if ($price_array != null)
                {
                    $first_cat = min($price_array);
                    $last_cat = max($price_array);
                }
                unset($price_array);
                $price_array = array();
            }
        }

    }
    catch(Exception $e)
    {
        $last_cat = 0;
        $first_cat = 0;
    }

}

@endphp
<div id="app">

</div>
<div class='container-fluid'>
    <div class='row categoryfilter-block'>
      <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-2 sidebar'>
     

        @php
          $isad = App\DetailAds::where('position','=','category')->where('linked_id',$catid)->where('status','=','1')->first();
        @endphp
        <div class="adbox">
            @if(isset($isad))
                
                
                    <div class="home-banner outer-top-n outer-bottom-xs">
                        @if($isad->adsensecode != '')
                          @php
                            echo html_entity_decode($isad->adsensecode);
                          @endphp
                        @else
                            @if($isad->show_btn == '1')
                               <h3 class="buy-heading" style="color:{{ $isad->hcolor }}">{{ $isad->top_heading }}</h3>
                               <h4 class="buy-sub-heading" style="color:{{ $isad->scolor }}">{{ $isad->sheading }}</h4>
                               <center><a href="
                               @if($isad->linkby == 'category')
                                 {{ App\Helpers\CategoryUrl::getURL($isad->cat_id) }}
                               @elseif($isad->linkby == 'detail' && $isad->pro_id != '' && $isad->product && $isad->product->subvariants)
                                {{ App\Helpers\CategoryUrl::getURL($isad->product->subvariants[0]['id']) }}
                               @elseif($isad->linkby == 'url')
                                {{ $isad->url }}
                               @endif" style="color:{{ $isad->btn_txt_color }};background: {{ $isad->btn_bg_color }}" class="btn buy-button">{{ $isad->btn_text }}</a></center>
                               <img src="{{ url('images/detailads/'.$isad->adimage) }}" alt="advertise" class="img-responsive img-fluid">
                            @elseif($isad->show_btn == 0 && $isad->top_heading != '')
                               <a href="
                              @if($isad->linkby == 'category')
                                {{ App\Helpers\CategoryUrl::getURL($isad->cat_id) }}
                              @elseif($isad->linkby == 'detail' && $isad->pro_id != '' && $isad->product->subvariants)
                                {{ App\Helpers\CategoryUrl::getURL($isad->product->subvariants[0]['id']) }}
                              @elseif($isad->linkby == 'url')
                                {{ $isad->url }}
                              @endif
                              ">
                                <h3 class="buy-heading" style="color:{{ $isad->hcolor }}">{{ $isad->top_heading }}</h3>
                                <h4 class="buy-sub-heading" style="color:{{ $isad->scolor }}">{{ $isad->sheading }}</h4>
                                <img src="{{ url('images/detailads/'.$isad->adimage) }}" alt="advertise" class="img-responsive img-fluid">
                              </a>
                            @else
                              <a href="
                              @if($isad->linkby == 'category')
                                {{ App\Helpers\CategoryUrl::getURL($isad->cat_id) }}
                              @elseif($isad->linkby == 'detail' && $isad->pro_id != '' && $isad->product && $isad->product->subvariants)
                                {{ App\Helpers\CategoryUrl::getURL($isad->product->subvariants[0]['id']) }}
                              @elseif($isad->linkby == 'url')
                                {{ $isad->url }}
                              @endif
                              ">
                                <img src="{{ url('images/detailads/'.$isad->adimage) }}" alt="advertise" class="img-responsive img-fluid">
                              </a>
                            @endif
                        @endif
                    </div>
                
            @endif
        </div>
        <!-- ================================== TOP NAVIGATION ================================== -->
        <div class="side-menu animate-dropdown outer-bottom-xs navigation-small-block">
          <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> {{ __('staticwords.Categories') }}</div>
          <nav class=" megamenu-horizontal">
           
           
            @php 
            $price_array = array();

            if($genrals_settings->vendor_enable == 1){
                  
                  $pirmarycategories = App\Category::
                      join('products', function ($join) {
                        $join->on('products.category_id', '=', 'categories.id')->where('products.status','1');
                      })
                      ->leftjoin('users', function ($join) {
                        $join->on('products.vender_id', '=', 'users.id')->where('users.status','1');
                      })
                      ->orderBy('position','ASC')->select('categories.*')->where('categories.status','=','1')->get();
                               
              }else{
                $pirmarycategories = App\Category::
                   join('products', function ($join) {
                      $join->on('products.category_id', '=', 'categories.id')->where('products.status','1');
                    })
                    ->leftjoin('users', function ($join) {
                      $join->on('products.vender_id', '=', 'users.id')->where('users.status','1')->where('users.role_id','=','a');
                    })
                  ->orderBy('position','ASC')->select('categories.*')->where('categories.status','=','1')->get();
              }
            @endphp
            
            <ul class="nav flex-column flex-nowrap overflow-hidden">
             @foreach($pirmarycategories->unique() as $item)
                
                    @foreach($item->products as $old)

                      
                        @foreach($old->subvariants as $orivar)
                                
                        @if($price_login == 0 || Auth::check())
                                    @php
                                              
                                              $convert_price = 0;
                                              $show_price = 0;
                                              
                                              $commision_setting = App\CommissionSetting::first();

                                              if($commision_setting->type == "flat"){

                                                $commission_amount = $commision_setting->rate;
                                                if($commision_setting->p_type == 'f'){

                                                  if($old->tax_r !=''){
                                                    $cit = $commission_amount*$old->tax_r/100;
                                                    $totalprice = $old->vender_price+$orivar->price+$commission_amount+$cit;
                                                    $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount+$cit;
                                                  }else{
                                                    $totalprice = $old->vender_price+$orivar->price+$commission_amount;
                                                    $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;
                                                  }
                                                
                                                

                                                  if($old->vender_offer_price == 0){
                                                      $totalprice;
                                                      array_push($price_array, $totalprice);
                                                    }else{
                                                      $totalsaleprice;
                                                      $convert_price = $totalsaleprice==''?$totalprice:$totalsaleprice;
                                                      $show_price = $totalprice;
                                                      array_push($price_array, $totalsaleprice);
                                                    
                                                    }

                                                  
                                                }else{

                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                
                                                    if($old->vender_offer_price ==0){
                                                      $bprice = round($buyerprice,2);
                                                    
                                                        array_push($price_array, $bprice);
                                                    }else{
                                                      $bsprice = round($buyersaleprice,2);
                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                      $show_price = $buyerprice;
                                                      array_push($price_array, $bsprice);
                                                    
                                                    }
                                                

                                                }
                                              }else{
                                                
                                              $comm = App\Commission::where('category_id',$old->category_id)->first();
                                              if(isset($comm)){
                                            if($comm->type=='f'){

                                              if($old->tax_r !=''){
                                                $cit =$comm->rate*$old->tax_r/100;
                                                $price =  $old->vender_price  + $comm->rate+$orivar->price+$cit;
                                                $offer =  $old->vender_offer_price  + $comm->rate+$orivar->price+$cit;
                                              }else{
                                                $price =  $old->vender_price  + $comm->rate+$orivar->price;
                                                $offer =  $old->vender_offer_price  + $comm->rate+$orivar->price;
                                              }
                                              
                                              

                                                $convert_price = $offer==''?$price:$offer;
                                                $show_price = $price;

                                                if($old->vender_offer_price == 0){

                                                      array_push($price_array, $price);
                                                    }else{
                                                      array_push($price_array, $offer);
                                                    }

                                                
                                                
                                            }
                                            else{

                                                  $commission_amount = $comm->rate;

                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                
                                                    if($old->vender_offer_price ==0){
                                                      $bprice = round($buyerprice,2);
                                                        array_push($price_array, $bprice);
                                                    }else{
                                                      $bsprice = round($buyersaleprice,2);
                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                      $show_price = round($buyerprice,2);
                                                      array_push($price_array, $bsprice);
                                                    }
                                                
                                                
                                                  
                                            }
                                        }else{
                                                  $commission_amount = 0;

                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                
                                                    if($old->vender_offer_price ==0){
                                                        $bprice = round($buyerprice,2);
                                                        array_push($price_array, $bprice);
                                                    }else{
                                                      $bsprice = round($buyersaleprice,2);
                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                      $show_price = round($buyerprice,2);
                                                      array_push($price_array, $bsprice);
                                                    }
                                        }
                                      }
                              
                                    @endphp
                                  
                                
                        @endif

                  
                      @endforeach
                      
                      

                              
                    @endforeach

                @if($price_login == 0 || Auth::check())
                    <?php
                    if($price_array != null){
                    $first =  min($price_array);
                    $startp =  round($first);
                    if($startp >= $first){
                        $startp = $startp-1;
                      }else{
                        $startp = $startp;
                      }

                      
                    $last = max($price_array);
                    $endp =  round($last);

                    if($endp <= $last){
                        $endp = $endp+1;
                      }else{
                        $endp = $endp;
                      }

                    }
                    else{
                      $startp = 0.00;
                      $endp = 0.00;
                    }

                    if(isset($first)){

                      if($first == $last){
                        $startp=0.00;
                      }

                    }
                    

                    unset($price_array); 
                    
                    $price_array = array();
                    ?>
                
                  @endif


                  

                  <li class="nav-item">

                    <div class="row">
                        <div class="col-10">
                            <a role="button" class="nav-link text-truncate" onclick="categoryfilter('{{$item->id}}','','','{{ $startp }}','{{ $endp }}')">
                            <i class="fa {{ $item['icon'] }}"></i> 
                            <span class="d-inline">{{ $item['title'] }}</span>
                            </a>
                        </div>
                        @if($item->subcategory->count() > 0)
                            <div class="col-2">
                                <a class="c_icon_plus float-right collapsed nav-link text-truncate" href="#submenu{{ $item['id'] }}" data-toggle="collapse">
                                    <i class="fa fa-plus-square-o"></i>
                                </a>
                            </div>
                        @endif
                    </div>


                  <div class="collapse" id="submenu{{ $item['id'] }}" aria-expanded="false">
                    

                      @foreach($item->subcategory->where('status','1')->sortBy('position') as $s)
                      

                        @foreach($s->products as $old)

                            @if($genrals_settings->vendor_enable == 1)
                              @foreach($old->subvariants as $orivar)
                                      
                                @if($price_login== 0 || Auth::check())
                                        @php
                                              $convert_price = 0;
                                              $show_price = 0;
                                              
                                              $commision_setting = App\CommissionSetting::first();

                                              if($commision_setting->type == "flat"){

                                                $commission_amount = $commision_setting->rate;
                                                if($commision_setting->p_type == 'f'){
                                                
                                                  if($old->tax_r !=''){
                                                    $cit = $commission_amount*$old->tax_r/100;
                                                    $totalprice = $old->vender_price+$orivar->price+$commission_amount+$cit;
                                                    $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount+$cit;
                                                  }else{
                                                    $totalprice = $old->vender_price+$orivar->price+$commission_amount;
                                                    $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;
                                                  }

                                                  if($old->vender_offer_price == 0){
                                                      $totalprice;
                                                      array_push($price_array, $totalprice);
                                                    }else{
                                                      $totalsaleprice;
                                                      $convert_price = $totalsaleprice==''?$totalprice:$totalsaleprice;
                                                      $show_price = $totalprice;
                                                      array_push($price_array, $totalsaleprice);
                                                    
                                                    }

                                                  
                                                }else{

                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                
                                                    if($old->vender_offer_price ==0){
                                                      $bprice = round($buyerprice,2);
                                                    
                                                        array_push($price_array, $bprice);
                                                    }else{
                                                      $bsprice = round($buyersaleprice,2);
                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                      $show_price = $buyerprice;
                                                      array_push($price_array, $bsprice);
                                                    
                                                    }
                                                

                                                }
                                              }else{
                                                
                                              $comm = App\Commission::where('category_id',$old->category_id)->first();
                                              if(isset($comm)){
                                            if($comm->type=='f'){
                                              
                                              if($old->tax_r !=''){
                                                $cit =$comm->rate*$old->tax_r/100;
                                                $price =  $old->vender_price  + $comm->rate+$orivar->price+$cit;
                                                $offer =  $old->vender_offer_price  + $comm->rate+$orivar->price+$cit;
                                              }else{
                                                $price =  $old->vender_price  + $comm->rate+$orivar->price;
                                                $offer =  $old->vender_offer_price  + $comm->rate+$orivar->price;
                                              }

                                                $convert_price = $offer==''?$price:$offer;
                                                $show_price = $price;

                                                if($old->vender_offer_price == 0){

                                                      array_push($price_array, $price);
                                                    }else{
                                                      array_push($price_array, $offer);
                                                    }

                                                
                                                
                                            }
                                            else{

                                                  $commission_amount = $comm->rate;

                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                
                                                    if($old->vender_offer_price ==0){
                                                      $bprice = round($buyerprice,2);
                                                        array_push($price_array, $bprice);
                                                    }else{
                                                      $bsprice = round($buyersaleprice,2);
                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                      $show_price = round($buyerprice,2);
                                                      array_push($price_array, $bsprice);
                                                    }
                                                
                                                
                                                  
                                            }
                                        }else{
                                                  $commission_amount = 0;

                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                
                                                    if($old->vender_offer_price ==0){
                                                      $bprice = round($buyerprice,2);
                                                        array_push($price_array, $bprice);
                                                    }else{
                                                      $bsprice = round($buyersaleprice,2);
                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                      $show_price = round($buyerprice,2);
                                                      array_push($price_array, $bsprice);
                                                    }
                                          }
                                        }
                                  
                                        @endphp
                                      
                                    
                                        @endif

                        
                            @endforeach
                            @else
                              @if(isset($old->vender['role_id']) && $old->vender['role_id'] == 'a')
                                  @foreach($old->subvariants as $orivar)
                                      
                                @if($price_login== 0 || Auth::check())
                                        @php
                                              $convert_price = 0;
                                              $show_price = 0;
                                              
                                              $commision_setting = App\CommissionSetting::first();

                                              if($commision_setting->type == "flat"){

                                                $commission_amount = $commision_setting->rate;
                                                if($commision_setting->p_type == 'f'){
                                                
                                                  if($old->tax_r !=''){
                                                    $cit = $commission_amount*$old->tax_r/100;
                                                    $totalprice = $old->vender_price+$orivar->price+$commission_amount+$cit;
                                                    $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount+$cit;
                                                  }else{
                                                    $totalprice = $old->vender_price+$orivar->price+$commission_amount;
                                                    $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;
                                                  }

                                                  if($old->vender_offer_price == 0){
                                                      $totalprice;
                                                      array_push($price_array, $totalprice);
                                                    }else{
                                                      $totalsaleprice;
                                                      $convert_price = $totalsaleprice==''?$totalprice:$totalsaleprice;
                                                      $show_price = $totalprice;
                                                      array_push($price_array, $totalsaleprice);
                                                    
                                                    }

                                                  
                                                }else{

                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                
                                                    if($old->vender_offer_price ==0){
                                                      $bprice = round($buyerprice,2);
                                                    
                                                        array_push($price_array, $bprice);
                                                    }else{
                                                      $bsprice = round($buyersaleprice,2);
                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                      $show_price = $buyerprice;
                                                      array_push($price_array, $bsprice);
                                                    
                                                    }
                                                

                                                }
                                              }else{
                                                
                                              $comm = App\Commission::where('category_id',$old->id)->first();
                                              if(isset($comm)){
                                            if($comm->type=='f'){
                                              
                                              if($old->tax_r !=''){
                                                $cit =$comm->rate*$old->tax_r/100;
                                                $price =  $old->vender_price  + $comm->rate+$orivar->price+$cit;
                                                $offer =  $old->vender_offer_price  + $comm->rate+$orivar->price+$cit;
                                              }else{
                                                $price =  $old->vender_price  + $comm->rate+$orivar->price;
                                                $offer =  $old->vender_offer_price  + $comm->rate+$orivar->price;
                                              }

                                                $convert_price = $offer==''?$price:$offer;
                                                $show_price = $price;

                                                if($old->vender_offer_price == 0){

                                                      array_push($price_array, $price);
                                                    }else{
                                                      array_push($price_array, $offer);
                                                    }

                                                
                                                
                                            }
                                            else{

                                                  $commission_amount = $comm->rate;

                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                
                                                    if($old->vender_offer_price ==0){
                                                      $bprice = round($buyerprice,2);
                                                        array_push($price_array, $bprice);
                                                    }else{
                                                      $bsprice = round($buyersaleprice,2);
                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                      $show_price = round($buyerprice,2);
                                                      array_push($price_array, $bsprice);
                                                    }
                                                        
                                                  
                                            }
                                        }else{
                                                  $commission_amount = 0;

                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                
                                                    if($old->vender_offer_price ==0){
                                                      $bprice = round($buyerprice,2);
                                                        array_push($price_array, $bprice);
                                                    }else{
                                                      $bsprice = round($buyersaleprice,2);
                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                      $show_price = round($buyerprice,2);
                                                      array_push($price_array, $bsprice);
                                                    }
                                          }
                                        }
                                  
                                        @endphp
                                      
                                    
                                        @endif

                        
                            @endforeach
                              @endif
                            @endif
                                  
                        @endforeach
                    
                        @if($price_login == 0 || Auth::check())
                          <?php

                          
                          if($price_array != null){
                          $firstsub =  min($price_array);
                          $startp =  round($firstsub);
                          if($startp >= $firstsub){
                              $startp = $startp-1;
                            }else{
                              $startp = $startp;
                            }

                            
                          $lastsub = max($price_array);
                          $endp =  round($lastsub);

                          if($endp <= $lastsub){
                              $endp = $endp+1;
                            }else{
                              $endp = $endp;
                            }

                          }else{
                            $startp = 0.00;
                            $endp = 0.00;
                          }

                          if(isset($firstsub)){
                              if($firstsub == $lastsub){
                                  $startp=0.00;
                              }
                          }
                        

                          unset($price_array); 
                          
                          $price_array = array();
                          ?>
                        @endif
                          <ul class="flex-column pl-2 nav">

                                <div class="row">
                                  <div class="col-10">
                                      <a role="button" class="nav-link text-truncate" onclick="categoryfilter('{{$item->id}}','{{ $s->id }}','','{{ $startp }}','{{ $endp }}')">
                                      <i class="fa {{ $s['icon'] }}"></i> 
                                      <span class="d-inline">{{ $s['title'] }}</span>
                                      </a>
                                  </div>
                                  @if($s->childcategory->count() > 0)
                                      <div class="col-2">
                                          <a class="c_icon_plus float-right collapsed nav-link text-truncate" href="#collapseExample{{ $s['id'] }}" data-toggle="collapse">
                                              <i class="fa fa-plus-square-o"></i>
                                          </a>
                                      </div>
                                  @endif
                                </div>
                            
                            <!-- child category loop -->
                            
                                @if($s->childcategory->count()>0)
                                  <div class="collapse" id="collapseExample{{ $s['id'] }}" aria-expanded="false">
                                    <ul class="flex-column pl-2 nav">
                                      @foreach($s->childcategory->where('status','1')->sortBy('position') as $child)

                                          @foreach($child->products as $old)

                                            @if($genrals_settings->vendor_enable == 1)
                                              @foreach($old->subvariants as $orivar)
                                                      
                                              @if($price_login== 0 || Auth::user())
                                                        @php
                                                              $convert_price = 0;
                                                              $show_price = 0;
                                                              
                                                              $commision_setting = App\CommissionSetting::first();

                                                              if($commision_setting->type == "flat"){

                                                                $commission_amount = $commision_setting->rate;
                                                                if($commision_setting->p_type == 'f'){
                                                                
                                                                  if($old->tax_r !=''){
                                                                    $cit = $commission_amount*$old->tax_r/100;
                                                                    $totalprice = $old->vender_price+$orivar->price+$commission_amount+$cit;
                                                                    $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount+$cit;
                                                                  }else{
                                                                    $totalprice = $old->vender_price+$orivar->price+$commission_amount;
                                                                    $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;
                                                                  }

                                                                  if($old->vender_offer_price == 0){
                                                                      $totalprice;
                                                                      array_push($price_array, $totalprice);
                                                                    }else{
                                                                      $totalsaleprice;
                                                                      $convert_price = $totalsaleprice==''?$totalprice:$totalsaleprice;
                                                                      $show_price = $totalprice;
                                                                      array_push($price_array, $totalsaleprice);
                                                                    
                                                                    }

                                                                  
                                                                }else{

                                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                                
                                                                    if($old->vender_offer_price ==0){
                                                                      $bprice = round($buyerprice,2);
                                                                    
                                                                        array_push($price_array, $bprice);
                                                                    }else{
                                                                      $bsprice = round($buyersaleprice,2);
                                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                                      $show_price = $buyerprice;
                                                                      array_push($price_array, $bsprice);
                                                                    
                                                                    }
                                                                

                                                                }
                                                              }else{
                                                                
                                                              $comm = App\Commission::where('category_id',$old->category_id)->first();
                                                              if(isset($comm)){
                                                            if($comm->type=='f'){
                                                              
                                                              if($old->tax_r !=''){
                                                                $cit =$comm->rate*$old->tax_r/100;
                                                                $price =  $old->vender_price  + $comm->rate+$orivar->price+$cit;
                                                                $offer =  $old->vender_offer_price  + $comm->rate+$orivar->price+$cit;
                                                              }else{
                                                                $price =  $old->vender_price  + $comm->rate+$orivar->price;
                                                                $offer =  $old->vender_offer_price  + $comm->rate+$orivar->price;
                                                              }

                                                                $convert_price = $offer==''?$price:$offer;
                                                                $show_price = $price;

                                                                if($old->vender_offer_price == 0){

                                                                      array_push($price_array, $price);
                                                                    }else{
                                                                      array_push($price_array, $offer);
                                                                    }

                                                                
                                                                
                                                            }
                                                            else{

                                                                  $commission_amount = $comm->rate;

                                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                                
                                                                    if($old->vender_offer_price ==0){
                                                                      $bprice = round($buyerprice,2);
                                                                        array_push($price_array, $bprice);
                                                                    }else{
                                                                      $bsprice = round($buyersaleprice,2);
                                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                                      $show_price = round($buyerprice,2);
                                                                      array_push($price_array, $bsprice);
                                                                    }
                                                                
                                                                
                                                                  
                                                            }
                                                        }else{
                                                                  $commission_amount = 0;

                                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                                
                                                                    if($old->vender_offer_price ==0){
                                                                      $bprice = round($buyerprice,2);
                                                                        array_push($price_array, $bprice);
                                                                    }else{
                                                                      $bsprice = round($buyersaleprice,2);
                                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                                      $show_price = round($buyerprice,2);
                                                                      array_push($price_array, $bsprice);
                                                                    }
                                                        }
                                                            }
                                                  
                                                        @endphp
                                                      
                                                    
                                                        @endif

                                        
                                            @endforeach
                                            @else
                                              @if(isset($old->vender['role_id']) && $old->vender['role_id'] == 'a')
                                                  @foreach($old->subvariants as $orivar)
                                                      
                                              @if($price_login== 0 || Auth::user())
                                                        @php
                                                              $convert_price = 0;
                                                              $show_price = 0;
                                                              
                                                              $commision_setting = App\CommissionSetting::first();

                                                              if($commision_setting->type == "flat"){

                                                                $commission_amount = $commision_setting->rate;
                                                                if($commision_setting->p_type == 'f'){
                                                                
                                                                  if($old->tax_r !=''){
                                                                    $cit = $commission_amount*$old->tax_r/100;
                                                                    $totalprice = $old->vender_price+$orivar->price+$commission_amount+$cit;
                                                                    $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount+$cit;
                                                                  }else{
                                                                    $totalprice = $old->vender_price+$orivar->price+$commission_amount;
                                                                    $totalsaleprice = $old->vender_offer_price + $orivar->price + $commission_amount;
                                                                  }

                                                                  if($old->vender_offer_price == 0){
                                                                      $totalprice;
                                                                      array_push($price_array, $totalprice);
                                                                    }else{
                                                                      $totalsaleprice;
                                                                      $convert_price = $totalsaleprice==''?$totalprice:$totalsaleprice;
                                                                      $show_price = $totalprice;
                                                                      array_push($price_array, $totalsaleprice);
                                                                    
                                                                    }

                                                                  
                                                                }else{

                                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                                
                                                                    if($old->vender_offer_price ==0){
                                                                      $bprice = round($buyerprice,2);
                                                                    
                                                                        array_push($price_array, $bprice);
                                                                    }else{
                                                                      $bsprice = round($buyersaleprice,2);
                                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                                      $show_price = $buyerprice;
                                                                      array_push($price_array, $bsprice);
                                                                    
                                                                    }
                                                                

                                                                }
                                                              }else{
                                                                
                                                              $comm = App\Commission::where('category_id',$old->category_id)->first();
                                                              if(isset($comm)){
                                                            if($comm->type=='f'){
                                                              
                                                              if($old->tax_r !=''){
                                                                $cit =$comm->rate*$old->tax_r/100;
                                                                $price =  $old->vender_price  + $comm->rate+$orivar->price+$cit;
                                                                $offer =  $old->vender_offer_price  + $comm->rate+$orivar->price+$cit;
                                                              }else{
                                                                $price =  $old->vender_price  + $comm->rate+$orivar->price;
                                                                $offer =  $old->vender_offer_price  + $comm->rate+$orivar->price;
                                                              }

                                                                $convert_price = $offer==''?$price:$offer;
                                                                $show_price = $price;

                                                                if($old->vender_offer_price == 0){

                                                                      array_push($price_array, $price);
                                                                    }else{
                                                                      array_push($price_array, $offer);
                                                                    }

                                                                
                                                                
                                                            }
                                                            else{

                                                                  $commission_amount = $comm->rate;

                                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                                
                                                                    if($old->vender_offer_price ==0){
                                                                      $bprice = round($buyerprice,2);
                                                                        array_push($price_array, $bprice);
                                                                    }else{
                                                                      $bsprice = round($buyersaleprice,2);
                                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                                      $show_price = round($buyerprice,2);
                                                                      array_push($price_array, $bsprice);
                                                                    }
                                                                
                                                                
                                                                  
                                                            }
                                                        }else{
                                                                  $commission_amount = 0;

                                                                  $totalprice = ($old->vender_price+$orivar->price)*$commission_amount;

                                                                  $totalsaleprice = ($old->vender_offer_price+$orivar->price)*$commission_amount;

                                                                  $buyerprice = ($old->vender_price+$orivar->price)+($totalprice/100);

                                                                  $buyersaleprice = ($old->vender_offer_price+$orivar->price)+($totalsaleprice/100);

                                                                
                                                                    if($old->vender_offer_price ==0){
                                                                      $bprice = round($buyerprice,2);
                                                                        array_push($price_array, $bprice);
                                                                    }else{
                                                                      $bsprice = round($buyersaleprice,2);
                                                                      $convert_price = $buyersaleprice==''?$buyerprice:$buyersaleprice;
                                                                      $show_price = round($buyerprice,2);
                                                                      array_push($price_array, $bsprice);
                                                                    }
                                                        }
                                                            }
                                                  
                                                        @endphp
                                                      
                                                    
                                                        @endif

                                        
                                            @endforeach
                                              @endif
                                            @endif
                                                    
                                          @endforeach
                          
                                          <?php
                                          
                                          if($price_login == 0 || Auth::check()){
                                              if($price_array != null){
                                          $first =  min($price_array);
                                          $startp =  round($first);
                                          if($startp >= $first){
                                              $startp = $startp-1;
                                            }else{
                                              $startp = $startp;
                                            }

                                            
                                          $last = max($price_array);
                                          $endp =  round($last);

                                          if($endp <= $last){
                                              $endp = $endp+1;
                                            }else{
                                              $endp = $endp;
                                            }

                                          }else{
                                            $startp = 0.00;
                                            $endp = 0.00;
                                          }

                                          if(isset($firstsub))
                                          { 
                                            if($firstsub == $lastsub){
                                              $startp=0.00;
                                          }
                                          }
                                          

                                          unset($price_array); 
                                            
                                          
                                          $price_array = array();
                                          }
                                          
                                          ?>
                                            

                                              <li class="nav-item">
                                                      <a role="button" class="nav-link" onclick="categoryfilter('{{$item->id}}','{{ $s->id }}','{{ $child->id }}','{{ $startp }}','{{ $endp }}')"> <i class="fa fa-star-o"></i>
                                                      {{ $child['title'] }} </a>
                                              </li>
                                            
                                        @endforeach
                                      
                                    </ul>
                                  </div>
                                @endif
                          
                        </ul>
                      @endforeach
                  
                  </div>
                  </li>
             @endforeach
            </ul>
            <!-- /.nav --> 
          </nav>
          <!-- /.megamenu-horizontal --> 
        </div>
        <!-- /.side-menu -->
        <!-- ================================== TOP NAVIGATION : END ================================== -->
        <div class="sidebar-module-container">
          <div class="sidebar-filter">
 

            
            <div class="sidebar-widget outer-top-vs">             
              <h3 class="section-title">{{ __('staticwords.Price') }} ({{ Session::get('currency')['id'] }})</h3>             
               <div class="sidebar-widget-body outer-top-xs">

               
               
                <div class="slider-range-text-block position-relative z-index11">
                  <input type="text" id="amountstart" name="amountstart" value="" class="slider-range-text">
                  <input type="text" id="amountend" name="amountend" value="" class="slider-range-text text-right">
                </div>
                <div id="slider-range" class="slider-range"></div>
                
              </div>
             
            </div>
            <!-- /.sidebar-widget -->

            <!--Featured -->
            <div class="sidebar-widget product-tag outer-top-vs ">
              
              <div class="sidebar-widget-body outer-top-xs">
                <ul>
                  <li>
                      <div class="brand-list-check2">
                      <label class="form-check-label2">{{ __('staticwords.Featured') }}
                      <input class="brand_check2" type="checkbox" id="feapro" value="" onclick="getfeaturedpro('{{ 'featured' }}')">
                      <span class="checkmark"></span>
                      </label>
                      </div>
                    </li>
                </ul>
              </div>

            </div>

            <!-- Out of stock-->
            <div class="sidebar-widget product-tag outer-top-vs ">
              <div class="brand-list-check2">
                  <label class="form-check-label2">{{ __('staticwords.Excludeoutofstock') }}
                  <input class="brand_check2" type="checkbox" id="exoot" value="" onclick="excludeoot('1')">
                  <span class="checkmark"></span>
              </label>
              </div>
                     
            </div>
            <!--END-->
           
         
                @php
                  $getattr = App\ProductAttributes::all();
                @endphp
                <div class="sidebar-custom ">
                  @foreach($getattr as $attr)
                    <?php
                      $res = in_array($catid,$attr->cats_id);
                    ?>

                    @if($res == $attr->id)
                  
                      <div class="sidebar-widget sidebar-custom outer-top-vs">

                          <a id="expand{{ $attr->id }}" class="pull-right btn btn-xs" data-toggle="collapse" data-target="#attrBox{{ $attr->id }}">
                              <i class="fa fa-minus"></i>
                          </a>

                          <h3 class="section-title"> <i>
                            @php
                                $key = '_'; 
                            @endphp
                            @if (strpos($attr->attr_name, $key) == false)
                            
                              {{ $attr->attr_name }}
                               
                            @else
                              
                              {{str_replace('_', ' ', $attr->attr_name)}}
                              
                            @endif
                            </i>
                              
                          </h3>
                          
                      
                          <div id="attrBox{{ $attr->id }}" class="collapse hide" class="sidebar-widget-body">
                            @foreach ($attr->provalues as $item)
                              
                                <div class="brand-list-check">
                                  <label class="form-check-label">
                                      @if($item->values == $item->unit_value && $item->unit_value !='')
                                      {{ $item->values }}
                                      @else

                                     @if($item->proattr->attr_name == "Color" || $item->proattr->attr_name == "Colour" || $item->proattr->attr_name =="color" || $item->proattr->attr_name == "colour" )
                                     

                                     <div class="inline-flex">
                                            <div class="color-options">
                                              <ul>
                                                 <li title="{{ $item->values }}" class="color varcolor active"><a href="#" title=""><i style="color: {{ $item->unit_value }}" class="fa fa-circle"></i></a>
                                                        <div class="overlay-image overlay-deactive">
                                                        </div>
                                                  </li>
                                              </ul>
                                            </div>
                                         </div>
                                      <span class="tx-color">{{ $item->values }}</span>

                                     @else
                                      {{ $item->values }}{{ $item->unit_value }}
                                      @endif
                                    @endif
                                  <input class="var_check_all var_check{{ $attr->id }}" type="checkbox" id="variant{{ $item->id }}" value="{{ $item->id }}" onclick="getvariantpro('{{ $attr->id }}','{{ $item->id }}')">
                                  <span class="checkmark"></span>
                                  </label>
                                  <br>
                                </div>
                            @endforeach
                          </div>
                      </div>
                  
                    @endif
                  @endforeach
                </div>
             
            <!-- ============================================== PRODUCT TAGS ============================================== -->
            <div class="sidebar-widget product-tag outer-top-vs">

              <a id="singlebox" data-toggle="collapse" data-target="#tagbox" class="pull-right btn btn-xs">
                <i class="fa fa-minus"></i>
              </a>

              <h3 class="section-title">{{ __('staticwords.protags') }}</h3>
              <div id="tagbox" class="collapse sidebar-widget-body outer-top-xs">
                <div class="tag-list"> 
                  <?php
                    $tags_new = array(); 
                    if($chid != ''){
                     
                      $pros= App\Product::orderBy('id', 'DESC')->where('grand_id',$chid)->where([['status','1'],])->get();
                      foreach($pros as $pro){
                        
                        if(count($pro->subvariants) > 0){
                      
                          $tags = explode(',',$pro->tags);
                          foreach($tags as $t){
                            array_push($tags_new, $t);
                          }
                        }
                      
                      }
                    }else {
                     
                      if($sid != ''){
                      $pros= App\Product::orderBy('id', 'DESC')->where('child',$sid)->where([['status','1'],])->get();
                      
                      foreach($pros as $pro){
                        
                        if(count($pro->subvariants) > 0){
                      
                          $tags = explode(',',$pro->tags);
                          foreach($tags as $t){
                            array_push($tags_new, $t);
                          }
                        }
                      
                      }
                  
                    }
                      else{
                       
                      $pros= App\Product::orderBy('id', 'DESC')->where('category_id',$catid)->where([['status','1'],])->get();
                      foreach($pros as $pro){
                        
                        if(count($pro->subvariants) > 0){
                      
                          $tags = explode(',',$pro->tags);
                          foreach($tags as $t){
                            array_push($tags_new, $t);
                          }
                        }
                      
                      }
                    }
                  }
                    
                   
                    $tagsunique = array_unique($tags_new);
                  ?>
                  
                  <div id="tags-all">
                  @foreach($tagsunique as $key => $tag)
                  <a onClick="tagfilter('{{ $tag }}','{{ $key }}')" id="tag{{ $key }}" name="{{ $tag }}" class="item pro-tags-all"><i>{{$tag}}</i></a> 
                  @endforeach
                  </div>
                  <hr>

                  <table width="100%">
                      <tr>

                        <td id="loadMoretagsTd"  align="left" class="padding0">
                          <a class="btn btn-xs btn-info display-none cursor-pointer" id="loadMoretags" >Load More</a> 
                        </td>

                        <td id="showLesstagsTd" align="right" class="padding0">
                            <a id="showLesstags" class="btn btn-xs btn-info cursor-pointer display-none" >Show Less</a> 
                        </td>
                      </tr>
                  </table>
                 
                </div>
                
                <!-- /.tag-list -->
              </div>
              
              <!-- /.sidebar-widget-body -->
            </div>
           
         
          <!-- Brand -->
          <div class="sidebar-widget product-tag outer-top-vs ">
            <a id="brandexpand" data-toggle="collapse" data-target="#brandboxI" class="pull-right btn btn-xs">
              <i class="fa fa-minus"></i>
            </a>

          <h3 class="section-title">{{ __('Brand') }}</h3>
            <div id="brandboxI" class="collapse sidebar-widget-body outer-top-xs">

              <div class="form-group">
                <input type="button" class="search-submit"> 
                <input type="search" id="brand_query" name="brand_query" class="search-text" placeholder="Search Brand..." autocomplete="off">
              </div>

              <br>
              <div class="brand-list"> 
                
                <ul class="brand-checkbox" id='myList'>
                   
                    @php
                    
                    $allbrands = App\Brand::all();
                    @endphp
                     @foreach($allbrands as $key => $brands)
                    
                     @if(is_array($brands->category_id))
                       @foreach($brands->category_id as $brandcategory)
                           @if($brandcategory == $catid)
                          
                           <li>
                              <div class="brand-list-check">
                              <label class="form-check-label">{{$brands->name }}
                              <input class="brand_check" type="checkbox" id="br{{ $brands->id }}" value="{{ $brands->id }}" onclick="getBrandProducts('{{ $brands->id }}')">
                              <span class="checkmark"></span>
                              </label>
                              </div>
                            </li>
                          @endif  
                       @endforeach
                     @endif
                     @endforeach
                </ul>
                <hr>
                  <table width="100%">
                    <tr>
                      <td id="loadMorebrandsTd" align="left" class="padding0">
                        <a id="loadMore" class="btn btn-xs btn-info display-none cursor-pointer" >{{ __('Load More') }}</a>
                      </td>
                      <td id="showLessbrandsTd" align="right" class="padding0">
                        <a id="showLess" class="btn btn-xs btn-info display-none cursor-pointer" >{{ __('Show Less') }}</a>
                      </td>
                    </tr>
                  </table>
              </div>             
            </div>           
          </div>

          <!-- Customer Rating -->
          <div class="sidebar-widget product-tag outer-top-vs ">

              <a id="ratingexpand" data-toggle="collapse" data-target="#ratingbox" class="pull-right btn btn-xs">
                  <i class="fa fa-minus"></i>
              </a>

              <h3 class="section-title">{{ __('staticwords.CustomerRatings') }}</h3>
              <div id="ratingbox" class="collapse sidebar-widget-body outer-top-xs">
                <ul>  
                    <li>
                      <div class="brand-list-check">
                      <label class="form-check-label">
                       
                       <img width="35px" src="{{ url('images/newst.png') }}" alt=""> {{ __('4& above') }}
                       <input name="rat_a" class="rt_chk" type="checkbox" id="rat_pro100" value="100" onclick="getratingproduct(100)">
                      <span class="checkmark"></span>
                      </label>
                      </div>
                    </li>

                    <li>
                        <div class="brand-list-check">
                            <label class="form-check-label">
                        <img width="35px" src="{{ url('images/3s.png') }}" alt=""> {{ __('3& above') }}
                        <input name="rat_a" class="rt_chk" type="checkbox" id="rat_pro80" value="80" onclick="getratingproduct(80)">
                        <span class="checkmark"></span>
                        </label>
                        </div>
                    </li>

                    <li>
                        <div class="brand-list-check">
                            <label class="form-check-label">
                        <img width="35px" src="{{ url('images/2s.png') }}" alt=""> {{ __('2& above') }}
                        <input name="rat_a" class="rt_chk" type="checkbox" id="rat_pro60" value="60" onclick="getratingproduct(60)">
                        <span class="checkmark"></span>
                        </label>
                        </div>
                    </li>

                    <li>
                        <div class="brand-list-check">
                            <label class="form-check-label">
                        <img width="35px" src="{{ url('images/1s.png') }}" alt=""> {{ __('1& above') }}
                        <input name="rat_a" class="rt_chk" type="checkbox" id="rat_pro40" value="40" onclick="getratingproduct(40)">
                        <span class="checkmark"></span>
                        </label>
                        </div>
                    </li>

                </ul>
              </div>
          </div>
         <!--End-->
        </div>
          
          <!-- /.sidebar-filter -->
        </div>
        <!-- /.sidebar-module-container -->
      </div>
      <!-- /.sidebar -->
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-10 rht-col">
        
        <div class="clearfix filters-container ">
          <div class="row">
            <div class="col col-sm-6 col-md-3 col-lg-3 col-12">
              <div class="filter-tabs">
                <ul id="filter-tabs" class="nav nav-tabs nav-tab-box nav-tab-fa-icon">
                  
                  
                  
                </ul>
              </div>
              <!-- /.filter-tabs -->
            </div>
            
          </div>
          <!-- /.row -->
        </div>
        <div class="search-conversion_rate-container ">
          <div id="myTabContent" class="tab-content category-list">
            <div class="tab-pane active " id="grid-container">
              <div class="category-product filter-block">
                <div>
                    
                    <div class="row" id="updatediv">

                        @include('front.cat.product')
                  
                    </div>
                    </div>
                      
                    </div>
                    <!-- /.product-list -->
                  </div>
                  <!-- /.products -->
                </div>
                <!-- /.category-product-inner -->


                <!-- /.category-product-inner -->


                <!-- /.category-product-inner -->
                {{-- {!! $products->appends(Request::except('page'))->links() !!} --}}
              </div>
              <!-- /.category-product -->
            </div>
            <!-- /.tab-pane #list-container -->
          </div>
         

        </div>
        <!-- /.search-conversion_rate-container -->
        
      </div>
      <!-- /.col -->
    </div>
</div>
@endsection
@section('head-script')
    @include('front.filters.headscript')
@endsection
@section('script')
     @include('front.filters.bottomscript')
@endsection