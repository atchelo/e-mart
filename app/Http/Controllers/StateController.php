<?php

namespace App\Http\Controllers;

use App\Allstate;
use App\State;
use App\Country;
use Illuminate\Http\Request;
use DB;
use DataTables;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){

           $data = Allstate::join('allcountry','allstates.country_id' ,'=', 'allcountry.id' )->select('allstates.name as statename','allcountry.name as cname');

            return Datatables::of($data)->addIndexColumn()
                ->addColumn('name', function($row){
                    return $row->statename;
                 })
                ->addColumn('cname', function($row){
                    return $row->cname;
                 })
                ->rawColumns(['name','cname'])
                ->make(true);
        }
         
        
        return view("admindesk.state.index");
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countrys = Country::all();
        return view("admindesk.state.add_state",compact("countrys"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:allstates,name',
            'country_id' => 'required'
        ],[
            'name.required' => 'State name is required',
            'name.unique' => 'State already exist !',
            'country_id.required' => 'Please select country'
        ]);

        $newState = new Allstate;
        $input =  $request->all();
        $newState->create($input);
        return back()->with('added','State added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
        $state = State::findOrFail($id);
         $countrys = Country::all();
        return view("admindesk.state.edit",compact("state","countrys"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
           
            $data = $this->validate($request,[
            "state"=>"required",
            
        ],[

            "state.required"=>"State Name is Required",
            
          ]);

            $daa = new State;
            $obj = $daa->findorFail($id);
            
              $obj->country_id = $request->country_id;
              $obj->state = $request->state;

                $value=$obj->save();
                if($value){
                    session()->flash("updated","State Has Been Update");
                    return redirect("admindesk/state/".$id."/edit");
                }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\State  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $state = State::find($id);
        $value = $state->delete();
        if($value){
            session()->flash("deleted","State Has Been Deleted");
            return redirect("admindesk/state");
         }
    }
}
