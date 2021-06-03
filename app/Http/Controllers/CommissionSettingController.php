<?php
namespace App\Http\Controllers;

use App\CommissionSetting;
use Illuminate\Http\Request;
use App\Store;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class CommissionSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $commission_settings = CommissionSetting::all();
        return view("admindesk.commission_setting.index", compact("commission_settings"));
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
        $data = CommissionSetting::create($input);
        $data->save();
        return redirect('admindesk/commission_setting')
            ->with('updated', 'Commission Setting has been updated');
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
        $commission = CommissionSetting::findOrFail($id);
        return view("admindesk.commission_setting.edit", compact("commission"));
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

        $commission_setting = CommissionSetting::findOrFail($id);
        $input = $request->all();
        $commission_setting->update($input);
        return redirect('admindesk/commission_setting')->with('updated', 'Commission Setting has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $daa = new CommissionSetting;
        $obj = $daa->findorFail($id);
        $value = $obj->delete();
        if ($value)
        {
            session()->flash("deleted", "Commission Setting Has Been deleted");
            return redirect("admindesk/commission_setting");
        }
    }

}

