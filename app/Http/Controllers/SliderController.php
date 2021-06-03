<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Slider;
use Illuminate\Http\Request;
use Image;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Developer: @nkit                 =
=            Copyright (c) 2020            =
==========================================*/

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::all();
        return view("admindesk.slider.index", compact("sliders"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {

        $product = Product::all();
        $category = Category::all();
        return view("admindesk.slider.create", compact("product", "category"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slider = new Slider;

        $request->validate([
            'image' => 'required | mimes:png,jpeg,jpg,gif,bmp| max:1000',
        ]);

        if ($request->link_by == 'cat') {

            $slider->category_id = $request->category_id;

        } else if ($request->link_by == 'sub') {

            $slider->child = $request->subcat;

        } else if ($request->link_by == 'url') {

            $slider->url = $request->url;

        } else if ($request->link_by == 'child') {

            $slider->grand_id = $request->child;

        } else if ($request->link_by == 'pro') {

            $slider->product_id = $request->pro;

        }
        $slider->link_by = $request->link_by;
        $slider->topheading = $request->heading;
        $slider->heading = $request->subheading;
        $slider->headingtextcolor = $request->headingtextcolor;
        $slider->subheadingcolor = $request->subheadingcolor;
        $slider->buttonname = $request->buttonname;
        $slider->moredesc = $request->moredesc;
        $slider->moredesccolor = $request->moredesccolor;
        $slider->btnbgcolor = $request->btnbgcolor;
        $slider->btntextcolor = $request->btntextcolor;

        if (isset($request->status)) {
            $slider->status = '1';
        } else {
            $slider->status = '0';
        }

        if ($file = $request->file('image')) {

            $optimizeImage = Image::make($file);

            $optimizePath = public_path() . '/images/slider/';

            $image = time() . $file->getClientOriginalName();

            $optimizeImage->fit(1247, 520, function ($constraint) {
                $constraint->aspectRatio();
            });

            $optimizeImage->save($optimizePath . $image);

            $slider->image = $image;

        }

        $slider->save();

        return redirect()->route('slider.index')->with('added', 'Slider has been created !');
    }

    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::all();
        $slider = Slider::findOrFail($id);
        $product = Product::all();
        return view("admindesk.slider.edit", compact("slider", "product", "category"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $slider = Slider::findorFail($id);

        $request->validate([
            'image' => 'mimes:png,jpeg,jpg,gif,bmp| max:1000',
        ]);

        if ($request->link_by == 'cat') {

            $slider->category_id = $request->category_id;
            $slider->child = null;
            $slider->url = null;
            $slider->grand_id = null;
            $slider->product_id = null;

        } else if ($request->link_by == 'sub') {

            $slider->child = $request->subcat;
            $slider->category_id = null;
            $slider->url = null;
            $slider->grand_id = null;
            $slider->product_id = null;

        } else if ($request->link_by == 'url') {

            $slider->url = $request->url;
            $slider->child = null;
            $slider->category_id = null;
            $slider->grand_id = null;
            $slider->product_id = null;

        } else if ($request->link_by == 'child') {

            $slider->grand_id = $request->child;
            $slider->url = null;
            $slider->child = null;
            $slider->category_id = null;
            $slider->product_id = null;

        } else if ($request->link_by == 'pro') {

            $slider->product_id = $request->pro;
            $slider->grand_id = null;
            $slider->url = null;
            $slider->child = null;
            $slider->category_id = null;

        } else {

            $slider->product_id = null;
            $slider->grand_id = null;
            $slider->url = null;
            $slider->child = null;
            $slider->category_id = null;
        }

        $slider->link_by = $request->link_by;
        $slider->topheading = $request->heading;
        $slider->heading = $request->subheading;
        $slider->headingtextcolor = $request->headingtextcolor;
        $slider->subheadingcolor = $request->subheadingcolor;
        $slider->buttonname = $request->buttonname;
        $slider->moredesc = $request->moredesc;
        $slider->moredesccolor = $request->moredesccolor;
        $slider->btnbgcolor = $request->btnbgcolor;
        $slider->btntextcolor = $request->btntextcolor;

        if (isset($request->status)) {
            $slider->status = '1';
        } else {
            $slider->status = '0';
        }

        if ($file = $request->file('image')) {

            if (file_exists(public_path() . '/images/slider/' . $slider->image)) {
                unlink('images/slider/' . $slider->image);
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/slider/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->fit(1247, 520, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $image, 72);

            $slider->image = $image;

        }

        $slider->save();

        return redirect()->route('slider.index')->with('added', 'Slider has been updated !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = Slider::find($id);
        $value = $cat->delete();
        if ($value) {
            session()->flash("deleted", "Slider Has Been Deleted");
            return redirect("admindesk/slider");
        }
    }

}
