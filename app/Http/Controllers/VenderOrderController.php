<?php

namespace App\Http\Controllers;

use App\Address;
use App\AddSubVariant;
use App\Affilate;
use App\Config as AppConfig;
use App\Invoice;
use App\InvoiceDownload;
use App\Mail\OrderStatus;
use App\multiCurrency;
use App\Notifications\SendOrderStatus;
use App\Notifications\SMSNotifcations;
use App\Order;
use App\OrderActivityLog;
use App\PendingPayout;
use App\ProductValues;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Mail;
use Twilosms;

class VenderOrderController extends Controller
{

    public function __construct()
    {

        $this->config = AppConfig::first();

    }

    public function codorderconfirm(Request $request, $id)
    {

        if (Auth::check()) {

            $order = Order::find($id);

            $order->payment_receive = $request->status;

            $order->save();

            if ($order) {
                return response()->json(['showstatus' => 'Updated', 'status' => true]);
            } else {
                return response()->json(['showstatus' => 'Failed', 'status' => false]);
            }

        } else {
            return back()->with('warning', 'Access Denied');
        }

    }

    public function viewOrder($id)
    {

        $order = Order::with(['orderlogs', 'cancellog', 'refundlogs', 'fullordercancellog', 'shippingaddress', 'invoices', 'user', 'invoices.variant', 'invoices.variant.variantimages', 'invoices.variant.products'])->whereHas('invoices.variant')->whereHas('invoices.variant.products')->whereHas('invoices')->whereHas('user')->where('order_id', $id)->where('status', '=', '1')->first();

        if (!isset($order)) {
            notify()->error('Order not found !');
            return redirect('/');
        }

        $query = InvoiceDownload::query();

        $x = $query->where('order_id', '=', $order->id)->where('vender_id', Auth::user()->id)->get();

        $total = 0;

        $hc = 0;

        foreach ($x as $key => $value) {
            $total = $total + ($value->qty * $value->price) + $value->gift_charge +  $value->tax_amount + $value->shipping + $value->handlingcharge;
            $hc = $hc + $value->handlingcharge;
        }

        $address = Address::findorfail($order->delivery_address);
        $actvitylogs = OrderActivityLog::where('order_id', $order->id)->orderBy('id', 'desc')->get();
        $inv_cus = Invoice::first();
        return view('seller.order.show', compact('total', 'x', 'order', 'hc', 'address', 'inv_cus', 'actvitylogs'));
    }

    public function printOrder($id)
    {
        $order = Order::with(['orderlogs', 'cancellog', 'refundlogs', 'fullordercancellog', 'shippingaddress', 'invoices', 'user', 'invoices.variant', 'invoices.variant.variantimages', 'invoices.variant.products'])->whereHas('invoices.variant')->whereHas('invoices.variant.products')->whereHas('invoices')->whereHas('user')->find($id);

        $inv_cus = Invoice::first();

        $x = InvoiceDownload::where('order_id', '=', $order->id)->where('vender_id', auth()->id())->get();

        $total = 0;
        $hc = 0;

        foreach ($x as $key => $value) {
            $total = $total + ($value->qty * $value->price) + $value->gift_charge + $value->tax_amount + $value->shipping + $value->handlingcharge;
            $hc = $hc + $value->handlingcharge;
        }

        return view('seller.order.printorder', compact('total', 'hc', 'inv_cus', 'order'));
    }

    public function printInvoice($orderID, $id)
    {
        $getInvoice = InvoiceDownload::where('id', $id)->first();
        $inv_cus = Invoice::first();
        $address = Address::findOrFail($getInvoice->order->delivery_address);
        $invSetting = Invoice::where('user_id', $getInvoice->vender_id)->first();

        return view('seller.order.printinvoice', compact('invSetting', 'address', 'getInvoice', 'inv_cus'));
    }

    public function editOrder($orderid)
    {
        $order = Order::with(['orderlogs', 'cancellog', 'refundlogs', 'fullordercancellog', 'shippingaddress', 'invoices', 'user', 'invoices.variant', 'invoices.variant.variantimages', 'invoices.variant.products'])->whereHas('invoices.variant')->whereHas('invoices.variant.products')->whereHas('invoices')->whereHas('user')->where('order_id', $orderid)->first();

        $inv_cus = Invoice::first();
        $address = Address::findOrFail($order->delivery_address);
        $actvitylogs = OrderActivityLog::where('order_id', $order->id)->orderBy('id', 'desc')->get();
        $x = InvoiceDownload::where('order_id', '=', $order->id)->where('vender_id', Auth::user()->id)->get();
        $total = 0;
        $hc = 0;

        foreach ($x as $key => $value) {
            $total = $total + ($value->qty * $value->price) + $value->gift_charge + $value->tax_amount + $value->shipping + $value->handlingcharge;
            $hc = $hc + $value->handlingcharge;
        }

        return view('seller.order.edit', compact('x', 'total', 'order', 'address', 'hc', 'inv_cus', 'actvitylogs'));
    }

    public function delete($id)
    {

        if (Auth::check()) {
            if (Auth::user()->role_id == "v" || Auth::user()->role_id == 'a') {

                $inv = Order::findOrFail($id);
                if (Auth::user()->id == $inv->vender_id || Auth::user()->role_id == 'a') {

                    $order = Order::findOrFail($id);
                    $order->status = 0;
                    $order->save();

                    return back()->with('deleted', 'Order has been deleted');

                } else {
                    return abort(404);
                }
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }
    }

    public function updateStatus(Request $request, $id)
    {

        if (Auth::check()) {

            if (Auth::user()->role_id == "v" || Auth::user()->role_id == 'a') {
                $inv = InvoiceDownload::findOrFail($id);
                if (Auth::user()->id == $inv->vender_id || Auth::user()->role_id == 'a') {

                    $newpendingpay = PendingPayout::where('orderid', '=', $inv->id)->first();

                    if ($newpendingpay) {
                        $newpendingpay->delete();

                    }

                    $inv->paid_to_seller = 'NO';
                    $inv->status = $request->status;
                    $inv->save();
                    $inv_cus = Invoice::first();
                    $status = ucfirst($request->status);

                    $create_activity = new OrderActivityLog();

                    $create_activity->order_id = $inv->order_id;
                    $create_activity->inv_id = $inv->id;
                    $create_activity->user_id = Auth::user()->id;
                    $create_activity->variant_id = $inv->variant_id;
                    $create_activity->log = $status;

                    $create_activity->save();

                    $lastlogdate = date('d-m-Y | h:i:a', strtotime($create_activity->updated_at));

                    $orivar = AddSubVariant::withTrashed()->find($create_activity->variant_id);
                    $i = 0;
                    $varcount = count($orivar->main_attr_value);
                    $productname = $orivar->products->name;

                    foreach ($orivar->main_attr_value as $key => $orivars) {

                        $i++;

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

                    /*Sending mail & Notifiation on specific event perform*/

                    $order_id = $inv->order->order_id;

                    if ($request->status == 'shipped') {

                        /*Send Mail to User*/
                        try {
                            $e = Address::findOrFail($inv->order->delivery_address)->email;
                            Mail::to($e)->send(new OrderStatus($inv_cus, $inv, $status));
                        } catch (\Swift_TransportException $e) {
                            //Throw exception if you want //
                        }
                        /*End*/

                        /*Sending Notification*/
                        User::find($inv->order->user_id)->notify(new SendOrderStatus($productname, $var_main, $status, $order_id));
                        /*End*/

                        if ($this->config->sms_channel == '1') {

                            $orderiddb = $inv_cus->order_prefix . $order_id;

                            $smsmsg = 'For Order #' . $orderiddb . ' Item ';

                            $smsmsg .= $productname . ' (' . $var_main . ')';

                            $smsmsg .= ' has been ' . ucfirst($request->status);

                            $smsmsg .= '%0a - ' . config('app.name');

                            if (env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1' && env('MSG91_AUTH_KEY') != '') {

                                try {

                                    User::find($inv->order->user_id)->notify(new SMSNotifcations($smsmsg));

                                } catch (\Exception $e) {

                                    \Log::error('Error: ' . $e->getMessage());

                                }

                            }

                            if (env('DEFAULT_SMS_CHANNEL') == 'twillo') {

                                try {
                                    Twilosms::sendMessage($smsmsg, '+' . $inv->order->user->phonecode . $inv->order->user->mobile);
                                } catch (\Exception $e) {
                                    \Log::error('Twillo Error: ' . $e->getMessage());
                                }

                            }
                        }

                    } elseif ($request->status == 'processed') {

                    } elseif ($request->status == 'pending') {

                    } elseif ($request->status == 'delivered') {

                        //Register a record in pending payout if seller system enable (not for admindesk)
                        if ($inv->seller->role_id == 'v') {

                            $from = $inv->order->paid_in_currency;

                            $defCurrency = multiCurrency::where('default_currency', '=', 1)->first();

                            $defcurrate = currency(1.00, $from = $from, $to = $defCurrency->currency->code, $format = false);

                            $actualprice = sprintf("%2.f", ($inv->price * $inv->qty) * $defcurrate);
                            $actualtax = sprintf("%2.f", ($inv->tax_amount * $inv->qty) * $defcurrate);
                            $actualshipping = sprintf("%2.f", $inv->shipping * $defcurrate);

                            $actualtotal = $actualprice + $actualtax + $actualshipping;

                            $defCurrency = multiCurrency::where('default_currency', '=', 1)->first();
                            $newpendingpay = new PendingPayout;
                            $newpendingpay->orderid = $inv->id;
                            $newpendingpay->sellerid = $inv->seller->id;
                            $newpendingpay->paidby = Auth::user()->id;
                            $newpendingpay->paid_in = $defCurrency->currency->code;
                            $newpendingpay->subtotal = $actualprice + $inv->gift_charge;
                            $newpendingpay->tax = $actualtax;
                            $newpendingpay->shipping = $actualshipping;
                            $newpendingpay->orderamount = $actualtotal + $inv->gift_charge;

                            $newpendingpay->save();

                        }

                        /**  Affialtion process */

                        $aff_system = Affilate::first();

                        if (isset($aff_system) && $aff_system->enable_affilate == 1 && $aff_system->enable_purchase == 1) {

                            $buyer = $inv->order->user;

                            if ($buyer->purchaseorder()->count() == 1) {

                                if (isset($buyer->onetimereferdata) && $buyer->onetimereferdata->procces == 0) {

                                    $buyer->onetimereferdata()->update([
                                        'procces' => '1',
                                    ]);

                                    $wallet = $buyer->onetimereferdata->fromRefered;

                                    $given_amount = $buyer->onetimereferdata->amount;

                                    if (isset($wallet->wallet) && $wallet->wallet->status == 1) {

                                        $wallet->wallet()->update([
                                            'balance' => $wallet->wallet->balance + $given_amount,
                                        ]);

                                        $wallet->wallet->wallethistory()->create([
                                            'type' => 'Credit',
                                            'log' => 'Referal bonus for first purchase by '.$buyer->name,
                                            'amount' => $given_amount,
                                            'txn_id' => str_random(8),
                                            'expire_at' => date("Y-m-d", strtotime(date('Y-m-d') . '+365 days')),
                                        ]);

                                    }

                                }

                            }

                        }

                        //End

                        /*Send Mail to User*/
                        try {
                            $e = Address::findOrFail($inv->order->delivery_address)->email;
                            Mail::to($e)->send(new OrderStatus($inv_cus, $inv, $status));
                        } catch (\Swift_TransportException $e) {
                            //Throw exception if you want //
                        }
                        /*End*/

                        /*Sending Notification*/
                        User::find($inv->order->user_id)->notify(new SendOrderStatus($productname, $var_main, $status, $order_id));
                        /*End*/

                        if ($this->config->sms_channel == '1') {

                            $orderiddb = $inv_cus->order_prefix . $order_id;

                            $smsmsg = 'For Order #' . $orderiddb . ' Item ';

                            $smsmsg .= $productname . ' (' . $var_main . ')';

                            $smsmsg .= ' has been ' . ucfirst($request->status);

                            $smsmsg .= '%0a - ' . config('app.name');

                            if (env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1' && env('MSG91_AUTH_KEY') != '') {

                                try {

                                    User::find($inv->order->user_id)->notify(new SMSNotifcations($smsmsg));

                                } catch (\Exception $e) {

                                    \Log::error('Error: ' . $e->getMessage());

                                }

                            }

                            if (env('DEFAULT_SMS_CHANNEL') == 'twillo') {

                                try {
                                    Twilosms::sendMessage($smsmsg, '+' . $inv->order->user->phonecode . $inv->order->user->mobile);
                                } catch (\Exception $e) {
                                    \Log::error('Twillo Error: ' . $e->getMessage());
                                }

                            }
                        }

                    } elseif ($request->status == 'cancel_request') {

                        $newpendingpay = PendingPayout::where('orderid', '=', $inv->id)->first();

                        if (isset($newpendingpay)) {
                            $newpendingpay->delete();
                        }

                        /*Send Mail to User*/
                        $status = 'Request for Cancellation';
                        try {
                            $e = Address::findOrFail($inv->order->delivery_address)->email;
                            Mail::to($e)->send(new OrderStatus($inv_cus, $inv, $status));
                        } catch (\Swift_TransportException $e) {
                            //Throw exception if you want //
                        }
                        /*End*/

                    } elseif ($request->status == 'canceled') {

                        $newpendingpay = PendingPayout::where('orderid', '=', $inv->id)->first();

                        if (isset($newpendingpay)) {
                            $newpendingpay->delete();
                        }

                        /*Send Mail to User*/
                        try {
                            $e = Address::findOrFail($inv->order->delivery_address)->email;
                            Mail::to($e)->send(new OrderStatus($inv_cus, $inv, $status));
                        } catch (\Swift_TransportException $e) {
                            //Throw exception if you want //
                        }
                        /*End*/

                        /*Sending Notification*/
                        User::find($inv->order->user_id)->notify(new SendOrderStatus($productname, $var_main, $status, $order_id));
                        /*End*/

                        if ($this->config->sms_channel == '1') {

                            $orderiddb = $inv_cus->order_prefix . $order_id;

                            $smsmsg = 'For Order #' . $orderiddb . ' Item ';

                            $smsmsg .= $productname . ' (' . $var_main . ')';

                            $smsmsg .= ' has been ' . ucfirst($request->status);

                            $smsmsg .= '%0a - ' . config('app.name');

                            if (env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1' && env('MSG91_AUTH_KEY') != '') {

                                try {

                                    User::find($inv->order->user_id)->notify(new SMSNotifcations($smsmsg));

                                } catch (\Exception $e) {

                                    \Log::error('Error: ' . $e->getMessage());

                                }

                            }

                            if (env('DEFAULT_SMS_CHANNEL') == 'twillo') {

                                try {
                                    Twilosms::sendMessage($smsmsg, '+' . $inv->order->user->phonecode . $inv->order->user->mobile);
                                } catch (\Exception $e) {
                                    \Log::error('Twillo Error: ' . $e->getMessage());
                                }

                            }
                        }

                    } elseif ($request->status == 'return_request') {

                        $newpendingpay = PendingPayout::where('orderid', '=', $inv->id)->first();

                        if (isset($newpendingpay)) {
                            $newpendingpay->delete();
                        }

                        /*Send Mail to User*/
                        $status = 'Request for return';

                        try {
                            $e = Address::findOrFail($inv->order->delivery_address)->email;
                            Mail::to($e)->send(new OrderStatus($inv_cus, $inv, $status));
                        } catch (\Swift_TransportException $e) {
                            //Throw exception if you want //
                        }

                        /*End*/

                    } elseif ($request->status == 'returned') {

                        $newpendingpay = PendingPayout::where('orderid', '=', $inv->id)->first();

                        if (isset($newpendingpay)) {
                            $newpendingpay->delete();
                        }

                        /*Send Mail to User*/
                        try {
                            $e = Address::findOrFail($inv->order->delivery_address)->email;
                            Mail::to($e)->send(new OrderStatus($inv_cus, $inv, $status));
                        } catch (\Swift_TransportException $e) {
                            //Throw exception if you want //
                        }
                        /*End*/

                        /*Sending Notification*/
                        User::find($inv->order->user_id)->notify(new SendOrderStatus($productname, $var_main, $status, $order_id));
                        /*End*/

                        if ($this->config->sms_channel == '1') {

                            $orderiddb = $inv_cus->order_prefix . $order_id;

                            $smsmsg = 'For order #' . $orderiddb . ' item ';

                            $smsmsg .= $productname . ' (' . $var_main . ')';

                            $smsmsg .= ' has been ' . ucfirst($request->status);

                            $smsmsg .= '%0a - ' . config('app.name');

                            if (env('DEFAULT_SMS_CHANNEL') == 'msg91' && $this->config->msg91_enable == '1' && env('MSG91_AUTH_KEY') != '') {

                                try {

                                    User::find($inv->order->user_id)->notify(new SMSNotifcations($smsmsg));

                                } catch (\Exception $e) {

                                    \Log::error('Error: ' . $e->getMessage());

                                }

                            }

                            if (env('DEFAULT_SMS_CHANNEL') == 'twillo') {

                                try {
                                    Twilosms::sendMessage($smsmsg, '+' . $inv->order->user->phonecode . $inv->order->user->mobile);
                                } catch (\Exception $e) {
                                    \Log::error('Twillo Error: ' . $e->getMessage());
                                }

                            }
                        }

                    }

                    /*end*/
                    return response()->json(['variant' => $var_main, 'proname' => $productname, 'lastlogdate' => $lastlogdate, 'dstatus' => $status, 'id' => $inv->id, 'status' => $request->status, 'invno' => $inv_cus->prefix . $inv->inv_no . $inv_cus->postfix]);

                } else {
                    return abort(404);
                }
            } else {
                return abort(404);
            }
        } else {
            return abort(404);
        }

    }
}
