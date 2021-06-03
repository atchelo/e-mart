<?php
namespace App\Http\Controllers;

use App\FaqProduct;
use Illuminate\Http\Request;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class FaqProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $faqs = FaqProduct::all();
        return view("admindesk.product_faq.index", compact("faqs"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $pro_id = $id;
        return view("admindesk.product.tab.faq.create", compact('pro_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(['question' => 'required', 'answer' => 'required']);

        $input = $request->all();

        FaqProduct::create($input);

        return back()->with('added', 'Faq has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FaqProduct  $faqProduct
     * @return \Illuminate\Http\Response
     */
    public function show(FaqProduct $faqProduct)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FaqProduct  $faqProduct
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $faq = FaqProduct::findOrFail($id);
        return view("admindesk.product.edit_tab", compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FaqProduct  $faqProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $faq = FaqProduct::findOrFail($id);

        $request->validate(['question' => 'required', 'answer' => 'required']);

        $input = $request->all();

        $faq->update($input);
        return back()->with('updated', 'Faq has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FaqProduct  $faqProduct
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $faq = FaqProduct::findOrFail($id);

        $faq->delete();
        return back()
            ->with('deleted', 'Faq has been deleted');
    }
}

