<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\BillingAddress;
use App\Cart;
use App\Genral;
use App\Http\Controllers\Controller;
use App\Shipping;
use App\ShippingWeight;
use App\Store;
use App\Tax;
use App\TaxClass;
use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use ShippingPrice;

class OrderController extends Controller
{
    public function orderReview(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'currency' => 'required',
            'address_id' => 'required',
            'billing_id' => 'required',
            'same_as' => 'required|in:1,0',
        ]);

        $same = $request->same_as;


        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

            if ($errors->first('address_id')) {
                return response()->json(['msg' => $errors->first('address_id'), 'status' => 'fail']);
            }

            if ($errors->first('billing_id')) {
                return response()->json(['msg' => $errors->first('billing_id'), 'status' => 'fail']);
            }

            if ($errors->first('same_as')) {
                return response()->json(['msg' => $errors->first('same_as'), 'status' => 'fail']);
            }
        }

        $data = array();

        $address = Address::find($request->address_id);

        if (!$address) {
            return response()->json(['msg' => 'Address not found !', 'status' => 'fail']);
        }
        

        if ($request->same_as == 1) {
            $billing_address = $address;

            $data['billing_address'] = array(
                'id' => $address->id,
                'name' => $address->name,
                'email' => $address->email,
                'phone' => $address->phone,
                'address' => $address->address,
                'country' => $address->getCountry ? $address->getCountry->nicename : null,
                'state' => $address->getstate ? $address->getstate->name : null,
                'city' => $address->getcity ? $address->getcity->name : null,
                'pincode' => $address->pin_code,
            );

        } else {
            $billing_address = BillingAddress::find($request->billing_id);

            if (!$billing_address) {
                return response()->json(['msg' => 'Billing address not found !', 'status' => 'fail']);
            }

            $data['billing_address'] = array(
                'id' => $billing_address->id,
                'name' => $billing_address->firstname,
                'email' => $billing_address->email,
                'phone' => (int) $billing_address->mobile,
                'address' => strip_tags($billing_address->address),
                'country' => $billing_address->countiess ? $billing_address->countiess->nicename : null,
                'state' => $billing_address->states ? $billing_address->states->name : null,
                'city' => $billing_address->cities ? $billing_address->cities->name : null,
                'pincode' => (int) $billing_address->pincode,
            );
        }

        $data['shipping_address'] = array(
            'id' => $address->id,
            'name' => $address->name,
            'email' => $address->email,
            'phone' => $address->phone,
            'address' => $address->address,
            'country' => $address->getCountry ? $address->getCountry->nicename : null,
            'state' => $address->getstate ? $address->getstate->name : null,
            'city' => $address->getcity ? $address->getcity->name : null,
            'pincode' => $address->pin_code,
        );

        $data['order_review'] = $this->getProducts($request, $address, $billing_address,$same);

        $data['payment_details'] = $this->getPaymentTotal($request, $address, $billing_address);

        return response()->json($data);

    }

    public function getProducts($request, $address, $billing_address,$same)
    {
        $rates = new CurrencyController;

        $rate = $rates->fetchRates($request->currency)->getData();

        $carts = auth()->user()->cart;

        $products = array();

        $price = 0;

        foreach ($carts as $cart) {

            $productData = new ProductController;

            $getvariant = new CartController;

            $rating = $productData->getproductrating($cart->product);

            $reviews = $productData->getProductReviews($cart->product);

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

            $price = sprintf("%.2f", $price * $rate->exchange_rate);

            $shipping = 0;

            if ($cart->ship_type != null) {
                $shipping += sprintf("%.2f", $cart->shipping * $rate->exchange_rate);
            } else {
                $shipping += (float) $this->calculateShipping($cart) * $rate->exchange_rate;
            }

            $tax = $this->getTaxInfo($cart->product, $rate, $address, $billing_address, $cart,$same);

            $subtotal = (float) sprintf("%.2f", $price);

            $products[] = array(
                'cartid' => $cart->id,
                'productid' => $cart->product->id,
                'variantid' => $cart->variant_id,
                'productname' => $cart->product->getTranslations('name'),
                'price' => (float) $price / $cart->qty,
                'total_price' => (float) $price,
                'currency_symbol' => $rate->symbol,
                'qty' => $cart->qty,
                'rating' => $rating,
                'localpickup' => $cart->ship_type == 'localpickup' ? 1 : 0,
                'review' => count($reviews),
                'thumbnail_path' => url('variantimages/thumbnails'),
                'thumbnail' => $cart->variant->variantimages->main_image,
                'tax_info' => $cart->product->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes"),
                'soldby' => $cart->product->store->name,
                'common_variant' => $this->commonvariant($cart->product),
                'variant' => $getvariant->variantDetail($cart->variant),
                'minorderqty' => (int) $cart->variant->min_order_qty,
                'maxorderqty' => (int) $cart->variant->max_order_qty,
                'shipping' => $shipping,
                'tax' => $tax,
                'subtotal' => $subtotal,
                'product_grand_total' => $subtotal + $tax['total_tax_amount'] + $shipping,
            );

        }

        return $products;

    }

    public function commonvariant($pro)
    {

        $common_variant = array();

        if (isset($pro->commonvars)) {

            foreach ($pro->commonvars as $cvar) {

                $common_variant[] = array(
                    'attr_id' => $cvar->attribute->id,
                    'attrribute' => $cvar->attribute->attr_name,
                    'valueid' => $cvar->provalues->id,
                    'value' => $cvar->provalues->values,
                    'unit' => $cvar->provalues->unit_value,
                    'type' => $cvar->attribute->attr_name == 'color' || $cvar->attribute->attr_name == 'Color' || $cvar->attribute->attr_name == 'colour' || $cvar->attribute->attr_name == 'Colour' ? 'c' : 's',
                );

            }

        }

        return $common_variant;

    }

    public static function calculateShipping($cart)
    {

        $shipping = 0;

        if ($cart->product->free_shipping == 0) {

            $free_shipping = Shipping::where('id', $cart->product->shipping_id)->first();

            if (!empty($free_shipping)) {

                if ($free_shipping->name == "Shipping Price") {

                    $weight = ShippingWeight::first();
                    $pro_weight = $cart->variant->weight;
                    if ($weight->weight_to_0 >= $pro_weight) {
                        if ($weight->per_oq_0 == 'po') {
                            $shipping = $weight->weight_price_0;
                        } else {
                            $shipping = $weight->weight_price_0 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_1 >= $pro_weight) {
                        if ($weight->per_oq_1 == 'po') {
                            $shipping = $weight->weight_price_1;
                        } else {
                            $shipping = $weight->weight_price_1 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_2 >= $pro_weight) {
                        if ($weight->per_oq_2 == 'po') {
                            $shipping = $weight->weight_price_2;
                        } else {
                            $shipping = $weight->weight_price_2 * $cart->qty;
                        }
                    } elseif ($weight->weight_to_3 >= $pro_weight) {
                        if ($weight->per_oq_3 == 'po') {
                            $shipping = $weight->weight_price_3;
                        } else {
                            $shipping = $weight->weight_price_3 * $cart->qty;
                        }
                    } else {
                        if ($weight->per_oq_4 == 'po') {
                            $shipping = $weight->weight_price_4;
                        } else {
                            $shipping = $weight->weight_price_4 * $cart->qty;
                        }

                    }

                } else {

                    $shipping = $free_shipping->price;

                }
            }
        }

        return $shipping;
    }

    public function getTaxInfo($pro, $rate, $address, $billing_address, $cart,$same)
    {
        
        $tax = array();

        // if tax is set to 0 here which means price is incl. of tax

        if ($pro->tax == 0) {

            if ($pro->offer_price != 0) {

                $p = 100;
                $taxrate_db = $pro->tax_r;
                $vp = $p + $taxrate_db;
                $tamount = $pro->offer_price / $vp * $taxrate_db;
                $tamount = sprintf("%.2f", $tamount);

            } else {

                $p = 100;
                $taxrate_db = $pro->tax_r;
                $vp = $p + $taxrate_db;
                $tamount = $pro->price / $vp * $taxrate_db;

                $tamount = sprintf("%.2f", $tamount);

            }

            if ($pro->store->country['nicename'] == 'India' || $pro->store->country['nicename'] == 'india') {

                // IGST Apply IF STORE ADDRESS STATE AND SHIPPING ADDRESS STATE WILL BE DIFFERENT

                if ($pro->store->state['id'] != $address->getstate->id) {

                    $igst = $tamount * $cart->qty;

                    $igst = sprintf("%.2f", $igst * $rate->exchange_rate);

                    $tax['tax_type'] = 'single';

                    $tax['tax_name'] = array(

                        'name1' => array(
                            'en' => 'IGST',
                        ),

                    );

                    $tax['amount'] = array(

                        'amount1' => (float) sprintf("%.2f", $tamount * $rate->exchange_rate),
                        'totalAmount1' => (float) $igst,
                        'combinedTotal' => (float) $igst,

                    );

                }

                // CGST + SGST Apply IF STORE ADDRESS STATE AND SHIPPING ADDRESS STATE WILL BE SAME

                if ($pro->store->state['id'] == $address->getstate->id) {

                    $t_amount = $tamount * $cart->qty;
                    $t_amount = sprintf("%.2f", $t_amount * $rate->exchange_rate);

                    $tax['tax_type'] = 'multiple';

                    $tax['tax_name'] = array(

                        'name1' => array(
                            'en' => 'SGST',
                        ),

                        'name2' => array(
                            'en' => 'CGST',
                        ),
                    );

                    $tax['amount'] = array(
                        'amount1' => (float) sprintf("%.2f", ($tamount / 2) * $rate->exchange_rate),
                        'totalAmount1' => (float) sprintf("%.2f", ($tamount * $cart->qty / 2) * $rate->exchange_rate),
                        'amount2' => (float) sprintf("%.2f", ($tamount / 2) * $rate->exchange_rate),
                        'totalAmount2' => (float) sprintf("%.2f", ($tamount * $cart->qty / 2) * $rate->exchange_rate),
                        'combinedTotal' => (float) $t_amount,
                    );

                }

            } else {

                $tax['tax_type'] = 'single';

                $tax['tax_name'] = array(
                    'name1' => $pro->getTranslations('tax_name'),
                );

                $tax['amount'] = array(

                    'amount1' => (float) sprintf("%.2f", ($tamount / $cart->qty) * $rate->exchange_rate),
                    'totalAmount1' => (float) sprintf("%.2f", ($tamount * $cart->qty / 2) * $rate->exchange_rate),
                    'combinedTotal' => (float) sprintf("%.2f", ($tamount * $cart->qty / 2) * $rate->exchange_rate),

                );
            }

            $tamount = $tamount * $cart->qty;

            $tax['total_tax_amount'] = (float) sprintf("%.2f", $tamount * $rate->exchange_rate);

            return $tax;

        } else {

            
            $tax = $this->getExcludeTax($tax, $address, $billing_address, $pro, $cart, $rate,$same);

            return $tax;
        }

    }

    public function getExcludeTax($tax, $address, $billing_address, $pro, $cart, $rate,$same)
    {
        $pri = array();

        $taxable = array();

        $min_pri = array();

       


        if($same == 1){

            $s_id = $address->getstate->id;

        }else{

            $s_id = $billing_address->states->id;

        }

        foreach (TaxClass::where('id', $pro->tax)->get() as $tax) {

            if (isset($tax->priority)) {
                foreach ($tax->priority as $proity) {

                    array_push($pri, $proity);

                }
            }

        }

        $matched = 'no';
        $after_tax_amount = 0;

        if ($matched == 'no') {

            if ($pri == '' || $pri == null) {
                $after_tax_amount = 0;
            } else {

                if ($min_pri == null) {

                    $ch_prio = 0;
                    $i = 0;
                    $x = min($pri);
                    array_push($min_pri, $x);
                    if (isset($tax->priority)) {

                        foreach ($tax->priority as $key => $MaxPri) {

                            try {
                                if ($tax->based_on[$min_pri[0]] == "billing") {

                                    $taxRate = Tax::where('id', $tax->taxRate_id[$min_pri[0]])->first();
                                    $zone = Zone::where('id', $taxRate->zone_id)->first();
                                    $store = $s_id;

                                    if (is_array($zone->name)) {

                                        $zonecount = count($zone->name);

                                        if ($ch_prio == $min_pri[0]) {
                                            break;
                                        } else {
                                            foreach ($zone->name as $z) {

                                                $i++;

                                                if ($store == $z) {
                                                    $i = $zonecount;
                                                    $matched = 'yes';
                                                    if ($taxRate->type == 'p') {
                                                        $tax_amount = $taxRate->rate;
                                                        $price = $cart->ori_offer_price == null && $pro->ori_offer_price == 0 ? $cart->ori_price * $cart->qty : $cart->ori_offer_price * $cart->qty;
                                                        $after_tax_amount = $price * ($tax_amount / 100);
                                                    } // End if Billing Type per And fix
                                                    else {

                                                        $tax_amount = $taxRate->rate;
                                                        $price = $cart->ori_offer_price == null && $cart->ori_offer_price == 0 ? $cart->ori_price * $cart->qty : $cart->ori_offer_price * $cart->qty;
                                                        $after_tax_amount = $taxRate->rate * $cart->qty;
                                                    }
                                                    $ch_prio = $min_pri[0];
                                                    break;
                                                } else {

                                                    if ($i == $zonecount) {
                                                        array_splice($pri, array_search($min_pri[0], $pri), 1);
                                                        unset($min_pri);
                                                        $min_pri = array();

                                                        $x = min($pri);
                                                        array_push($min_pri, $x);

                                                        $i = 0;
                                                        break;
                                                    }
                                                }
                                            }
                                        }

                                    }
                                } else {

                                    $taxRate = Tax::where('id', $tax->taxRate_id[$min_pri[0]])->first();

                                    $zone = Zone::where('id', $taxRate->zone_id)->first();

                                    $store = Store::where('user_id', $pro->vender_id)->first();

                                    if (is_array($zone->name)) {

                                        $zonecount = count($zone->name);

                                        if ($ch_prio == $min_pri[0]) {
                                            break;
                                        } else {
                                            foreach ($zone->name as $z) {

                                                $i++;
                                                if ($store->state_id == $z) {

                                                    $i = $zonecount;
                                                    $matched = 'yes';
                                                    if ($taxRate->type == 'p') {
                                                        $tax_amount = $taxRate->rate;
                                                        $price = $cart->ori_offer_price == 0 ? $cart->ori_price * $cart->qty : $cart->ori_offer_price * $cart->qty;
                                                        $after_tax_amount = $price * ($tax_amount / 100);
                                                    } // End if Billing Typ per And fix
                                                    else {
                                                        $tax_amount = $taxRate->rate;
                                                        $price = $cart->ori_offer_price == 0 ? $cart->ori_price * $cart->qty : $cart->ori_offer_price * $cart->qty;
                                                        $after_tax_amount = $taxRate->rate * $cart->qty;
                                                    }
                                                    $ch_prio = $min_pri[0];
                                                    break;
                                                } else {
                                                    if ($i == $zonecount) {
                                                        array_splice($pri, array_search($min_pri[0], $pri), 1);
                                                        unset($min_pri);
                                                        $min_pri = array();

                                                        $x = min($pri);
                                                        array_push($min_pri, $x);

                                                        $i = 0;
                                                        break;
                                                    }
                                                }
                                            }
                                        }

                                    }
                                }
                            } catch (\Exception $e) {

                                $after_tax_amount = 0;
                                break;

                            }

                        }
                    }
                }
            }
        }

        if ($pro->store->country['nicename'] == 'India' || $pro->store->country['nicename'] == 'india') {
            // IGST Apply IF STORE ADDRESS STATE AND SHIPPING ADDRESS STATE WILL BE DIFFERENT

            if ($pro->store->state['id'] != $address->getstate->id) {

                $igst = $after_tax_amount;

                $igst = sprintf("%.2f", $igst * $rate->exchange_rate);

                $taxable['tax_type'] = 'single';

                $taxable['tax_name'] = array(

                    'name1' => array(
                        'en' => 'IGST',
                    ),

                );

                $taxable['amount'] = array(

                    'amount1' => (float) sprintf("%.2f", $after_tax_amount / $cart->qty * $rate->exchange_rate),
                    'totalAmount1' => (float) $igst,
                    'combinedTotal' => (float) $igst,

                );

            }

            // CGST + SGST Apply IF STORE ADDRESS STATE AND SHIPPING ADDRESS STATE WILL BE SAME

            if ($pro->store->state['id'] == $address->getstate->id) {

                $t_amount = $after_tax_amount;
                $t_amount = sprintf("%.2f", $t_amount * $rate->exchange_rate);

                $taxable['tax_type'] = 'multiple';

                $taxable['tax_name'] = array(

                    'name1' => array(
                        'en' => 'IGST',
                    ),

                    'name2' => array(
                        'en' => 'CGST',
                    ),
                );

                $taxable['amount'] = array(
                    'amount1' => (float) sprintf("%.2f", ($after_tax_amount / 2) * $rate->exchange_rate),
                    'totalAmount1' => (float) sprintf("%.2f", ($after_tax_amount) * $rate->exchange_rate),
                    'amount2' => (float) sprintf("%.2f", ($after_tax_amount / 2) * $rate->exchange_rate),
                    'totalAmount2' => (float) sprintf("%.2f", ($after_tax_amount) * $rate->exchange_rate),
                    'combinedTotal' => (float) $t_amount,
                );

            }
        } else {

            $taxable['tax_type'] = 'single';

            $taxable['tax_name'] = array(
                'name1' => array(
                    'en' => $pro->taxclass->title,
                ),
            );

            $taxable['amount'] = array(

                'amount1' => (float) sprintf("%.2f", ($after_tax_amount / $cart->qty) * $rate->exchange_rate),
                'totalAmount1' => (float) sprintf("%.2f", ($after_tax_amount) * $rate->exchange_rate),
                'combinedTotal' => (float) sprintf("%.2f", ($after_tax_amount) * $rate->exchange_rate),

            );

        }

        $taxable['total_tax_amount'] = (float) sprintf("%.2f", ($after_tax_amount) * $rate->exchange_rate);

        return $taxable;
    }

    public function getPaymentTotal($request, $address, $billing_address)
    {
        
        $rates = new CurrencyController;

        $rate = $rates->fetchRates($request->currency)->getData();

        $handlinecharge = 0;

        $shipping = 0;

        $total = 0;

        $totalTax = 0;

        $grandtotal = 0;

        /*Handling charge per item count*/
        $hcsetting = Genral::first();

        if ($hcsetting->chargeterm == 'fo') {
            // on full order handling charge
            $handlinecharge = $hcsetting->handlingcharge;

        } elseif ($hcsetting->chargeterm == 'pi') {
            // Per item handling charge
            $totalcartitem = auth()->user()->cart()->count();
            $handlinecharge = $hcsetting->handlingcharge * $totalcartitem;
        }
        /*END*/

        $paymentdetails = array();

        foreach (auth()->user()->cart as $val) {

            if ($val->ship_type == null) {
                $shipping += ShippingPrice::calculateShipping($val);
            } else {
                $shipping += $val->shipping;
            }

            if ($val->product->tax_r != null && $val->product->tax == 0) {

                if ($val->ori_offer_price != 0) {
                    //get per product tax amount
                    $p = 100;
                    $taxrate_db = $val->product->tax_r;
                    $vp = $p + $taxrate_db;
                    $taxAmnt = $val->product->offer_price / $vp * $taxrate_db;
                    $taxAmnt = sprintf("%.2f", $taxAmnt);
                    $price = ($val->ori_offer_price - $taxAmnt) * $val->qty;

                } else {

                    $p = 100;
                    $taxrate_db = $val->product->tax_r;
                    $vp = $p + $taxrate_db;
                    $taxAmnt = $val->product->price / $vp * $taxrate_db;

                    $taxAmnt = sprintf("%.2f", $taxAmnt);

                    $price = ($val->ori_price - $taxAmnt) * $val->qty;
                }

            } else {

                if ($val->semi_total != 0) {

                    $price = $val->semi_total;

                } else {

                    $price = $val->price_total;

                }
            }

            $total = $total + $price;

            $x = $this->getTaxInfo($val->product, $rate, $address, $billing_address, $val,$request->same_as);

            $totalTax = $totalTax + $x['total_tax_amount'];

        }

        $grandtotal = ($total * $rate->exchange_rate) + ($handlinecharge * $rate->exchange_rate);

        $grandtotal = $grandtotal + ($shipping * $rate->exchange_rate) + $totalTax;

        $promo = (float) sprintf("%.2f", Cart::getDiscount() * $rate->exchange_rate);

        if ($promo != 0) {
            $grandtotal = $grandtotal - $promo;
        }

        $paymentdetails = array(

            'total_items' => auth()->user()->cart()->count(),
            'currency_symbol' => $rate->symbol,
            'subtotal' => (float) sprintf("%.2f", $total * $rate->exchange_rate),
            'total_tax' => $totalTax,
            'discount_amount' => $promo,
            'coupan' => Cart::getCoupanDetail(),
            'total_handingcharge' => (float) sprintf("%.2f", $handlinecharge * $rate->exchange_rate),
            'total_shipping' => (float) sprintf("%.2f", $shipping * $rate->exchange_rate),
            'grand_total' => (float) sprintf("%.2f", $grandtotal),

        );

        return $paymentdetails;

    }

    public function localpickupapply(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'cartid' => 'required',
            'currency' => 'required',
            'address_id' => 'required',
            'billing_id' => 'required',
            'same_as' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('cartid')) {
                return response()->json(['msg' => $errors->first('cartid'), 'status' => 'fail']);
            }

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

            if ($errors->first('address_id')) {
                return response()->json(['msg' => $errors->first('address_id'), 'status' => 'fail']);
            }

            if ($errors->first('billing_id')) {
                return response()->json(['msg' => $errors->first('billing_id'), 'status' => 'fail']);
            }

            if ($errors->first('same_as')) {
                return response()->json(['msg' => $errors->first('same_as'), 'status' => 'fail']);
            }
        }

        $getrate = Shipping::where('name', '=', 'Local Pickup')->first()->price;

        $rates = new CurrencyController;

        $cartrow = Cart::where('id', '=', $request->cartid)->where('user_id', Auth::user()
                ->id)
                ->first();

        if (isset($cartrow)) {
            if (!empty($cartrow->product->shipping_id)) {

                /*Update cart row*/
                $cartrow->shipping = $getrate;
                $cartrow->ship_type = 'localpickup';
                $cartrow->save();
                /*End*/

            } else {

                /*Update cart row*/
                $getrate = 0;
                $cartrow->shipping = '0';
                $cartrow->ship_type = 'localpickup';
                $cartrow->save();
                /*End*/
            }

            return $this->orderReview($request);

        } else {

            return response()->json([
                'message' => 'Cart row not found !',
                'status' => 'fail',
            ]);

        }
    }

    public function localpickupremove(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'cartid' => 'required',
            'currency' => 'required',
            'address_id' => 'required',
            'billing_id' => 'required',
            'same_as' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('cartid')) {
                return response()->json(['msg' => $errors->first('cartid'), 'status' => 'fail']);
            }

            if ($errors->first('currency')) {
                return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

            if ($errors->first('address_id')) {
                return response()->json(['msg' => $errors->first('address_id'), 'status' => 'fail']);
            }

            if ($errors->first('billing_id')) {
                return response()->json(['msg' => $errors->first('billing_id'), 'status' => 'fail']);
            }

            if ($errors->first('same_as')) {
                return response()->json(['msg' => $errors->first('same_as'), 'status' => 'fail']);
            }
        }

        $row = Cart::where('id', '=', $request->cartid)->where('user_id', Auth::user()
                ->id)
                ->first();

        if (!isset($row)) {
            return response()->json([
                'message' => 'Cart row not found !',
                'status' => 'fail',
            ]);
        }

        $free_shipping = Shipping::where('id', $row
                ->product
                ->shipping_id)
                ->first();

        if (!empty($free_shipping)) {
            if ($free_shipping->name == "Shipping Price") {
                $weight = ShippingWeight::first();
                $pro_weight = $row
                    ->variant->weight;
                if ($weight->weight_to_0 >= $pro_weight) {

                    if ($weight->per_oq_0 == 'po') {
                        $per_shipping = $weight->weight_price_0;

                        Cart::where('id', $row->id)
                            ->update(array(
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ));
                    } else {
                        $per_shipping = $weight->weight_price_0 * $row->qty;

                        Cart::where('id', $row->id)
                            ->update(array(
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ));
                    }
                } elseif ($weight->weight_to_1 >= $pro_weight) {

                    if ($weight->per_oq_1 == 'po') {
                        $per_shipping = $weight->weight_price_1;

                        Cart::where('id', $row->id)
                            ->update(array(
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ));
                    } else {
                        $per_shipping = $weight->weight_price_1 * $row->qty;

                        Cart::where('id', $row->id)
                            ->update(array(
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ));
                    }
                } elseif ($weight->weight_to_2 >= $pro_weight) {

                    if ($weight->per_oq_2 == 'po') {
                        $per_shipping = $weight->weight_price_2;

                        Cart::where('id', $row->id)
                            ->update(array(
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ));
                    } else {

                        $per_shipping = $weight->weight_price_2 * $row->qty;
                        Cart::where('id', $row->id)
                            ->update(array(
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ));
                    }
                } elseif ($weight->weight_to_3 >= $pro_weight) {

                    if ($weight->per_oq_3 == 'po') {
                        $per_shipping = $weight->weight_price_3;

                        Cart::where('id', $row->id)
                            ->update(array(
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ));
                    } else {
                        $per_shipping = $weight->weight_price_3 * $row->qty;

                        Cart::where('id', $row->id)
                            ->update(array(
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ));
                    }
                } else {

                    if ($weight->per_oq_4 == 'po') {
                        $per_shipping = $weight->weight_price_4;

                        Cart::where('id', $row->id)
                            ->update(array(
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ));
                    } else {

                        $per_shipping = $weight->weight_price_4 * $row->qty;

                        Cart::where('id', $row->id)
                            ->update(array(
                                'shipping' => $per_shipping,
                                'ship_type' => null,
                            ));

                    }

                }

            } else {
                $per_shipping = $free_shipping->price;

                Cart::where('id', $row->id)
                    ->update(array(
                        'shipping' => $per_shipping,
                        'ship_type' => null,
                    ));

            }
        } else {
            Cart::where('id', $row->id)
                ->update(array(
                    'shipping' => '0',
                    'ship_type' => null,
            ));
        }

        return $this->orderReview($request);

    }

}
