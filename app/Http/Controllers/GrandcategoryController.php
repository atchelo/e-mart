<?php
namespace App\Http\Controllers;

use App\Grandcategory;
use Illuminate\Http\Request;
use App\Category;
use App\Subcategory;
use Intervention\Image\ImageManagerStatic as Image;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Developer : @nkit             =
=            Copyright (c) 2020            =
==========================================*/

class GrandcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cats = Grandcategory::orderBy('position','ASC')->get();
        return view('admindesk.grandcategory.index', compact('cats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent = Category::all();
        return view('admindesk.grandcategory.add', compact('parent'));
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

            'parent_id' => 'required|not_in:0', 'title' => 'required|not_in:0',
            'subcat_id' => 'required|not_in:null',

        ], [

            "title.required" => "Please enter Childcategory name"

        ]);

        $input = $request->all();
        $data = new Grandcategory;

        if ($file = $request->file('image')) {

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/grandcategory/';
            $image = time() . $file->getClientOriginalExtension();
            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });
            $optimizeImage->save($optimizePath . $image, 90);

            $input['image'] = $image;

        }

        $input['position'] = (Grandcategory::count()+1);
        $input['description'] = clean($request->description);
        $input['status']  = isset($request->status) ? "1" : "0";
        $data->create($input);
        return redirect()->route('grandcategory.index')
            ->with("added", "Child Category Has Been Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Grandcategory  $grandcategory
     * @return \Illuminate\Http\Response
     */
    public function reposition(Request $request)
    {
        if($request->ajax()){

            $posts = Grandcategory::all();
            foreach ($posts as $post) {
                foreach ($request->order as $order) {
                    if ($order['id'] == $post->id) {
                        \DB::table('grandcategories')->where('id',$post->id)->update(['position' => $order['position']]);
                    }
                }
            }
            return response()->json('Update Successfully.', 200);

        }
        
        
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Grandcategory  $grandcategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parent = Category::all();
        $subcat = Subcategory::all();
        $cat = Grandcategory::find($id);
        return view("admindesk.grandcategory.edit", compact("cat", 'parent', 'subcat'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Grandcategory  $grandcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cat = Grandcategory::findOrFail($id);

        $input = $request->all();

        if ($file = $request->file('image')) {

            if ($cat->image != '' && file_exists(public_path() . '/images/grandcategory/' . $cat->image)) {
                unlink(public_path() . '/images/grandcategory/' . $cat->image);
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/grandcategory/';
            $name = time() . $file->getClientOriginalExtension();

            $optimizeImage->resize(200, 200, function ($constraint) {
                $constraint->aspectRatio();
            });

            $optimizeImage->save($optimizePath . $name, 90);

            $input['image'] = $name;

        }

        $input['description'] = clean($request->description);

        $input['status'] =  isset($request->status) ? "1" : "0";

        $cat->update($input);

        return redirect('admindesk/grandcategory')->with('updated', 'Child Category has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Grandcategory  $grandcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getdata = Grandcategory::find($id);

        if ($getdata->image != '' && file_exists(public_path() . '/images/grandcategory/' . $getdata->image)) {
            unlink(public_path() . '/images/grandcategory/' . $getdata->image);
        }

        if (count($getdata->products) > 0)
        {
            return back()
                ->with('warning', 'Childcategory cant be deleted as its linked to products !');
        }

        $value = $getdata->delete();
        
        if ($value)
        {
            session()->flash("deleted", "Child Category Has Been Deleted");
            return redirect("admindesk/grandcategory");
        }
    }
}

