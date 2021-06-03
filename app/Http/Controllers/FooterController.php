<?php
namespace App\Http\Controllers;

use App\Footer;
use Illuminate\Http\Request;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class FooterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $row = Footer::first();
        return view("admindesk.footer.edit", compact("row"));
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $footer = Footer::first();
        $input = $request->all();
        if (empty($footer))
        {
            $data = Footer::create($input);
            $data->save();
            return back()
                ->with("added", "Footer Has Been Created !");
        }
        else
        {
            $footer->update($input);
            return back()->with("updated", "Footer Has Been Updated !");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Footer  $footer
     * @return \Illuminate\Http\Response
     */

}

