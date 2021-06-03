<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductAttributes;
use App\ProductValues;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class ProductValueController extends Controller
{
    public function get($id)
    {
    	$provalues = ProductValues::where('atrr_id','=',$id)->get();
    	$proattr = ProductAttributes::findorfail($id);
    	return view('admindesk.provalues.index',compact('proattr','provalues'));
    }

    public function store(Request $request,$id)
    {

    
        $request->validate([
            'value' => 'required|min:1'
        ]);

    	$proattr = ProductAttributes::findorfail($id);
    	$newvalue = new ProductValues;

        $findsameproval = ProductValues::where('values','=',$request->value)->where('atrr_id','=',$id)->first();

        if (isset($findsameproval)) {
            if (strcasecmp($findsameproval->values, $request->value) == 0) {
                return back()->with('warning','Value is already there !');
            }
        }else
        {
            $newvalue->values = $request->value;
            $newvalue->atrr_id = $id;
            $newvalue->unit_value = $request->unit_value;
            $newvalue->save();
        }

    	

    	return back()->with('added','Value '.$request->value.' for option '.$proattr->attr_name.' created succesfully !' );
    }

    

    public function update(Request $request,$id,$attr_id)
    {   
      
    	$getval = $request->newval;
        $uval = $request->uval;

            
            $run_q = ProductValues::where('id','=',$id)->update(['values' => $getval, 'unit_value' => $uval]);

            if($run_q)
            {
                
                return "<div class='well custom-well'>Value Changed to $getval $uval succesfully !</div>" ;
            }else {
               
                return "<div class='well custom-well'>Error In Updating Value !</div>" ;
            }

        
    	
    }
}
