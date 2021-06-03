<?php

namespace App\Http\Controllers;

use App\AddSubVariant;
use App\Config;
use App\Genral;
use App\Invoice;
use App\InvoiceDownload;
use App\Mail\OrderStatus;
use App\Notifications\ReturnOrderAdminNotification;
use App\Notifications\SellerNotification;
use App\Notifications\SMSNotifcations;
use App\OrderActivityLog;
use App\PendingPayout;
use App\ProductAttributes;
use App\ProductValues;
use App\Return_Product;
use App\User;
use Auth;
use Crypt;
use Illuminate\Http\Request;
use Mail;
use Twilosms;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class ReturnController extends Controller
{
    public function returnWindow($id)
    {
        $did = Crypt::decrypt($id);
        $order = InvoiceDownload::find($did);
        $inv_cus = Invoice::first();
        require_once 'price.php';

        if (Auth::check()) {

            if (isset($order)) {

                if ($order->status == 'delivered') {

                    $findvar = AddSubVariant::find($order->variant_id);
                    $i = 0;

                    $productname = $findvar->products->name;
                    $days = $findvar->products->returnPolicy->days;
                    $endOn = date("Y-m-d", strtotime("$order->updated_at +$days days"));
                    $today = date('Y-m-d');

                    if (isset($findvar)) {

                        /*Check if return policy applied on product*/

                        if ($findvar->products->return_avbl == '1' && $findvar->products->return_policy != 0) {

                            /*check already returned or not*/
                            if ($order->status != 'refunded' || $order->status != 'returned' || $order->status != 'canceled' || $order->status != 'cancel_request') {

                                if ($today <= $endOn) {
                                    return view('user.returnorderwindow', compact('inv_cus', 'findvar', 'order', 'productname', 'conversion_rate'));
                                } else {
                                    notify()->error('Return Policy ended !');
                                    return back();
                                }

                            } else {
                                notify()->warning('Product returned already ! Please check once again !');
                                return back();
                            }
                            /*checked*/

                        } else {
                            notify()->error('Return policy not applicable on this product !');
                            return back();
                        }

                    } else {
                        notify()->error('Variant not found !');
                        return back();
                    }

                } else {
                    notify()->warning('Order not delivered yet or already returned !');
                    return back();
                }

            } else {
                notify()->error('Order not found or already returned !');
                return back();
            }

        } else {
            notify()->error('401 | Unauthorized Action !');
            return back();
        }
    }

    public function process(Request $request, $id)
    {

        if (Auth::check()) {

            $did = Crypt::decrypt($id);
            $order = InvoiceDownload::find($did);
            $product = AddSubVariant::find($order->variant_id);
            $finalAmount = Crypt::decrypt($request->rf_am);

            if (Auth::user()->id == $order->order->user_id || Auth::user()->role == 'a') {

                if (isset($order)) {

                    if ($order->status == 'delivered') {

                        /** Remove the Pending Payout log  */

                        $payoutpending = PendingPayout::firstWhere('orderid', $order->id);

                        if (isset($payoutpending)) {
                            $payoutpending->delete();
                        }

                        /** END */

                        if ($order->order->payment_method != 'COD') {

                            if ($request->source == 'orignal') {

                                $refundlog = new Return_Product();

                                $refundlog->order_id = $order->id;
                                $refundlog->qty = $order->qty;
                                $refundlog->user_id = $order->order->user_id;
                                $refundlog->reason = $request->reason_return;
                                $refundlog->method_choosen = $request->source;
                                $refundlog->pay_mode = $order->order->payment_method;
                                $refundlog->main_order_id = $order->order->id;
                                $refundlog->amount = $finalAmount;
                                $refundlog->pickup_location = $request->pickupaddress;
                                $refundlog->status = 'initiated';
                                $refundlog->txn_id = 'REFUND_' . str_random(10);
                                $refundlog->txn_fee = null;
                                $refundlog->save();

                                $create_activity = new OrderActivityLog();

                                $create_activity->order_id = $order->order->id;
                                $create_activity->inv_id = $order->id;
                                $create_activity->user_id = $order->order->user_id;
                                $create_activity->variant_id = $order->variant_id;
                                $create_activity->log = 'Return Requested';

                                $create_activity->save();

                                /*Update status of order*/
                                InvoiceDownload::where('id', '=', $did)->update(['status' => 'return_request']);
                                /*end*/
                                $i = 0;
                                $varcount = count($product->main_attr_value);
                                $inv_cus = Invoice::first();
                                $status = 'Return Requested';
                                $inv = $order;
                                $productname = $product->products->name;
                                $rid = $refundlog->id;

                                foreach ($product->main_attr_value as $key => $orivars) {

                                    $i++;

                                    $getattrname = ProductAttributes::where('id', $key)->first()->attr_name;
                                    $getvarvalue = ProductValues::where('id', $orivars)->first();

                                    if ($i < $varcount) {
                                        if (strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {
                                            if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

                                                $var_main = $getvarvalue->values;

                                            } else {
                                                $var_main = $getvarvalue->values . $getvarvalue->unit_value;
                                            }
                                        } else {
                                            $var_main = $getvarvalue->values;
                                        }

                                    } else {

                                        if (strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {

                                            if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

                                                $var_main = $getvarvalue->values;
                                            } else {
                                                $var_main = $getvarvalue->values . $getvarvalue->unit_value;
                                            }

                                        } else {
                                            $var_main = $getvarvalue->values;
                                        }

                                    }
                                }

                                /*Send Mail to User*/

                                if (isset($order->order->user->email)) {

                                    try {
                                        Mail::to($order->order->user->email)->send(new OrderStatus($inv_cus, $inv, $status));
                                    } catch (\Swift_TransportException $e) {

                                    }

                                }

                                /*End*/

                                /*Sending notifcation to all admindesk*/
                                $get_admins = User::where('role_id', '=', 'a')->get();

                                \Notification::send($get_admins, new ReturnOrderAdminNotification($inv_cus, $productname, $var_main, $status, $order->order->order_id, $rid));

                                /*Send Notifications to vender*/
                                $venderSystem = Genral::first()->vendor_enable;

                                if ($venderSystem == 1) {

                                    $url = route('seller.return.order.show', $refundlog->id);

                                    $o = $order->order->order_id;

                                    $msg = "For Order #$inv_cus->order_prefix $o Item $productname ($var_main) has been $status";

                                    User::find($order->vender_id)->notify(new SellerNotification($url, $msg));

                                }
                                /*end*/

                                $config = Config::first();

                                if($config->sms_channel == '1'){

                                    $orderiddb = $inv_cus->order_prefix . $order->order->order_id;

                                    $smsmsg = "On order #$orderiddb return request for item $productname ($var_main) has been registered successfully with reference no. $refundlog->txn_id";

            
                                    if(env('DEFAULT_SMS_CHANNEL') == 'msg91' && $config->msg91_enable == '1'){
            
                                        try{
                                            
                                            User::find($order->order->user->id)->notify(new SMSNotifcations($smsmsg));
                    
                                        }catch(\Exception $e){
                    
                                            \Log::error('Error: '.$e->getMessage());
                    
                                        }
            
                                    }
                
                                    if(env('DEFAULT_SMS_CHANNEL') == 'twillo'){
            
                                        try{
                                            Twilosms::sendMessage($smsmsg, '+'.$order->order->user->phonecode.$order->order->user->mobile);
                                        }catch(\Exception $e){
                                            \Log::error('Twillo Error: '.$e->getMessage());
                                        }
            
                                    }
                                }

                                notify()->success('Return Requested Successully ! You will be notifed via email once we get the product and refund will proceed at same day !');

                                return redirect()->route('user.view.order', $order->order->order_id);

                            } else {

                                $refundlog = new Return_Product();

                                $refundlog->order_id = $order->id;
                                $refundlog->qty = $order->qty;
                                $refundlog->user_id = $order->order->user_id;
                                $refundlog->reason = $request->reason_return;
                                $refundlog->main_order_id = $order->order->id;
                                $refundlog->method_choosen = $request->source;
                                $refundlog->pay_mode = 'bank';
                                $refundlog->bank_id = $request->bank_id;
                                $refundlog->amount = $finalAmount;
                                $refundlog->pickup_location = $request->pickupaddress;
                                $refundlog->status = 'initiated';
                                $refundlog->txn_id = 'REFUND_' . str_random(10);
                                $refundlog->txn_fee = null;
                                $refundlog->save();

                                /*Update status of order*/
                                InvoiceDownload::where('id', '=', $did)->update(['status' => 'return_request']);
                                /*end*/

                                $i = 0;
                                $varcount = count($product->main_attr_value);
                                $inv_cus = Invoice::first();
                                $status = 'Return Requested';
                                $inv = $order;
                                $productname = $product->products->name;
                                $rid = $refundlog->id;

                                foreach ($product->main_attr_value as $key => $orivars) {

                                    $i++;

                                    $getattrname = ProductAttributes::where('id', $key)->first()->attr_name;
                                    $getvarvalue = ProductValues::where('id', $orivars)->first();

                                    if ($i < $varcount) {
                                        if (strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {
                                            if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

                                                $var_main = $getvarvalue->values;

                                            } else {
                                                $var_main = $getvarvalue->values . $getvarvalue->unit_value;
                                            }
                                        } else {
                                            $var_main = $getvarvalue->values;
                                        }

                                    } else {

                                        if (strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {

                                            if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

                                                $var_main = $getvarvalue->values;
                                            } else {
                                                $var_main = $getvarvalue->values . $getvarvalue->unit_value;
                                            }

                                        } else {
                                            $var_main = $getvarvalue->values;
                                        }

                                    }
                                }

                                /*Send Mail to User*/

                                if (isset($order->order->user->email)) {

                                    Mail::to($order->order->user->email)->send(new OrderStatus($inv_cus, $inv, $status));
                                }

                                /*End*/

                                $orderiddb = $inv_cus->order_prefix . $order->order->order_id;

                                $config = Config::first();

                                if($config->sms_channel == '1'){

                                    $smsmsg = "On order #$orderiddb return request for item $productname ($var_main) has been registered successfully with reference no. $refundlog->txn_id";

            
                                    if(env('DEFAULT_SMS_CHANNEL') == 'msg91' && $config->msg91_enable == '1'){
            
                                        try{
                                            
                                            User::find($order->order->user->id)->notify(new SMSNotifcations($smsmsg));
                    
                                        }catch(\Exception $e){
                    
                                            \Log::error('Error: '.$e->getMessage());
                    
                                        }
            
                                    }
                
                                    if(env('DEFAULT_SMS_CHANNEL') == 'twillo'){
            
                                        try{
                                            Twilosms::sendMessage($smsmsg, '+'.$order->order->user->phonecode.$order->order->user->id->mobile);
                                        }catch(\Exception $e){
                                            \Log::error('Twillo Error: '.$e->getMessage());
                                        }
            
                                    }
                                }


                                /*Sending notification to all admindesk*/
                                $get_admins = User::where('role_id', '=', 'a')->get();

                                \Notification::send($get_admins, new ReturnOrderAdminNotification($inv_cus, $productname, $var_main, $status, $order->order->order_id, $rid));

                                /*Send Notifications to vender*/
                                $venderSystem = Genral::first()->vendor_enable;

                                if ($venderSystem == 1) {

                                    $url = route('seller.return.order.show', $refundlog->id);

                                    $o = $order->order->order_id;

                                    $msg = "For Order #$inv_cus->order_prefix $o Item $productname ($var_main) has been $status";

                                    User::find($order->vender_id)->notify(new SellerNotification($url, $msg));

                                }
                                /*end*/

                                notify()->success('Return Requested Successully ! You will be notifed via email once we get the product and refund will proceed at same day !');

                                return redirect()->route('user.view.order', $order->order->order_id);
                            }

                        } else {
                            $refundlog = new Return_Product();

                            $refundlog->order_id = $order->id;
                            $refundlog->qty = $order->qty;
                            $refundlog->user_id = $order->order->user_id;
                            $refundlog->reason = $request->reason_return;
                            $refundlog->main_order_id = $order->order->id;
                            $refundlog->method_choosen = $request->source;
                            $refundlog->pay_mode = 'bank';
                            $refundlog->bank_id = $request->bank_id;
                            $refundlog->amount = $finalAmount;
                            $refundlog->pickup_location = $request->pickupaddress;
                            $refundlog->status = 'initiated';
                            $refundlog->txn_id = 'REFUND_' . str_random(10);
                            $refundlog->txn_fee = null;
                            $refundlog->save();

                            /*Update status of order*/
                            InvoiceDownload::where('id', '=', $did)->update(['status' => 'return_request']);
                            /*end*/

                            $i = 0;
                            $varcount = count($product->main_attr_value);
                            $inv_cus = Invoice::first();
                            $status = 'Return Requested';
                            $inv = $order;
                            $productname = $product->products->name;
                            $rid = $refundlog->id;

                            foreach ($product->main_attr_value as $key => $orivars) {

                                $i++;

                                $getattrname = ProductAttributes::where('id', $key)->first()->attr_name;
                                $getvarvalue = ProductValues::where('id', $orivars)->first();

                                if ($i < $varcount) {
                                    if (strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {
                                        if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

                                            $var_main = $getvarvalue->values;

                                        } else {
                                            $var_main = $getvarvalue->values . $getvarvalue->unit_value;
                                        }
                                    } else {
                                        $var_main = $getvarvalue->values;
                                    }

                                } else {

                                    if (strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {

                                        if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

                                            $var_main = $getvarvalue->values;
                                        } else {
                                            $var_main = $getvarvalue->values . $getvarvalue->unit_value;
                                        }

                                    } else {
                                        $var_main = $getvarvalue->values;
                                    }

                                }
                            }

                            /*Send Mail to User*/

                            if (isset($order->order->user->email)) {

                                Mail::to($order->order->user->email)->send(new OrderStatus($inv_cus, $inv, $status));
                            }

                            /*End*/

                            /*Sending notifcation to all admindesk*/
                            $get_admins = User::where('role_id', '=', 'a')->get();

                            \Notification::send($get_admins, new ReturnOrderAdminNotification($inv_cus, $productname, $var_main, $status, $order->order->order_id, $rid));

                            /*Send Notifications to vender*/
                            $venderSystem = Genral::first()->vendor_enable;

                            if ($venderSystem == 1) {

                                $url = route('seller.return.order.show', $refundlog->id);

                                $o = $order->order->order_id;

                                $msg = "For Order #$inv_cus->order_prefix $o Item $productname ($var_main) has been $status";

                                User::find($order->vender_id)->notify(new SellerNotification($url, $msg));

                            }
                            /*end*/

                            notify()->success('Return Requested Successully ! You will be notifed via email once we get the product and refund will proceed at same day !');

                            return redirect()->route('user.view.order', $order->order->order_id);
                        }

                    } else {
                        notify()->warning('Product is not delivered yet !');
                        return back();
                    }

                } else {
                    notify()->error('404 | Order Not found !');
                    return back();
                }

            } else {
                notify()->error('401 | Unauthorized action !');
                return back();
            }

        } else {
            notify()->error('401 | Unauthorized action !');
            return back();
        }

    }

}
