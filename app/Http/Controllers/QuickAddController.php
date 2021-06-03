<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Subcategory;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class QuickAddController extends Controller
{
    public function quickAddCat(Request $request)
    {
    	$request->validate([
    		'title' => 'required',
    		'detail' => 'required',
    	]);

    	 $cat = new Category;
    	 $cat->title = $request->title;
    	 $cat->icon = $request->icon;
    	 $cat->description = clean($request->detail);

    	 if ($file = $request->file('image'))
         {

		  $name = time().$file->getClientOriginalName();

          $file->move('images/category', $name);
          
          $cat->image = $name;

       	 }

    	 $cat->status   = isset($request->status) ? "1" : "0";
    	 $cat->featured = isset($request->featured) ? "1" : "0";
         $cat->position = (Category::count()+1);
    	 $cat->save();
    	 return back()->with('added','Category Added Succesfully !');
    }

    public function quickAddSub(Request $request)
    {
    	$request->validate([
    		'title' => 'required',
    		'detail' => 'required',
    	]);

    	 $cat = new Subcategory;
    	 $cat->parent_cat = $request->category;
    	 $cat->title = $request->title;
    	 $cat->icon = $request->icon;
    	 $cat->description = clean($request->detail);
         $cat->position = (Subcategory::count()+1);

    	 if ($file = $request->file('image'))
         {

		  $name = time().$file->getClientOriginalName();

          $file->move('images/subcategory', $name);
          
          $cat->image = $name;

       	 }

    	 $cat->status   = isset($request->status) ? "1" : "0";
    	 $cat->featured = isset($request->featured) ? "1" : "0";

    	 $cat->save();
    	 return back()->with('added','Subcategory Added Succesfully !');
    }
}
