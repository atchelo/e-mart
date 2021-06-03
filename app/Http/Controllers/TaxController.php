<?php

namespace App\Http\Controllers;

use App\Tax;
use Illuminate\Http\Request;
use App\Zone;
use App\TaxClass;
use App\Country;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $taxs = Tax::all();
        return view("admindesk.tax.index",compact("taxs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country = Country::all();
        $tax_class = TaxClass::all();
        $zones = Zone::all();
        return view("admindesk.tax.add",compact('zones','country','tax_class'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      

         $input = $request->all(); 
        $data = Tax::create($input);
        $data->save();
        return redirect('admindesk/tax')->with('category_message', 'Tax has been updated');
    }

    


    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tax_class = TaxClass::all();
        $tax = Tax::findOrFail($id);
        return view("admindesk.tax.edit",compact("tax","tax_class"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         
        $data = $this->validate($request,[
            "name"=>"required",
            'rate' => 'required|integer|not_in:0',
            'zone_id' => 'required|not_in:0',
            
        ],[

            "name.required"=>"Name Fild is Required",
            "rate.required"=>"Rate Fild Accept Only Number",
            
          ]);

        
         $tax = Tax::findOrFail($id);
          $input = $request->all();  
          $tax->update($input);

          return redirect('admindesk/tax')->with('category_message', 'Tax has been updated');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $daa = new Tax;
         $obj = $daa->findorFail($id);
         $value = $obj->delete();
         if($value){
            session()->flash("category_message","Tax Has Been deleted");
             return redirect("admindesk/tax");
         }
    }
}
