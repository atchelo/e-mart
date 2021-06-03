<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Return_Product;
use Auth;
use App\AddSubVariant;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class SellerReturnController extends Controller
{
    public function index(){

    	$inv_cus = Invoice::first();
    	$allorders = Return_Product::orderBy('id','desc')->get();
    	$sellerorders = collect();
    	$unreadorders = collect();
    	$readedorders = collect();

    	foreach ($allorders as $key => $order) {
    		if(Auth::user()->id == $order->getorder->vender_id){
    			$sellerorders->push($order);
    		}
    	}

    	foreach ($sellerorders as $key => $order) {
    		if($order->status == 'initiated' && isset($order->getorder->order)){
    			$unreadorders->push($order);
    		}
    	}

    	foreach ($sellerorders as $key => $order) {
    		if($order->status != 'initiated' && isset($order->getorder->order)){
    			$readedorders->push($order);
    		}
    	}
    	
        $countP = count($unreadorders);
    	$countC = count($readedorders);
    	return view('seller.order.returnorders.index',compact('sellerorders','countP','countC','inv_cus'));
    }

    public function show($id){

    	$rorder = Return_Product::find($id);
        
        if (isset($rorder)) {

            $findvar = AddSubVariant::findorfail($rorder->getorder->variant_id);
            $inv_cus = Invoice::first();
            $orderid = $rorder->getorder->order->order_id;

            if($rorder->getorder->vender_id != Auth::user()->id){

                return back()->with('warning','You cannot view other seller orders!');

            }else{

                if($rorder->status != 'initiated'){
                    return back()->with('warning','Oops ! Refund already initiated !');
                }

                return view('seller.order.returnorders.show',compact('rorder','orderid','inv_cus','findvar'));
            }

        }else{
            return redirect()->route('seller.return.index')->with('warning','404 Return order not found !');
        }   
    }

    public function detail($id)
    {
        $order = Return_Product::find($id);
       
        if (isset($order)) {

             $inv_cus = Invoice::first();
             $orderid = $order->getorder->order->order_id;
             $findvar = AddSubVariant::findorfail($order->getorder->variant_id);
            
            if($order->status != 'initiated'){
                 if($findvar->vender_id == Auth::user()->id){
                    return back()->with('warning','You cannot view other sellers orders');
                 }else{
                    return view('seller.order.returnorders.detail',compact('findvar','inv_cus','order','orderid'));
                 }
            }else {
                return back()->with('warning','Order not refunded yet !');
            }

        }else {
            return redirect()->route('seller.return.index')->with('warning','404 Not found !');
        }

       
    }
}
