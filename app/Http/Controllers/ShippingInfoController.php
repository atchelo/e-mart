<?php

namespace App\Http\Controllers;

use App\Category;
use App\Grandcategory;
use Illuminate\Http\Request;
use App\Shipping;
use App\ShippingWeight;
use App\Subcategory;
use Session;
use DataTables;
use Avatar;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class ShippingInfoController extends Controller
{
    public function getinfo(){
    	$shippings = Shipping::all();
    	$sw = ShippingWeight::first();
    	return view('seller.shipping.index',compact('shippings','sw'));
    }

    public function getcategories(Request $request){

        $cat = Category::where('status','1');

    	if($request->ajax()){
    		return DataTables::of($cat)->addIndexColumn()->addColumn('thumbnail', function ($row)
            {
                $image = @file_get_contents('images/category/'.$row->thumbnail);

                if($image){
                    $image = '<img width="50px" height="70px" src="' . url("images/category/" . $row->thumbnail) . '"/>';
                }else{
                    $image = '<img width="50px" height="70px" src="' . Avatar::create($row->title)->toBase64() . '"/>';
                }
                
                return $image;

            })->addColumn('name', function($row){
            	return $row->title ?? '-';
            })
            ->addColumn('details', function($row){
            	return strip_tags($row->details ?? '-');
            })
            ->rawColumns(['thumbnail', 'name', 'details'])
            ->make(true);
    	}


            return view('seller.category.cat');
    }

    public function getsubcategories(Request $request){
    

        $cat = Subcategory::with('category');

    	if($request->ajax()){
    		return DataTables::of($cat)->addIndexColumn()->addColumn('thumbnail', function ($row)
            {
                $image = @file_get_contents('images/category/'.$row->thumbnail);

                if($image){
                    $image = '<img width="50px" height="70px" src="' . url("images/category/" . $row->thumbnail) . '"/>';
                }else{
                    $image = '<img width="50px" height="70px" src="' . Avatar::create($row->title)->toBase64() . '"/>';
                }
                
                return $image;

            })->addColumn('name', function($row){
            	return $row->title;
            })
            ->addColumn('parentcat', function($row){
            	return isset($row->category) ? $row->category->title : 'Not found !';
            })
            ->addColumn('details', function($row){
            	return strip_tags($row->details ?? '-');
            })
            ->rawColumns(['thumbnail', 'name', 'parentcat', 'details'])
            ->make(true);
    	}


            return view('seller.category.sub');
    }

    public function getchildcategories(Request $request){

    	$lang = Session::get('changed_language');
    	$cat = \DB::table('grandcategories')
    			->join('subcategories','grandcategories.subcat_id','=','subcategories.id')
    			->join('categories','categories.id','=','grandcategories.parent_id')
    			->select("grandcategories.title->$lang AS title","grandcategories.description->$lang AS details",'grandcategories.image as thumbnail',"categories.title->$lang AS ptitle","subcategories.title->$lang AS subtitle")
    			->where('grandcategories.status','=','1')
    			->where('subcategories.status','=','1')
    			->where('categories.status','=','1')->get();

        $cat = Grandcategory::with(['subcategory','category']);

    	if($request->ajax()){
    		return DataTables::of($cat)->addIndexColumn()->addColumn('thumbnail', function ($row)
            {
                $image = @file_get_contents('images/category/'.$row->thumbnail);

                if($image){
                    $image = '<img width="50px" height="70px" src="' . url("images/category/" . $row->thumbnail) . '"/>';
                }else{
                    $image = '<img width="50px" height="70px" src="' . Avatar::create($row->title)->toBase64() . '"/>';
                }
                
                return $image;

            })->addColumn('name', function($row){
            	return $row->title;
            })
            ->addColumn('sub', function($row){
            	return isset($row->subcategory) ? $row->title : 'Subcategory not found !';
            })
            ->addColumn('main', function($row){
            	return isset($row->category) ? $row->title : 'Subcategory not found !';
            })
            ->addColumn('details', function($row){
            	return strip_tags($row->details ?? '-');
            })
            ->rawColumns(['thumbnail', 'name', 'sub', 'main', 'details'])
            ->make(true);
    	}


            return view('seller.category.child');
    }
}
