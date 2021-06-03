<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceDownload;
use App\OrderActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrackOrderController extends Controller
{
    public function view(){
        require ('price.php');
        return view('front.trackorder',compact('conversion_rate'));
    }

    public function get(Request $request){

        $validator = Validator::make($request->all(),[
            'trackingid' => 'required'
        ]);

        if($validator->fails()){

            $error = $validator->errors();

            return response()->json([
                'msg' => 'Tracking ID is required !',
                'status' => 'fail'
            ]);
        }

        $trackindid = $request->trackingid;

        $result = InvoiceDownload::firstWhere('tracking_id','=',$trackindid);

        if(!$result){
            return response()->json([
                'msg' => 'Invalid tracking id',
                'status' => 'fail'
            ]);
        }

        $price = 0;

        if($result->discount != 0){
            $price = sprintf("%.2f",($result->qty*$result->price)+$result->tax_amount+$result->shipping - $result->discount);
        }else{
            $price = sprintf("%.2f",($result->qty*$result->price)+$result->tax_amount+$result->shipping);
        }

        $address = array(
            'address' => $result->order->shippingaddress ? $result->order->shippingaddress->address : 'Not found',
            'pincode' => $result->order->shippingaddress->address ? $result->order->shippingaddress->pin_code : 'Not found',
            'contactno' => $result->order->shippingaddress->address ? $result->order->shippingaddress->phone : 'Not found',
            'city' => $result->order->shippingaddress && $result->order->shippingaddress->getcity ? $result->order->shippingaddress->getcity['name'] : 'Not found',
            'state' => $result->order->shippingaddress && $result->order->shippingaddress->getstate ? $result->order->shippingaddress->getstate['name'] : 'Not found',
            'country' => $result->order->shippingaddress && $result->order->shippingaddress->getCountry ? $result->order->shippingaddress->getCountry['nicename'] : 'Not found',
            'customer_name' => $result->order->shippingaddress ? $result->order->shippingaddress->name : 'Not found',
            'customer_email' => $result->order->shippingaddress ? $result->order->shippingaddress->email : 'Not found',
            'customer_phone' => $result->order->shippingaddress ? $result->order->shippingaddress->phone : 'Not found',
        );

        $orderPrefix = Invoice::first();

        $logs = OrderActivityLog::where('variant_id','=',$result->variant->id)->where('user_id','=',$result->order->user_id)->where('order_id','=',$result->order->id)->get();

        $actuallog = array();

        foreach($logs as $log){

            $actuallog[] = array(
                'log' => $log->log,
                'created_at' => date('d-m-Y | h:i A',strtotime($log->created_at))
            );
        }


        $orderdetails = array(
            'parent_order_id' => '#'.$orderPrefix['order_prefix'].$result->order->order_id,
            'placed_on' => date('d-m-Y | h:i A',strtotime($result->created_at)),
            'amount' => $price,
            'address' => $address,
            'orderstatus' => $result->status,
            'trackinglogs' => $actuallog
        );

        return response()->json([
            'order' => $orderdetails,
            'status' => 'success'
        ]);

    }
}
