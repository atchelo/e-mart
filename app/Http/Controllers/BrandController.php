<?php
namespace App\Http\Controllers;

use App\Brand;
use Image;
use Illuminate\Http\Request;
use DataTables;
use Avatar;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $brands = \DB::table('brands')->select('brands.id', 'brands.name', 'brands.image', 'brands.status')
            ->get();

        if ($request->ajax())
        {
            return DataTables::of($brands)->addIndexColumn()->addColumn('image', function ($row)
            {
                $photo = @file_get_contents('images/brands/'.$row->image);

                if($photo){
                    $image = '<img width="50px" height="70px" src="' . url("images/brands/" . $row->image) . '"/>';
                }else{
                    $image = '<img width="50px" height="70px" src="' . Avatar::create($row->name)->toBase64() . '"/>';
                }
                
                return $image;
            })->editColumn('status', 'admindesk.brand.status')
                ->editColumn('action', 'admindesk.brand.action')
                ->rawColumns(['image', 'status', 'action'])
                ->make(true);
        }

        return view('admindesk.brand.index', compact('brands'));

    }

    public function requestedbrands()
    {
        $brands = Brand::where('is_requested', '=', '1')->where('status', '0')
            ->orderBy('id', 'DESC')
            ->get();
        return view('admindesk.brand.requestedbrand', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admindesk.brand.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $this->validate($request, ["name" => "required|unique:brands,name",

        ], [

        "name.required" => "Brand Name is Required",

        ]);

        $input = $request->all();

        if ($file = $request->file('image'))
        {

            $img = Image::make($file->path());
            $destinationPath = public_path() . '/images/brands/';
            $image = time() . $file->getClientOriginalName();
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($destinationPath . $image);

            $input['image'] = $image;
        }

        if(isset($request->status)){
            $input['status'] = '1';
        }else{
            $input['status'] = '0';
        }

        if(isset($request->show_image)){
            $input['show_image'] = '1';
        }else{
            $input['show_image'] = '0';
        }

        $data = Brand::create($input);

        return back()
            ->with("added", "Brand Has Been Created !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $brand = Brand::findOrFail($id);
        return view("admindesk.brand.edit", compact("brand"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $this->validate($request, [

        "name" => "required|unique:brands,name,$id",

        ], [

        "name.required" => "Brand Name is required",

        ]);

        $brand = Brand::findOrFail($id);

        $input = $request->all();

        if ($file = $request->file('image'))
        {

            if ($brand->image != null)
            {

                if (file_exists(public_path() . '/images/brands/' . $brand->image))
                {
                    unlink(public_path() . '/images/brands/' . $brand->image);
                }

            }

            $img = Image::make($file);
            $destinationPath = public_path() . '/images/brands/';
            $name = time() . $file->getClientOriginalName();

            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($destinationPath . $name);

            $input['image'] = $name;

        }

        if(isset($request->status)){
            $input['status'] = '1';
        }else{
            $input['status'] = '0';
        }

        if(isset($request->show_image)){
            $input['show_image'] = '1';
        }else{
            $input['show_image'] = '0';
        }

        $brand->update($input);

        return redirect('admindesk/brand')->with('updated', 'Brand has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $obj = Brand::findorFail($id);

        if ($obj
            ->products
            ->count() < 1)
        {
            if ($obj->image != null)
            {
                $image_file = @file_get_contents(public_path() . '/images/brand/' . $obj->image);

                if ($image_file)
                {
                    unlink(public_path() . '/images/brand/' . $obj->image);
                }
            }
            $value = $obj->delete();
            if ($value)
            {
                session()->flash("deleted", "Brand Has Been deleted");
                return redirect("admindesk/brand");
            }
        }
        else
        {
            return back()
                ->with('warning', 'Brand cannot be deleted as its linked to some products !');
        }

    }

}

