<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShippingWeight;
use Auth;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class ShippingWeightController extends Controller
{
    public function get()
    {
    	$swt = ShippingWeight::first();
    	return view('admindesk.shipping.weight.shipweight',compact('swt'));
    }

    public function update(Request $request)
    {   

        
        
        if(isset(Auth::user()->id)){
            $user_id = Auth::user()->id;
        }
    	

    	$swt = ShippingWeight::first();

    	$swt->weight_from_0 = $request->weight_from_0;
    	$swt->weight_to_0 = $request->weight_to_0;
    	$swt->weight_price_0 = $request->weight_price_0;
        $swt->per_oq_0 = $request->per_oq_0;

    	$swt->weight_from_1 = $request->weight_from_1;
    	$swt->weight_to_1 = $request->weight_to_1;
    	$swt->weight_price_1 = $request->weight_price_1;
        $swt->per_oq_1 = $request->per_oq_1;

    	$swt->weight_from_2 = $request->weight_from_2;
    	$swt->weight_to_2 = $request->weight_to_2;
    	$swt->weight_price_2 = $request->weight_price_2;
        $swt->per_oq_2 = $request->per_oq_2;

    	$swt->weight_from_3 = $request->weight_from_3;
    	$swt->weight_to_3 = $request->weight_to_3;
    	$swt->weight_price_3 = $request->weight_price_3;
        $swt->per_oq_3 = $request->per_oq_3;

    	$swt->weight_from_4 = $request->weight_from_4;
    	$swt->weight_price_4 = $request->weight_price_4;
        $swt->per_oq_4 = $request->per_oq_4;
        $swt->vender_id = $user_id;
    	$swt->save();

    	return redirect()->route('get.wt')->with('updated','Shipping Weight Setting Updated !');
    }

}
