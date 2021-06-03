<?php

namespace App\Http\Controllers;

use App\TaxClass;
use Illuminate\Http\Request;
use App\Country;
use App\State;
use App\Allstate;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class TaxClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $taxs = TaxClass::all();
        return view("admindesk.tax_class.index",compact("taxs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country = Country::all();
        return view("admindesk.tax_class.add",compact('country'));
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
        $data = TaxClass::create($input);
        $data->save();
        return redirect('admindesk/tax_class')->with('category_message', 'Tax Class has been updated');
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
        //$tax_class = TaxClass::all();
        $country = Country::all();
        $tax = TaxClass::findOrFail($id);
        $states = Allstate::where('country_id',$tax->country_id)->get();

        return view("admindesk.tax_class.edit",compact("tax","country","states"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
          
            $tax =  TaxClass::where('id',$request->id)->first();
         

            $tax->title         =   $request->title;
            $tax->des           =   $request->des;
            $tax->taxRate_id    =   $request->taxArry;
            $tax->priority      =   $request->priArry;
            $tax->based_on      =   $request->basedArry;
                        
            $tax->save();


          return redirect('admindesk/tax_class')->with('category_message', 'Tax Class has been updated');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $daa = new TaxClass;
         $obj = $daa->findorFail($id);
         $value = $obj->delete();
         if($value){
            session()->flash("category_message","Tax Class Has Been deleted");
             return redirect("admindesk/tax_class");
         }
    }

    public function addRow(Request $request){
        $tax = new TaxClass;

        $tax->title = $request->title;
        $tax->des = $request->des;
        $tax->taxRate_id = $request->taxArry;
        $tax->priority = $request->priArry;
        $tax->based_on = $request->basedArry;
                        
        $tax->save();


         echo 'Success !';

    }
}
