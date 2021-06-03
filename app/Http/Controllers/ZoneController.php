<?php

namespace App\Http\Controllers;

use App\Zone;
use App\Country;
use App\Allstate;
use Illuminate\Http\Request;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zones = Zone::all();
        return view("admindesk.zone.index",compact("zones"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country = Country::all();
        return view("admindesk.zone.add",compact('country'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        

        $data = $this->validate($request,[
            
            "name"=>"required",
            "code"=>"required",
            "country_id"=>"required|not_in:0",
            
        ],[

            "name.required"=>"Zone Fild is Required",
            "country_id"=>"Please Choose Country"
            
          ]);

          $input = $request->all();

        $data = Zone::create($input);
        
        $data->save();
        
        return back()->with("category_message","Zone Has Been Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::all();
        $zone = Zone::findOrFail($id);
        $states = Allstate::where('country_id',$zone->country_id)->get();
       
        return view("admindesk.zone.edit",compact("zone","country","states"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

         $zone = Zone::findOrFail($id);
         
         $zone->title = $request->title;
         $zone->name = $request->name;
         $zone->country_id = $request->country_id;
         $zone->code = $request->code;
         $zone->status = $request->status;

         $zone->save();

          return redirect('admindesk/zone')->with('category_message', 'Zone has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $daa = new Zone;
         $obj = $daa->findorFail($id);
         $value = $obj->delete();
         if($value){
            session()->flash("category_message","Zone Has Been deleted");
             return redirect("admindesk/zone");
         }
    }
}
