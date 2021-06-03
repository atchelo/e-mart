<?php

namespace App\Http\Controllers;

use App\Address;
use App\AddSubVariant;
use App\Cart;
use App\Config;
use App\Coupan;
use App\Invoice;
use App\InvoiceDownload;
use App\Mail\OrderMail;
use App\ManualPaymentMethod;
use App\Notifications\OrderNotification;
use App\Notifications\SellerNotification;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Image;
use App\Notifications\UserOrderNotification;
use App\Genral;
use App\Notifications\SMSNotifcations;
use Twilosms;

class ManualPaymentGatewayController extends Controller
{
    public function getindex()
    {
        $methods = ManualPaymentMethod::orderBy('id', 'DESC')->get();
        return view('admindesk.manualpayment.index', compact('methods'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'payment_name' => 'required|string|max:50|unique:manual_payment_methods,payment_name',
            'description' => 'required|max:5000',
            'thumbnail' => 'mimes:jpg,jpeg,png,webp,bmp',
        ]);

        $newmethod = new ManualPaymentMethod;
        $input = $request->all();

        if (!is_dir(public_path() . '/images/manual_payment')) {
            mkdir(public_path() . '/images/manual_payment');
        }

        if ($request->file('thumbnail')) {

            $image = $request->file('thumbnail');
            $img = Image::make($image->path());
            $mp = 'mp_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/manual_payment');
            $img->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($destinationPath . '/' . $mp);
            $input['thumbnail'] = $mp;
        }

        $input['status'] = isset($request->status) ? 1 : 0;

        $newmethod->create($input);

        notify()->success('Payment method added !', $request->payment_name);
        return back();

    }

    public function update(Request $request, $id)
    {

        $method = ManualPaymentMethod::find($id);

        if (!$method) {
            notify()->error('Payment method not found !', 404);
            return back();
        }

        $request->validate([
            'payment_name' => 'required|string|max:50|unique:manual_payment_methods,payment_name,' . $method->id,
            'description' => 'required|max:5000',
            'thumbnail' => 'mimes:jpg,jpeg,png,webp,bmp',
        ]);

        $input = $request->all();

        if ($request->file('thumbnail')) {

            if (!is_dir(public_path() . '/images/manual_payment')) {
                mkdir(public_path() . '/images/manual_payment');
            }

            $image = $request->file('thumbnail');
            $img = Image::make($image->path());

            if ($method->thumbnail != '' && file_exists(public_path() . '/images/manual_payment/' . $method->thumbnail)) {
                unlink(public_path() . '/images/manual_payment/' . $method->thumbnail);
            }

            $mp = 'mp_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/manual_payment');
            $img->resize(600, 600, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($destinationPath . '/' . $mp);
            $input['thumbnail'] = $mp;
        }

        $input['status'] = isset($request->status) ? 1 : 0;

        $method->update($input);

        notify()->success('Payment method updated !', $request->payment_name);
        return back();

    }

    public function delete($id)
    {
        $method = ManualPaymentMethod::find($id);

        if (!$method) {
            notify()->error('Payment method not found !', 404);
            return back();
        }

        if ($method->thumbnail != '' && file_exists(public_path() . '/images/manual_payment/' . $method->thumbnail)) {
            unlink(public_path() . '/images/manual_payment/' . $method->thumbnail);
        }

        notify()->success("Payment method deleted", $method->payment_name);

        $method->delete();

        return back();
    }

    public function checkout(Request $request, $token)
    {
        require_once 'price.php';

        $validator = Validator::make($request->all(), [
            'purchase_proof' => 'required|mimes:jpg,jpeg,png,webp,bmp',
        ]);

        if ($validator->fails()) {
            notify()->error($validator->errors());
            $sentfromlastpage = 0;
            return view('front.checkout', compact('sentfromlastpage', 'conversion_rate'));
        }

        $cart_table = Auth::user()->cart;
        $total = 0;

        foreach ($cart_table as $cart) {

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

        $total = round($total * $conversion_rate, 2);

        if (round($request->actualtotal, 2) != round($total, 2)) {

            require_once 'price.php';
            $sentfromlastpage = 0;
            Session::put('from-pay-page', 'yes');
            Session::put('page-reloaded', 'yes');
            return redirect()->action('CheckoutController@add');

        }

        $txn_id = str_random(8);
        $payment_method = ucfirst($request->payvia);

        $payment_status = 'no';

        $checkout = new PlaceOrderController;

        return $checkout->placeorder($txn_id,$payment_method,session()->get('order_id'),$payment_status,NULL,$request->purchase_proof);
       

      
    }
}
