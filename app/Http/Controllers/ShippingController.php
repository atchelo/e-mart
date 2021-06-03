<?php

namespace App\Http\Controllers;

use App\Shipping;
use Illuminate\Http\Request;
use yajra\Datatables\Datatables;
use Session;
use View;
use DB;
use Auth;
use App\Order;
use App\Product;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
       
        $shippings = Shipping::all();
        return view("admindesk.shipping.index",compact("shippings"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admindesk.shipping.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         

        $data = $this->validate($request,[
            "name"=>"required",
            
            
        ],[

            "name.required"=>"Shipping Fild is Required",
            
          ]);

        $input = $request->all(); 
        $data = shipping::create($input);
        $data->save();
        return back()->with('category_message', 'Shipping has been updated'); 
    }
    

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
        
        
        $shipping = Shipping::findOrFail($id);

        if($shipping->name == 'Shipping Price')
        {
            return redirect('admindesk/shipping-price-weight');
        }
        else
        {
            return view("admindesk.shipping.edit",compact("shipping"));
        }
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
         
        
        

        
          $shipping = shipping::findOrFail($id);
          $input = $request->all();  
          $shipping->update($input);

          return redirect('admindesk/shipping')->with('category_message', 'Shipping has been updated');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $daa = new Shipping;
         $obj = $daa->findorFail($id);
         //print_r($obj); die;
         $value = $obj->delete();
         if($value){
            session()->flash("category_message","Shipping Has Been deleted");
             return redirect("admindesk/shipping");
         }
    }


    public function shipping(Request $request){
       
         $id = $request['catId'];
        DB::table('shippings')->update(['default_status' => '0']);
       
        $UpdateDetails = Shipping::where('id', '=',  $id)->first();


        $UpdateDetails->default_status = "1";
        $UpdateDetails->save();

        if($id == 1){
           Product::query()->where('free_shipping','=','0')->update(['free_shipping' => '1','shipping_id' => NULL]);
        }else{
            Product::query()->where('free_shipping','=','0')->update(['free_shipping' => '0' ,'shipping_id' => $id]);
        }
        
        Session::flash('success', 'Default shipping method has been changed now.');
        return View::make('admindesk.shipping.message');
    }


}