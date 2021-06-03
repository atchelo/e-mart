<?php

namespace App\Http\Controllers;

use App\Subcategory;
use App\Category;
use Illuminate\Http\Request;
use Image;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index()
    {
        $subcategory = Subcategory::orderBy('position','ASC')->get();

        return view('admindesk.category.subcategory.index',compact("subcategory"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent = Category::all();

        return view("admindesk.category.subcategory.create",compact("parent"));
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
            
            "title"=>"required",
            

        ],[

            "title.required"=>"Subcategory Name is needed",
            
          ]);

        $data  = new Subcategory;
        $input = $request->all();

        if(isset($request->status)){
           $input['status'] = "1";
        }else{
            $input['status'] = "0";
        }

        
        if ($file = $request->file('image')) 
         {
            
          $optimizeImage = Image::make($file);
          $optimizePath = public_path().'/images/subcategory/';
          $image = time().$file->getClientOriginalExtension();
          $optimizeImage->resize(200, 200, function ($constraint) {
            $constraint->aspectRatio();
        });
          $optimizeImage->save($optimizePath.$image, 90);

          $input['image'] = $image;

           
         }

         $input['position'] = (Subcategory::count()+1);

         $input['description'] = clean($request->description);

         $data->create($input);
        
        return redirect()->route('subcategory.index')->with("added","Sub Category Has Been Added");
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function reposition(Request $request)
    {
        if($request->ajax()){

            $posts = Subcategory::all();
            foreach ($posts as $post) {
                foreach ($request->order as $order) {
                    if ($order['id'] == $post->id) {
                        \DB::table('subcategories')->where('id',$post->id)->update(['position' => $order['position']]);
                    }
                }
            }
            return response()->json('Update Successfully.', 200);

        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parent = Category::all();

        $cat = Subcategory::findOrFail($id);
        return view("admindesk.category.subcategory.edit",compact("cat","parent"));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $subcat = Subcategory::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'parent_cat' => 'required'
        ],[
            'parent_cat.required' => 'Please Select Parent Category'
        ]);

        $subcat->title = $request->title;
        $subcat->parent_cat = $request->parent_cat;
        $subcat->description = clean($request->description);
        $subcat->icon = $request->icon;
            
        if(isset($request->featured)){
            $subcat->featured = 1;
        }else{
            $subcat->featured = 0;
        }

        if(isset($request->status)){
            $subcat->status = 1;
        }else{
            $subcat->status = 0;
        }

        if ($file = $request->file('image')) {

            if ($subcat->image != '' && file_exists(public_path() . '/images/subcategory/' . $subcat->image)) {
                unlink(public_path() . '/images/subcategory/' . $subcat->image);
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/subcategory/';
            $name = time() . $file->getClientOriginalExtension();
            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $name, 90);

            $subcat->image = $name;

        }

        $subcat->save();

        return redirect()->route('subcategory.index')->with("updated","Subcategory Has Been Updated !");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Subcategory::find($id);


        if(count($category->products)>0){
            return back()->with('warning','Subcategory cant be deleted as its linked to products !');
        }

        if ($category->image != '' && file_exists(public_path() . '/images/subcategory/' . $category->image)) {
            unlink(public_path() . '/images/subcategory/' . $category->image);
        }

        $value = $category->delete();

        if($value){
            session()->flash("deleted","Subcategory Has Been Deleted !");
            return redirect("admindesk/subcategory");
        }
    }
}
