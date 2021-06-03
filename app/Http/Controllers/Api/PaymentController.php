<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\AddSubVariant;
use App\BillingAddress;
use App\Cart;
use App\Config;
use App\Coupan;
use App\Genral;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Controller;
use App\Invoice;
use App\InvoiceDownload;
use App\Mail\OrderMail;
use App\Notifications\OrderNotification;
use App\Notifications\SellerNotification;
use App\Notifications\SMSNotifcations;
use App\Notifications\UserOrderNotification;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;
use Twilosms;

class PaymentController extends Controller
{
    public function getPaymentID(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'required',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('amount')) {
                return response()->json(['msg' => $errors->first('amount'), 'status' => 'fail']);
            }
        }

        $api = new Api(env('RAZOR_PAY_KEY'), env('RAZOR_PAY_SECRET'));

        $order = $api->order->create(array(
            'receipt' => uniqid(),
            'amount' => $request->amount,
            'currency' => 'INR',
        )
        );

        $result = $api->order->fetch($order->id);

        $orderId = $result['id']; // Get the created Order ID

        $order = $api->order->fetch($orderId);

        return response()->json([

            'amount' => $order['amount'] / 100,
            'order_id' => $order['id'],

        ]);

    }

    public function confirmOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'subtotal' => 'required',
            'amount' => 'required',
            'payment_method' => 'required|string',
            'txn_id' => 'required|string',
            'currency' => 'required|string|max:3|min:3',
            'handlingcharge' => 'required',
            'address_id' => 'required',
            'same_as' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('amount')) {
                return response()->json(['msg' => $errors->first('amount'), 'status' => 'fail']);
            }

            if ($errors->first('payment_method')) {
                return response()->json(['msg' => $errors->first('payment_method'), 'status' => 'fail']);
            }

            if ($errors->first('txn_id')) {
                return response()->json(['msg' => $errors->first('txn_id'), 'status' => 'fail']);
            }

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

            if ($errors->first('subtotal')) {
                return response()->json(['msg' => $errors->first('subtotal'), 'status' => 'fail']);
            }

            if ($errors->first('handlingcharge')) {
                return response()->json(['msg' => $errors->first('handlingcharge'), 'status' => 'fail']);
            }

            if ($errors->first('address_id')) {
                return response()->json(['msg' => $errors->first('address_id'), 'status' => 'fail']);
            }

            

            if ($errors->first('same_as')) {
                return response()->json(['msg' => $errors->first('same_as'), 'status' => 'fail']);
            }
        }

        $total = 0;

        $rates = new CurrencyController;

        $same = $request->same_as;

        $rate = $rates->fetchRates($request->currency)->getData();

        $conversion_rate = $rate->exchange_rate;

        $address = Address::find($request->address_id);

        if(!$address){

            return response()->json([
                'message' => 'Address not found !',
                'status' => 'fail'
            ]);
        }


        if($request->same_as == 0){

            $validator = Validator::make($request->all(),[
                'billing_id' => 'required',
            ]);

            if ($validator->fails()) {

                $errors = $validator->errors();

                if ($errors->first('billing_id')) {
                    return response()->json(['msg' => $errors->first('billing_id'), 'status' => 'fail']);
                }
            }

            $billing_address = BillingAddress::find($request->billing_id);

            if(!$billing_address){
                return response()->json([
                    'message' => 'Billing address not found !',
                    'status' => 'fail'
                ]);
            }

            $billing_address_full = array(
                'firstname' => $billing_address->firstname,
                'email' => $billing_address->email,
                'mobile' => (int) $billing_address->mobile,
                'address' => strip_tags($billing_address->address),
                'country_id' => $billing_address->countiess ? $billing_address->countiess->id : null,
                'state' => $billing_address->states ? $billing_address->states->id : null,
                'city' => $billing_address->cities ? $billing_address->cities->id : null,
                'pincode' => (int) $billing_address->pincode,
            );

        }else{

            $billing_address = $address;

            $billing_address_full = array(
                'firstname' => $address->name,
                'email' => $address->email,
                'mobile' => $address->phone,
                'address' => $address->address,
                'country_id' => $address->getCountry ? $address->getCountry->id : null,
                'state' => $address->getstate ? $address->getstate->id : null,
                'city' => $address->getcity ? $address->getcity->id : null,
                'pincode' => $address->pin_code,
            );


        }


        foreach (auth()->user()->cart as $key => $cart) {

            $taxinfo = new OrderController;

          


            if ($cart->product->tax_r != null && $cart->product->tax == 0) {

                if ($cart->ori_offer_price != 0) {
                    //get per product tax amount
                    $p = 100;
                    $taxrate_db = $cart->product->tax_r;
                    $vp = $p + $taxrate_db;
                    $taxAmnt = $cart->product->offer_price / $vp * $taxrate_db;
                    $taxAmnt = sprintf("%.2f", $taxAmnt);
                    $price = ($cart->ori_offer_price - $taxAmnt) * $cart->qty;

                } else {

                    $p = 100;
                    $taxrate_db = $cart->product->tax_r;
                    $vp = $p + $taxrate_db;
                    $taxAmnt = $cart->product->price / $vp * $taxrate_db;

                    $taxAmnt = sprintf("%.2f", $taxAmnt);

                    $price = ($cart->ori_price - $taxAmnt) * $cart->qty;
                }

            } else {

                if ($cart->semi_total != 0) {

                    $price = $cart->semi_total;

                } else {

                    $price = $cart->price_total;

                }
            }

            $total = $total + $price;

        }

       
        $total = sprintf("%.2f",$total * $conversion_rate);


        if (round($request->subtotal, 2) != $total) {

            return response()->json([
                'msg' => 'Payment has been modifed !',
                'status' => 'fail'
            ]);


        }

        DB::beginTransaction();


        $order_id = uniqid();

        $amount = round($request->amount, 2);

        $hc = $request->handlingcharge;

        $user = auth()->user();
        $cart = auth()->user()->cart;
        $invno = 0;
        $venderarray = array();
        $qty_total = 0;
        $pro_id = array();
        $mainproid = array();
        $total_tax = 0;
        $total_shipping = 0;
        $cart_table = Cart::where('user_id', $user->id)->get();

        $txn_id = $request->txn_id;

        

        if (Cart::isCoupanApplied() == '1') {

            $discount = Cart::getDiscount();

        } else {

            $discount = 0;
        }

        foreach (auth()->user()->cart as $key => $cart) {

            array_push($venderarray, $cart->vender_id);

            $qty_total = $qty_total + $cart->qty;

            array_push($pro_id, $cart->variant_id);

            array_push($mainproid, $cart->pro_id);

            $total_tax = $total_tax + $cart->tax_amount;

            $total_shipping = $total_shipping + $cart->shipping;

        }

        $total_shipping = sprintf("%.2f", $total_shipping * $conversion_rate);

        $venderarray = array_unique($venderarray);
        $hc = round($hc, 2);

        $neworder = new Order();
        $neworder->order_id = $order_id;
        $neworder->qty_total = $qty_total;
        $neworder->user_id = auth()->user()->id;
        $neworder->delivery_address = $address->id;
        $neworder->billing_address = $billing_address_full;
        $neworder->order_total = $amount - $hc;
        $neworder->tax_amount = round($total_tax, 2);
        $neworder->shipping = round($total_shipping, 2);
        $neworder->status = '1';
        $neworder->coupon = Cart::getCoupanDetail() ? Cart::getCoupanDetail()->code : null;
        $neworder->paid_in = $rate->font_awesome_symbol;
        $neworder->vender_ids = $venderarray;
        $neworder->transaction_id = $txn_id;
        $neworder->payment_receive = 'yes';
        $neworder->payment_method = ucfirst($request->payment_method);
        $neworder->paid_in_currency = $rate->code;
        $neworder->pro_id = $pro_id;
        $neworder->discount = sprintf("%.2f", $discount * $conversion_rate);
        $neworder->distype = Cart::getCoupanDetail() ? Cart::getCoupanDetail()->link_by : null;
        $neworder->main_pro_id = $mainproid;
        $neworder->handlingcharge = $hc;
        $neworder->created_at = now();

        $neworder->save();

        #Getting Invoice Prefix
            $invStart = Invoice::first()->inv_start;
        #end

        #Count order
            $cart_table2 = Cart::where('user_id', Auth::user()->id)->orderBy('vender_id', 'ASC')->get();

        #Creating Invoice
            foreach ($cart_table2 as $key => $invcart) {

                $tax = $taxinfo->getTaxInfo($invcart->product, $rate, $address, $billing_address, $invcart,$same);


                $lastinvoices = InvoiceDownload::where('order_id', $neworder->id)->get();

                $lastinvoicerow = InvoiceDownload::orderBy('id', 'desc')->first();

                if (count($lastinvoices) > 0) {

                    foreach ($lastinvoices as $last) {
                        
                        if ($invcart->vender_id == $last->vender_id) {

                            $invno = $last->inv_no;

                        } else {

                            $invno = $last->inv_no;
                            $invno = $invno + 1;
                        }
                    }

                } else {

                    if ($lastinvoicerow) {
                        $invno = $lastinvoicerow->inv_no + 1;
                    } else {
                        $invno = $invStart;
                    }

                }

                $findvariant = AddSubVariant::find($invcart->variant_id);
                $price = 0;

                /*Handling charge per item count*/
                $hcsetting = Genral::first();

                if ($hcsetting->chargeterm == 'pi') {

                    $perhc = $hc / count($cart_table2);

                } else {

                    $perhc = $hc / count($cart_table2);

                }
                /*END*/

                if ($invcart->semi_total != 0) {

                    if ($findvariant->products->tax_r != '') {

                        $p = 100;
                        $taxrate_db = $findvariant->products->tax_r;
                        $vp = $p + $taxrate_db;
                        $tam = $findvariant->products->offer_price / $vp * $taxrate_db;
                        $tam = sprintf("%.2f", $tam);

                        $price = sprintf("%.2f", ($invcart->ori_offer_price - $tam) * $conversion_rate);
                    } else {
                        $price = $invcart->ori_offer_price * $conversion_rate;
                        $price = sprintf("%.2f", $price);
                    }

                } else {

                    if ($findvariant->products->tax_r != '') {

                        $p = 100;

                        $taxrate_db = $findvariant->products->tax_r;

                        $vp = $p + $taxrate_db;

                        $tam = $findvariant->products->vender_price / $vp * $taxrate_db;

                        $tam = sprintf("%.2f", $tam);

                        $price = sprintf("%.2f", ($invcart->ori_price - $tam) * $conversion_rate);

                    } else {
                        $price = $invcart->ori_price * $conversion_rate;
                        $price = sprintf("%.2f", $price);

                    }
                }

                $newInvoice = new InvoiceDownload();
                $newInvoice->order_id = $neworder->id;
                $newInvoice->inv_no = $invno;
                $newInvoice->qty = $invcart->qty;
                $newInvoice->status = 'pending';
                $newInvoice->local_pick = $invcart->ship_type;
                $newInvoice->variant_id = $invcart->variant_id;
                $newInvoice->vender_id = $invcart->vender_id;
                $newInvoice->price = $price;
                $newInvoice->tax_amount = $invcart->tax_amount;
                $newInvoice->igst = isset($tax) && $tax['tax_type'] == 'single' ? $tax['amount']['amount1'] : null;
                $newInvoice->sgst = isset($tax) && $tax['tax_type'] == 'multiple' ? $tax['amount']['amount1'] : null;
                $newInvoice->cgst = isset($tax) && $tax['tax_type'] == 'multiple' ? $tax['amount']['amount2'] : null;
                $newInvoice->shipping = round($invcart->shipping * $conversion_rate, 2);
                $newInvoice->discount = round($invcart->disamount * $conversion_rate, 2);
                $newInvoice->handlingcharge = $perhc;
                $newInvoice->tracking_id = InvoiceDownload::createTrackingID();
                if ($invcart->product->vender->role_id == 'v') {
                    $newInvoice->paid_to_seller = 'NO';
                }

                $newInvoice->save();

            }
        #end

            if (Cart::isCoupanApplied() == '1' && Cart::getCoupanDetail()) {
                // Coupon applied //
                $c = Coupan::find(Cart::getCoupanDetail()->id);

                if (isset($c)) {
                    $c->maxusage = $c->maxusage - 1;
                    $c->save();
                }
            }

        //end //

        foreach ($cart_table as $carts) {

            $id = $carts->variant_id;
            $variant = AddSubVariant::find($id);

            if (isset($variant)) {

                $used = $variant->stock - $carts->qty;
                DB::table('add_sub_variants')
                    ->where('id', $id)->update(['stock' => $used]);

            }

        }

        $inv_cus = Invoice::first();
        
        $orderiddb = $inv_cus->order_prefix . $order_id;

        $user->notify(new UserOrderNotification($order_id, $orderiddb));
        $get_admins = User::where('role_id', '=', 'a')->get();

        /*Sending notification to all admindesk*/
        \Notification::send($get_admins, new OrderNotification($order_id, $orderiddb));

        /*Send notifcation to vender*/
        $vender_system = Genral::first()->vendor_enable;

        /*if vender system enable and user role is not admindesk*/
        if ($vender_system == 1) {

            $msg = "New Order $orderiddb Received !";
            $url = route('seller.view.order', $order_id);

            foreach ($venderarray as $key => $vender) {
                $v = User::find($vender);
                if ($v->role_id == 'v') {
                    $v->notify(new SellerNotification($url, $msg));
                }
            }

        }
        /*end*/
        Session::forget('page-reloaded');
        /*Send Mail to User*/
        try {

            $e = Address::find($neworder->delivery_address);

            $paidcurrency = $rate->code;

            if (isset($e) && $e->email) {
                Mail::to($e->email)->send(new OrderMail($neworder, $inv_cus, $paidcurrency));
            }

        } catch (\Exception $e) {
            \Log::info('Mail can\'t sent when create order');
        }

        $config = Config::first();

        if ($config->sms_channel == '1') {

            $smsmsg = 'Your order #' . $orderiddb . ' placed successfully ! You can view your order by visiting here:%0a';

            $smsurl = route('user.view.order', $neworder->order_id);

            $smsmsg .= $smsurl . '%0a%0a';

            $smsmsg .= 'Thanks for shopping with us - ' . config('app.name');

            if (env('DEFAULT_SMS_CHANNEL') == 'msg91' && $config->msg91_enable == '1') {

                try {

                    $user->notify(new SMSNotifcations($smsmsg));

                } catch (\Exception $e) {

                    \Log::error('Error: ' . $e->getMessage());

                }

            }

            if (env('DEFAULT_SMS_CHANNEL') == 'twillo') {

                try {
                    Twilosms::sendMessage($smsmsg, '+' . Auth::user()->phonecode . Auth::user()->mobile);
                } catch (\Exception $e) {
                    \Log::error('Twillo Error: ' . $e->getMessage());
                }

            }
        }

        Session::forget('cart');
        Session::forget('coupan');
        Session::forget('billing');
        Session::forget('lastid');
        Session::forget('address');
        Session::forget('payout');
        Session::forget('handlingcharge');
        Session::forget('coupanapplied');
        Session::forget('igst');
        Session::forget('indiantax');

        Cart::where('user_id', auth()->user()->id)->delete();

        DB::commit();

        $result = array();

        $getvariant = new CartController;

        $cm = new OrderController;

        foreach($neworder->invoices as $invoice){

            $result[] = array(
                'qty' => $invoice->qty,
                'tracking_id' => $invoice->tracking_id,
                'thumbnail_path' => url('variantimages/thumbnails'),
                'thumbnail' => $invoice->variant->variantimages->main_image,
                'product_name' => $invoice->variant->products->getTranslations('name'),
                'common_variant' => $cm->commonvariant($invoice->variant->products),
                'variant' => $getvariant->variantDetail($invoice->variant),
            );

        }

        return response()->json([
            'status' => 'success',
            'item' => $result
        ]);

        /** END */
    }
}
