<?php

namespace App\Http\Controllers;

use App\Social;
use Illuminate\Http\Request;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class SocialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $socials = Social::all();
        return view('admindesk.social.index', compact('socials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admindesk.social.add');
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

        $data = Social::create($input);

        $data->save();

        notify()->success('Social icon added successfully !');
        return redirect('admindesk/social');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function show(Social $social)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $row = Social::find($id);
        return view('admindesk.social.edit', compact('row'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Social::find($id);

        if(!$menu){
            notify()->error('Icon not found !','404');
            return redirect('admindesk/social');
        }

        $input = $request->all();

        $menu->update($input);

        notify()->success('Social icon updated successfully !');
        return redirect('admindesk/social');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Social  $social
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Social::find($id);

        if(!$menu){
            notify()->error('Icon not found !','404');
            return redirect('admindesk/social');
        }

        $menu->delete();

        notify()->success('Social icon deleted successfully !');
        return redirect('admindesk/social');
    }
}
