<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CategorySlider;
use Illuminate\Support\Facades\Input;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class CategorySliderController extends Controller
{
    public function get()
    {
        $slider = CategorySlider::first();
        return view('admindesk.slider.categoryslider', compact('slider'));
    }

    public function post(Request $request)
    {

        $data = CategorySlider::first();
        $input = $request->all();

        if (isset($request->status))
        {
            $input['status'] = 1;
        }
        else
        {
            $input['status'] = 0;
        }

        if (isset($data))
        {
            $data->update($input);
            return back()->with('updated', 'Category Slider has been updated !');
        }
        else
        {
            $data2 = new CategorySlider();
            $data2->create($input);
            return back()->with('added', 'Category Slider has been created !');
        }
    }
}

