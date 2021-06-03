<?php
namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use DB;
use App\Allcountry;
use DataTables;
use Log;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $data = Country::join('allcountry', 'allcountry.iso3', '=', 'countries.country')->select('countries.id as cid', 'allcountry.*');

        $countries = Country::all();

        if ($request->ajax())
        {

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', 'admindesk.country.actionbtn')
                ->rawColumns(['action'])
                ->make(true);
        }

        return view("admindesk.country.index", compact('countries'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admindesk.country.add_country");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, ["country" => "required|unique:countries|min:3|max:3",

        ], [

        "country.required" => "Country Name is required", "country.min" => "Country code (ISO3) have 3 digit only", "country.max" => 'Country code (ISO3) have 3 digit only '

        ]);

        $country = \DB::table('allcountry')->where('iso3',$request->country)->first();

        if(!isset($country)){
            return back()->with('warning','No country found with this CODE !')->withInput();
        }

        $obj = new Country;

        $obj->country = $request->country;

        $value = $obj->save();
        if ($value)
        {
            session()->flash("added", "Country Has Been Added !");
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::findOrFail($id);
        return view("admindesk.country.edit", compact("country"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $allcountry = Country::all();

        $country = \DB::table('allcountry')->where('iso3',$request->country)->first();

        if(!isset($country)){
            return back()->with('warning','No country found with this CODE !')->withInput();
        }

        
        $obj = Country::findorFail($id);
        
        $request->validate( [

            "country" => 'required|min:3|max:3|unique:countries,country,'.$obj->id,

        ], [

            "country.required" => "Country Name is required", 
            "country.min" => "Country code (ISO3) have 3 digit only", 
            "country.max" => 'Country code (ISO3) have 3 digit only '

        ]);

        $obj->country = $request->country;

        $value = $obj->save();

        if ($value)
        {
            session()->flash("category_message", "Country Has Been Updated !");
            return redirect("admindesk/country/" . $id . "/edit");
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $daa = new Country;
        $obj = $daa->findorFail($id);
        $value = $obj->delete();
        if ($value)
        {
            session()->flash("deleted", "Country Has Been deleted");
            return redirect("admindesk/country");
        }
    }
}

