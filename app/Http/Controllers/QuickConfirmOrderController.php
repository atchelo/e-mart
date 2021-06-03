<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail;
use Session;
use App\Order;
use App\InvoiceDownload;
use App\Invoice;
use App\OrderActivityLog;
use Auth;
use App\PendingPayout;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class QuickConfirmOrderController extends Controller
{
    public function quickconfirmfullorder($orderid, Request $request){
    	
    	$order = Order::find($orderid);

    	if(isset($order)){

    		foreach ($order->invoices as $key => $invoice) {

    			  $inv = InvoiceDownload::findOrFail($invoice->id);

    			  $inv->status = $request->status;
	              $inv->save();
	              $inv_cus = Invoice::first();
	              $status = ucfirst($request->status);

    			  $newpendingpay = PendingPayout::where('orderid','=',$inv->id)->first();

                  if(isset($newpendingpay)){
                        $newpendingpay->delete();
                  }

                  $create_activity = new OrderActivityLog();

	              $create_activity->order_id = $inv->order_id;
	              $create_activity->inv_id   = $inv->id;
	              $create_activity->user_id  = Auth::user()->id;
	              $create_activity->variant_id = $inv->variant_id;
	              $create_activity->log      = $status;

	              $create_activity->save();

	              
    		}

    		return back()->with('added','Order confirmed successfully !');

    	}else{
    		return back()->with('delete','Order not found or deleted !');
    	}

    }
}
