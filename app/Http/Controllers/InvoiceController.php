<?php
namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use Auth;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $Invoice = Invoice::first();

        return view("admindesk.Invoice.edit", compact("Invoice"));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoice = Invoice::first();

        if (empty($invoice))
        {

            $data = $this->validate($request, ["prefix" => "required", "postfix" => "required",

            ], [

            "prefix.required" => "Prefix Field is Required", "postfix.required" => "Postfix Field is Required",

            ]);

            $obj = new Invoice;

            $obj->order_prefix = $request->prefix;
            $obj->prefix = $request->prefix;
            $obj->postfix = $request->postfix;
            $obj->inv_start = $request->inv_start;
            $obj->cod_prefix = $request->cod_prefix;
            $obj->cod_postfix = $request->cod_postfix;
            $obj->terms = $request->terms;
            $obj->user_id = Auth::user()->id;

            if ($file = $request->file('seal'))
            {

                $name = time() . $file->getClientOriginalName();

                $file->move('public/images/seal', $name);

                $obj->seal = $name;

            }

            if ($file = $request->file('sign'))
            {

                $name = time() . $file->getClientOriginalName();

                $file->move('public/images/sign', $name);

                $obj->sign = $name;

            }

            $value = $obj->save();
            if ($value)
            {
                session()->flash("updated", "Invoice has been Created for You !");
                return back();
            }
        }

        else
        {

            $update = new Invoice;
            $obj = $update->first();
            $obj->order_prefix = $request->order_prefix;
            $obj->prefix = $request->prefix;
            $obj->postfix = $request->postfix;
            $obj->inv_start = $request->inv_start;
            $obj->cod_prefix = $request->cod_prefix;
            $obj->cod_postfix = $request->cod_postfix;
            $obj->terms = $request->terms;

            if ($file = $request->file('seal'))
            {

                $seal  = @file_get_contents('../public/images/seal/' . $obj->seal);
                if ($seal)
                {
                    unlink('../public/images/seal/' . $obj->seal);
                }

                $name = time() . $file->getClientOriginalName();

                $file->move('../public/images/seal', $name);

                $obj->seal = $name;

            }

            if ($file = $request->file('sign'))
            {
                $sign = @file_get_contents('../public/images/sign/' . $obj->sign);

                if ($sign)
                {
                    unlink('../public/images/sign/' . $obj->sign);
                }

                $name = time() . $file->getClientOriginalName();

                $file->move('../public/images/sign', $name);

                $obj->sign = $name;

            }

            $value = $obj->save();
            if ($value)
            {
                session()->flash("updated", "Invoice Setting has been Updated for You !");
                return back();
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Category $category)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */

}

