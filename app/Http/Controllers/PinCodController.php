<?php
namespace App\Http\Controllers;

use App\PinCod;
use Illuminate\Http\Request;
use App\Allcountry;
use App\Allstate;
use App\Allcity;
use App\Country;
use App\State;
use App\City;
use App\Config;
use DataTables;
use DB;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class PinCodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function enablesystem(Request $request)
    {

        $config = Config::first();

        $config->pincode_system = $request->enable;

        $config->save();

        return 'success';

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

        $data = PinCod::create($input);

        $data->save();

        return back()
            ->with("category_message", "Pin Code Has Been Created");
    }

    
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PinCod  $pinCod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();

        $user = PinCod::findOrFail($id);

        $user->update($input);

        return back()->with("category_message", "Pin Code Has Been Update");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PinCod  $pinCod
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = PinCod::find($id);
        $value = $user->delete();
        if ($value)
        {
            session()->flash("category_message", "Pin Code Has Been Deleted");
            return redirect("admindesk/pincode");
        }
    }

    public function destination(Request $request)
    {

        $countries = Country::join('allcountry','countries.country','=','allcountry.iso3')
                    ->select('allcountry.*');

        if ($request->ajax())
        {
             return Datatables::of($countries)
            ->addIndexColumn()
            ->addColumn('country',function($row){
                    return $row->nicename;
             })
            ->addColumn('view', function ($row)
            {

                $btn = '<a title="Click to view list of cities" href=' . url('/admindesk/destination/listbycountry/' . $row->id . '/pincode') . ' class="btn btn-primary btn-sm">View</a>';

                return $btn;
            })
            ->rawColumns(['country','view'])
            ->make(true);

        }

        return view('admindesk.destination.index');
    }

    public function getDestinationdata(Request $request, $id)
    {

        $country_name = Allcountry::query();

        $country = $country_name->where('id', $id)->first();

        if ($request->ajax())
        {

            $data = \DB::table('allcities')->join('allstates', 'allstates.id', '=', 'allcities.state_id')
                ->select('allcities.id as id', 'allcities.name as c', 'allcities.pincode as pincode', 'allstates.name as statename')
                ->where('allstates.country_id', $country->id);

            return Datatables::of($data)

            ->addIndexColumn()
            ->addColumn('cityname',function($row){
                    return $row->c;
            })
            ->addColumn('statename',function($row){
                    return $row->statename;
            })
            ->editColumn('pincode', function ($row)
            {

                if (!empty($row->pincode))
                {
                    $html = "<span id='show-pincode$row->id'></span><div class='code'><input class='checkPin' s='a' type='text' id='pincode$row->id' name='pincode' value='$row->pincode'>&nbsp;<button id='btnAddProfile$row->id' class='btn btn-xs btn-primary' onClick='checkPincode($row->id)'>Edit</button></div>";

                }
                else
                {
                    $html = "<span id='show-pincode$row->id'></span><div class='code'><input class='checkPin' s='a' type='text' id='pincode$row->id' name='pincode' value=''>&nbsp;<button id='btnAddProfile$row->id' onClick='checkPincode($row->id)' class='btn btn-xs btn-success'>Add</button></div>";

                }

                return $html;

            })->rawColumns(['cityname','statename','pincode'])
                ->make(true);

        }

        return view('admindesk.destination.table', compact('country'));

    }

    public function show_destination()
    {
        $city = Allcity::where('pincode', '<>', 'Null')->get();
        $state = State::all();
        $countrys = Country::all();
        return view('admindesk.destination.show_destination', compact('city', 'state', 'countrys'));
    }

    public function pincode_add(Request $request)
    {
        $data = Allcity::where('id', $request->id)
            ->first();
        Allcity::where('id', $request->id)
            ->update(array(
            'pincode' => $request->code
        ));
        if ($data)
        {
            echo $request->code;
        }

    }

    //Front Check
    public function pincode_check(Request $request)
    {
        $pincode = $request->name;
        $len = strlen($pincode);

        if ($len < 6)
        {
            return 'Invalid Pincode';
        }

        $db_pincod = Allcity::where('pincode', $pincode)->first();

        if (!empty($db_pincod))
        {
            if ($db_pincod->pincode == $pincode)
            {
                return "Delivery is Available";
            }

            else
            {
                echo "Delivery is not Available";
            }
        }
        else
        {
            echo "Delivery is not Available";
        }
    }
}

