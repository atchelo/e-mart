<?php

namespace App\Http\Controllers;

use App\Address;
use App\FailedTranscations;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class IyzcioController extends Controller
{
    public function pay(Request $request)
    {   

        require_once 'price.php';

        $adrid = Session::get('address');

        $address = Address::find($adrid);

        $c = strlen($address->phone);

        if ($c < 10) {

            notify()->error("Invalid Phone no. ");
            return redirect(route('order.review'));
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
       
       
        $total = sprintf("%.2f",$total * $conversion_rate);

        if (round($request->actualtotal, 2) != $total) {

            notify()->error('Payment has been modifed !','Please try again !');
            return redirect(route('order.review'));

        }
        
        $amount = Crypt::decrypt($request->amount);
        $conversation_id = $request->conversation_id;
        $basket_id = 'B' . substr(str_shuffle("0123456789"), 0, 5);
        $user_id = 'BY' . Auth::user()->id;
        $fname = Auth::user()->name;
        $lname = Auth::user()->name;
        $address = $request->address;
        $city = $request->city;
        $state = $request->state;
        $country = $request->country;
        $item_id = 'BI' . substr(str_shuffle("0123456789"), 0, 3);
        $pincode = $request->pincode;
        $now = Carbon::now()->toDateTimeString();
        $ip = $request->ip();
        $currency = $request->currency;

        $language = strtoupper(App::getLocale());

        $identity = $request->identity_number;
        $email = $request->email;
        $mobile = $request->mobile;

        Cookie::queue('user_selection', Auth::user()->id, 100);

        $options = new \Iyzipay\Options();
        $options->setApiKey(env('IYZIPAY_API_KEY'));
        $options->setSecretKey(env('IYZIPAY_SECRET_KEY'));
        $options->setBaseUrl(env('IYZIPAY_BASE_URL'));

        $request = new \Iyzipay\Request\CreatePayWithIyzicoInitializeRequest();
        $request->setLocale($language);
        $request->setConversationId($conversation_id);
        $request->setPrice($amount);
        $request->setPaidPrice($amount);
        $request->setCurrency($currency);
        $request->setBasketId($basket_id);
        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $request->setCallbackUrl(route('iyzcio.callback'));
        $request->setEnabledInstallments(array(1));
        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId($user_id);
        $buyer->setName($fname);
        $buyer->setSurname($lname);
        $buyer->setGsmNumber($mobile);
        $buyer->setEmail($email);
        $buyer->setIdentityNumber($identity);
        $buyer->setLastLoginDate($now);
        $buyer->setRegistrationDate($now);
        $buyer->setRegistrationAddress($address);
        $buyer->setIp($ip);
        $buyer->setCity($city);
        $buyer->setCountry($country);
        $buyer->setZipCode($pincode);
        $request->setBuyer($buyer);
        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName($fname);
        $shippingAddress->setCity($city);
        $shippingAddress->setCountry($country);
        $shippingAddress->setAddress($address);
        $shippingAddress->setZipCode($pincode);
        $request->setShippingAddress($shippingAddress);
        $billingAddress = new \Iyzipay\Model\Address();
        $billingAddress->setContactName($fname);
        $billingAddress->setCity($city);
        $billingAddress->setCountry($country);
        $billingAddress->setAddress($address);
        $billingAddress->setZipCode($pincode);
        $request->setBillingAddress($billingAddress);
        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId($item_id);
        $firstBasketItem->setName(config('app.name'));
        $firstBasketItem->setCategory1(config('app.name'));
        $firstBasketItem->setCategory2(config('app.name'));
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::VIRTUAL);
        $firstBasketItem->setPrice($amount);
        $basketItems[0] = $firstBasketItem;

        $request->setBasketItems($basketItems);
        # make request
        $payWithIyzicoInitialize = \Iyzipay\Model\PayWithIyzicoInitialize::create($request, $options);

        // dd($payWithIyzicoInitialize);

        if ($payWithIyzicoInitialize->getstatus() == 'success') {
            $url = $payWithIyzicoInitialize->getpayWithIyzicoPageUrl();

            return redirect($url);
        }

        notify()->error($payWithIyzicoInitialize->getErrorMessage());
        return redirect(route('order.review'));

    }

    public function callback(Request $request)
    {
        $token = $request->token;

    	$options = new \Iyzipay\Options();
		$options->setApiKey(env('IYZIPAY_API_KEY'));
		$options->setSecretKey(env('IYZIPAY_SECRET_KEY'));
		$options->setBaseUrl(env('IYZIPAY_BASE_URL'));
    	

        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        
        $request->setLocale(\Iyzipay\Model\Locale::EN);
		$request->setConversationId(uniqid());
		$request->setToken($token);

		$checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $options);

		// dd($checkoutForm);

		$status = $checkoutForm->getstatus();

		$txn_id = $checkoutForm->getpaymentId();
        
        if($status == 'success') {

            $payment_status = 'yes';

            $checkout = new PlaceOrderController;

            return $checkout->placeorder($txn_id,'Iyzico',session()->get('order_id'),$payment_status);

        }else{
            $failedTranscations = new FailedTranscations();
            $failedTranscations->txn_id = 'PAYU_FAILED_' . Str::uuid();
            $failedTranscations->user_id = Auth::user()->id;
            $failedTranscations->save();
            notify()->warning('Payment failed !','Failed');
            return redirect(route('order.review'));
        }
    }
}
