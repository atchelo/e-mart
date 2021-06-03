<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use App\Brand;
use Avatar;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class SellerBrandController extends Controller
{
    public function index(Request $request){

      $brands = \DB::table('brands')->select('brands.id','brands.name','brands.image','brands.status')->get();

      if($request->ajax()){
        return DataTables::of($brands)
              ->addIndexColumn()
              ->addColumn('image',function($row){
                    $photo = @file_get_contents('images/brands/'.$row->image);
                    if($photo){
                        $image = '<img width="50px" height="70px" src="' . url("images/brands/" . $row->image) . '"/>';
                    }else{
                        $image = '<img width="50px" height="70px" src="' . Avatar::create($row->name)->toBase64() . '"/>';
                    }
                    return $image;
              })
              ->editColumn('status',function($row){
              		
              		if($row->status == 1){
              			$html = '<button class="btn btn-sm btn-success">Active</button>';
              		}else{
              			$html = '<button class="btn btn-sm btn-danger">Deactive</button>';
              		}

              		return $html;


              })
              ->rawColumns(['image','status'])
              ->make(true);
       }

    	return view('seller.brand.index');
    }

    public function requestStore(Request $request){

       

        $input = $request->all();

        $brand = new Brand;

        if($file = $request->file('image'))
        {
            
            $name = time().$file->getClientOriginalName();
            $file->move('images/brands', $name);
            $input['image'] = $name;
        }

        if($file = $request->file('brand_proof'))
        {
            
            $name = time().$file->getClientOriginalName();
            $file->move('brandproof', $name);
            $input['brand_proof'] = $name;
        }

        $input['status'] = "0";
        $input['is_requested'] = '1';

        

        $brand->create($input);

        

        return back()->with('added','Brand Requested Successfully !');



    }
}
