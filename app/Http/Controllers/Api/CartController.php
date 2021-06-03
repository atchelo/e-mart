<?php

namespace App\Http\Controllers\Api;

use App\AddSubVariant;
use App\Cart;
use App\Coupan;
use App\Http\Controllers\Controller;
use App\ProductAttributes;
use App\ProductValues;
use App\Shipping;
use App\ShippingWeight;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use ShippingPrice;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {

        $validator = Validator::make($request->all(), [
    		'currency' => 'required|string|min:3|max:3',
            'variantid' => 'required|numeric',
            'quantity' => 'required|numeric|min:1'
		]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('currency')){
				return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
			}

			if($errors->first('variantid')){
				return response()->json(['msg' => $errors->first('variantid'), 'status' => 'fail']);
            }
            
            if($errors->first('quantity')){
				return response()->json(['msg' => $errors->first('quantity'), 'status' => 'fail']);
			}
	
        }

        $item = Cart::where('variant_id', '=', $request->variantid)->where('user_id','=',Auth::user()->id)->first();

        $rates = new CurrencyController;

        $rate = $rates->fetchRates($request->currency)->getData();

        $variant = AddSubVariant::find($request->variantid);

        if (!$variant) {
            return response()->json(['msg' => 'Variant not found !','status' => 'fail']);
        }

        if ($variant->stock < 1) {
            return response()->json(['msg' => 'Sorry ! Item is out of stock currently !','status' => 'fail']);
        }

        if ($request->quantity < $variant->min_order_qty) {
            return response()->json(['msg' => 'For this product you need to add atleast ' . $variant->min_order_qty . ' quantity','status' => 'fail']);
        }

        if ($request->quantity > $variant->max_order_qty) {
            return response()->json(['msg' => 'For this product you can add maximum ' . $variant->max_order_qty . ' quantity','status' => 'fail']);
        }

        if ($request->quantity > $variant->stock) {
            return response()->json(['msg' => 'Product stock limit reached !','status' => 'fail']);
        }

        $price = new ProductController;

        $price = $price->getprice($variant->products, $variant)->getData();

        if (isset($item)) {

            $newqty = (int) $item->qty + $request->quantity;
            $item->qty = $newqty;
            $item->price_total = (float) $price->mainprice * $newqty;
            $item->semi_total = (float) $price->offerprice * $newqty;

            $item->shipping = $this->getShipping($newqty, $variant);

            $item->updated_at = now();

            $item->save();

            return response()->json(['msg' => 'Product quantity updated !','status' => 'success']);

        } else {

            $cart = new Cart;
            $cart->qty = $request->quantity;
            $cart->user_id = Auth::user()->id;
            $cart->pro_id = $variant->products->id;
            $cart->variant_id = $request->variantid;
            $cart->ori_price = (float) $price->mainprice;
            $cart->ori_offer_price = (float) $price->offerprice;

            $cart->price_total = (float) $price->mainprice * $request->quantity;
            $cart->semi_total = (float) $price->offerprice * $request->quantity;

            $cart->vender_id = $variant->products->vender->id;
            $cart->shipping = $this->getShipping($request->quantity, $variant);
            $cart->created_at = now();
            $cart->updated_at = now();

            $cart->save();

            return response()->json(['msg' => 'Item added to cart successfully !','status' => 'success']);

        }

    }

    public function getShipping($qty, $variant)
    {
        $shipping = 0;

        if ($variant->products->free_shipping == 0) {

            $free_shipping = Shipping::where('id', $variant->products->shipping_id)->first();

            if (!empty($free_shipping)) {

                if ($free_shipping->name == "Shipping Price") {

                    $weight = ShippingWeight::first();

                    $pro_weight = $variant->weight;

                    if ($weight->weight_to_0 >= $pro_weight) {

                        if ($weight->per_oq_0 == 'po') {
                            $shipping = $shipping + $weight->weight_price_0;
                        } else {
                            $shipping = $shipping + $weight->weight_price_0 * $qty;
                        }

                    } elseif ($weight->weight_to_1 >= $pro_weight) {

                        if ($weight->per_oq_1 == 'po') {
                            $shipping = $shipping + $weight->weight_price_1;
                        } else {
                            $shipping = $shipping + $weight->weight_price_1 * $qty;
                        }

                    } elseif ($weight->weight_to_2 >= $pro_weight) {

                        if ($weight->per_oq_2 == 'po') {
                            $shipping = $shipping + $weight->weight_price_2;
                        } else {
                            $shipping = $shipping + $weight->weight_price_2 * $qty;
                        }

                    } elseif ($weight->weight_to_3 >= $pro_weight) {

                        if ($weight->per_oq_3 == 'po') {
                            $shipping = $shipping + $weight->weight_price_3;
                        } else {
                            $shipping = $shipping + $weight->weight_price_3 * $qty;
                        }

                    } else {

                        if ($weight->per_oq_4 == 'po') {
                            $shipping = $shipping + $weight->weight_price_4;
                        } else {
                            $shipping = $shipping + $weight->weight_price_4 * $qty;
                        }

                    }

                } else {

                    $shipping = $shipping + $free_shipping->price;

                }
            }

        }

        return $shipping;
    }

    public function yourCart(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'currency' => 'required|string|min:3|max:3',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('currency')){
				return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }
        }

        $rates = new CurrencyController;

        $rate = $rates->fetchRates($request->currency)->getData();

        if (count($this->cartproducts($request->currency))) {

            $cart = array(
                'products' => $this->cartproducts($request->currency),
                'subtotal' => (double) sprintf("%.2f", $this->cartTotal()->getData()->subtotal * $rate->exchange_rate),
                'shipping' => (double) sprintf("%.2f", $this->cartTotal()->getData()->shipping * $rate->exchange_rate),
                'coupan_discount' => (float) sprintf("%.2f",$this->getTotalDiscount()*$rate->exchange_rate),
                'grand_total' => (double) sprintf("%.2f", $this->cartTotal()->getData()->grandTotal * $rate->exchange_rate),
                'currency' => $rate->code,
                'symbol' => $rate->symbol,
                'appliedCoupan' => $this->appliedCoupan($rate) != null ? $this->appliedCoupan($rate)->getData() : null,
                'offers' => $this->getOffers($rate)
            );

            return response()->json($cart);
        } else {
            return response()->json(['msg' => 'Your cart is empty !','status' => 'success']);
        }

    }

    public function cartproducts($currency)
    {

        $rates = new CurrencyController;

        $rate = $rates->fetchRates($currency)->getData();

        $products = array();

        foreach (Auth::user()->cart as $cart) {

            $productData = new ProductController;

            $rating = $productData->getproductrating($cart->product);

            $reviews = $productData->getProductReviews($cart->product);

            if($productData->getprice($cart->product, $cart->variant)->getData()->offerprice != 0){

                $mp = sprintf("%.2f", $productData->getprice($cart->product, $cart->variant)->getData()->mainprice*$rate->exchange_rate);
                $op = sprintf("%.2f", $productData->getprice($cart->product, $cart->variant)->getData()->offerprice*$rate->exchange_rate);
    
                $getdisprice = $mp - $op;
    
                $discount = $getdisprice / $mp;
    
                $offamount = $discount * 100;

            }else{

                $offamount = 0;

            }

            $products[] = array(
                'cartid' => $cart->id,
                'productid' => $cart->product->id,
                'variantid' => $cart->variant_id,
                'off_in_percent' => (int) round($offamount),
                'productname' => $cart->product->name,
                'orignalprice' => (float) sprintf("%.2f", $cart->price_total * $rate->exchange_rate) / $cart->qty,
                'orignalofferprice' => (float) sprintf("%.2f", $cart->semi_total * $rate->exchange_rate) / $cart->qty,
                'mainprice' => (float) sprintf("%.2f", $cart->price_total * $rate->exchange_rate),
                'offerprice' => (float) sprintf("%.2f", $cart->semi_total * $rate->exchange_rate),
                'qty' => $cart->qty,
                'rating' => $rating,
                'review' => count($reviews),
                'thumbnail_path' => url('variantimages/thumbnails'),
                'thumbnail' => $cart->variant->variantimages->main_image,
                'tax_info' => $cart->product->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes"),
                'soldby' => $cart->product->store->name,
                'variant' => $this->variantDetail($cart->variant),
                'minorderqty' => (int) $cart->variant->min_order_qty,
                'maxorderqty' => (int) $cart->variant->max_order_qty
            );

        }

        return $products;

    }

    public function cartTotal()
    {

        $totalshipping = $this->calculateShipping();
        $subtotal = 0;


        foreach (Auth::user()->cart as $cart) {

            if ($cart->semi_total != 0) {

                $subtotal = $subtotal + $cart->semi_total;

            } else {

                $subtotal = $subtotal + $cart->price_total;

            }

        }

        $grandtotal = ($totalshipping + $subtotal) - $this->getTotalDiscount();

        return response()->json([

            'subtotal' => sprintf("%.2f",$subtotal),
            'grandTotal' => sprintf("%.2f",$grandtotal),
            'shipping' => $totalshipping

        ]);

    }

    public function calculateShipping(){

        $shipping = 0;
        
        foreach(Auth::user()->cart as $cart){
          $shipping =  ShippingPrice::calculateShipping($cart);
        }

        return $shipping;

    }

    public function variantDetail($variant)
    {

        $varcount = count($variant->main_attr_value);
        $var_main = '';
        $i = 0;
        $othervariantName = null;

        $variants = null;

        foreach ($variant->main_attr_value as $key => $orivars) {

            $i++;

            $loopgetattrname = ProductAttributes::where('id', $key)->first();
            $getvarvalue = ProductValues::where('id', $orivars)->first();

            $result[] = array(
                'attr_id' => $loopgetattrname['id'],
                'attrribute' => $loopgetattrname['attr_name'],
            );

            if ($i < $varcount) {
                if (strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {
                    if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

                        $othervariantName = $getvarvalue->values;

                    } else {
                        $othervariantName = $getvarvalue->values . $getvarvalue->unit_value;
                    }
                } else {
                    $othervariantName = $getvarvalue->values;
                }

            } else {

                if (strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {

                    if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

                        $othervariantName = $getvarvalue->values;

                    } else {
                        $othervariantName = $getvarvalue->values . $getvarvalue->unit_value;
                    }

                } else {
                    $othervariantName = $getvarvalue->values;
                }

            }

            $variants[] = array(
                'var_name' => $othervariantName,
                'attr_name' => $loopgetattrname['attr_name'],
                'type' => $loopgetattrname['attr_name'] == 'color' || $loopgetattrname['attr_name'] == 'Color' || $loopgetattrname['attr_name'] == 'colour' || $loopgetattrname['attr_name'] == 'Colour' ? 'c' : 's',
            );

        }

        return $variants;

    }

    public function increaseQuantity(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'cartid' => 'required|numeric',
            'currency' => 'required|string|max:3|min:3',
            'quantity' => 'required'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('cartid')){
				return response()->json(['msg' => $errors->first('cartid'), 'status' => 'fail']);
            }

            if($errors->first('currency')){
				return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
            }

            if($errors->first('quantity')){
				return response()->json(['msg' => $errors->first('quantity'), 'status' => 'fail']);
            }
        }

        $cartrow = Cart::find($request->cartid);

        if (!$cartrow) {
            return response()->json(['msg' => 'Cart item not found !','status' => 'fail']);
        }

        $variant = AddSubVariant::find($cartrow->variant_id);

        if (!$variant) {
            return response()->json(['msg' => 'Variant not found !','status' => 'fail']);
        }

        if ($variant->stock < 1) {
            return response()->json(['msg' => 'Sorry ! Item is out of stock currently !','status' => 'fail']);
        }

        if ($request->qty > $variant->stock) {
            return response()->json(['msg' =>'Product stock limit reached !','status' => 'fail']);
        }

        if ($request->quantity < $variant->min_order_qty) {
            return response()->json(['msg' => 'For this product you need to add atleast ' . $variant->min_order_qty . ' quantity', 'status' => 'fail']);
        }

        if($variant->max_order_qty != ''){
            if ($request->quantity > $variant->max_order_qty) {
                return response()->json(['msg' => 'For this product you can add maximum ' . $variant->max_order_qty . ' quantity','status' => 'fail']);
            }
        }

        $price = new ProductController;

        $price = $price->getprice($variant->products, $variant)->getData();

        $cartrow->qty = $request->quantity;

        $cartrow->price_total = (float) $price->mainprice * $request->quantity;
        $cartrow->semi_total = (float) $price->offerprice * $request->quantity;

        $cartrow->shipping = $this->getShipping($request->quantity, $variant);

        $cartrow->updated_at = now();

        $cartrow->save();

        $rates = new CurrencyController;

        $rate = $rates->fetchRates($request->currency)->getData();

        $cart = array(
            'products' => $this->cartproducts($request->currency),
            'subtotal' => (float) sprintf("%.2f", $this->cartTotal()->getData()->subtotal * $rate->exchange_rate),
            'shipping' => (float) sprintf("%.2f", $this->cartTotal()->getData()->shipping * $rate->exchange_rate),
            'coupan_discount' => (float) $this->getTotalDiscount(),
            'grand_total' => (float) sprintf("%.2f", $this->cartTotal()->getData()->grandTotal * $rate->exchange_rate),
            'currency' => $rate->code,
            'symbol' => $rate->symbol,
            'appliedCoupan' => $this->appliedCoupan($rate) != null ? $this->appliedCoupan($rate)->getData() : null,
            'offers' => $this->getOffers($rate),
        );

        return response()->json($cart, 200);
    }

    public function cartItemRemove(Request $request)
    {

        if (Auth::check()) {

            if (!$request->cartid) {
                return response()->json(['msg' => 'Cart id is required','status' => 'fail']);
            }

            $row = Cart::find($request->cartid);

            if (!$row) {
                return response()->json(['msg' => 'Cart item not found !','status' => 'fail']);
            }

            $row->delete();

            return response()->json([ 'msg' =>  'Item is removed from your cart !','status' => 'success']);

        } 

    }

    public function clearCart()
    {

        if (Auth::check()) {

            auth()->user()->cart()->delete();

            return response()->json(['msg' => 'Cart is now empty !','status' => 'success']);

        } else {
            return response()->json(['msg' => 'Log in to continue...','status' => 'success']);
        }

    }

    public function getTotalDiscount()
    {

        $totaldiscount = 0;

        foreach (Auth::user()->cart as $cart) {

            if ($cart->semi_total != 0) {

                $totaldiscount = $totaldiscount + $cart->disamount;

            } else {

                $totaldiscount = $totaldiscount + $cart->disamount;

            }

        }

        return sprintf("%.2f",$totaldiscount);
    }

    public function getOffers($rate){

        $content = array();
       
        foreach(Auth::user()->cart as $cart){

            $coupans = Coupan::where('link_by','cart')->whereDate('expirydate','>',Carbon::now())->get();

            $productcoupans = Coupan::where('pro_id',$cart->product->id)->whereDate('expirydate','>',Carbon::now())->get();

            $productcategorycoupans = Coupan::where('cat_id',$cart->product->category_id)->get();

            $content = array();

            foreach($coupans as $c){

                if($c->maxusage != 0){

                    if($c->pro_id != null){

                        $linkedto = array(
                            'id' => $c->product->id,
                            'name' => $c->product->getTranslations('name'),
                            'appliedon' => $c->link_by,
                        );
    
                    }elseif($c->cat_id != null){
    
                        $linkedto = array(
    
                            'id' => $c->cate->id,
                            'name' => $c->cate->getTranslations('title'),
                            'appliedon' => $c->link_by,
                        );
    
                    }else{
                        $linkedto = null;
                    }

                    $content[] = array(
                        'coupanid' => $c->id,
                        'code' => $c->code,
                        'discount' => $c->distype == 'fix' ? (float) sprintf("%.2f",$c->amount * $rate->exchange_rate) : (int) $c->amount ,
                        'discount_type' => $c->distype,
                        'minamount' =>  (float) sprintf("%.2f",$c->minamount * $rate->exchange_rate),
                        'is_login' => $c->is_login,
                        'description' => $c->description,
                        'linked_to' =>  $linkedto,
                        'offertext' => $this->findOfferText($c,$rate)->getData()->offerText != '' ? $this->findOfferText($c,$rate)->getData()->offerText : null,
                        'validationtext' => $this->findOfferText($c,$rate)->getData()->validationText != null ? $this->findOfferText($c,$rate)->getData()->validationText : null,
                    );

                }
            }

            foreach($productcoupans as $c1){

                if($c1->pro_id != null){

                    $linkedto = array(
                        'id' => $c1->product->id,
                        'name' => $c1->product->getTranslations('name'),
                        'appliedon' => $c1->link_by,
                    );

                }elseif($c1->cat_id != null){

                    $linkedto = array(

                        'id' => $c1->cate->id,
                        'name' => $c1->cate->getTranslations('title'),
                        'appliedon' => $c1->link_by,
                    );

                }else{
                    $linkedto = null;
                }

                $content[] = array(
                    'coupanid' => $c1->id,
                    'code' => $c1->code,
                    'discount' => $c1->distype == 'fix' ? (float) sprintf("%.2f",$c1->amount * $rate->exchange_rate) : (int) $c1->amount ,
                    'discount_type' => $c1->distype,
                    'minamount' =>  (float) sprintf("%.2f",$c1->minamount * $rate->exchange_rate),
                    'is_login' => $c1->is_login,
                    'description' => $c1->description,
                    'linked_to' => $linkedto,
                    'offertext' => $this->findOfferText($c1,$rate)->getData()->offerText != '' ? $this->findOfferText($c1,$rate)->getData()->offerText : null,
                    'validationtext' => $this->findOfferText($c1,$rate)->getData()->validationText != null ? $this->findOfferText($c1,$rate)->getData()->validationText : null,
                );

            }

            foreach($productcategorycoupans as $c2){

                if($c2->pro_id != null){

                    $linkedto = array(
                        'id' => $c2->product->id,
                        'name' => $c2->product->getTranslations('name'),
                        'appliedon' => $c2->link_by,
                    );

                }elseif($c2->cat_id != null){

                    $linkedto = array(

                        'id' => $c2->cate->id,
                        'name' => $c2->cate->getTranslations('title'),
                        'appliedon' => $c2->link_by,
                    );

                }else{
                    $linkedto = null;
                }

                $content[] = array(
                    'coupanid' => $c2->id,
                    'code' => $c2->code,
                    'discount' => $c2->distype == 'fix' ? (float) sprintf("%.2f",$c2->amount * $rate->exchange_rate) : (int) $c2->amount ,
                    'discount_type' => $c2->distype,
                    'minamount' =>  (float) sprintf("%.2f",$c2->minamount * $rate->exchange_rate),
                    'is_login' => $c2->is_login,
                    'description' => $c2->description,
                    'linked_to' => $linkedto,
                    'offertext' => $this->findOfferText($c2,$rate)->getData()->offerText != '' ? $this->findOfferText($c2,$rate)->getData()->offerText : null,
                    'validationtext' => $this->findOfferText($c2,$rate)->getData()->validationText != null ? $this->findOfferText($c2,$rate)->getData()->validationText : null,
                );

            }

            

        }

        return $content = array_unique($content, SORT_REGULAR);
        
    }

    public function findOfferText($c,$rate){

        $offerText = array();

        $validationText = array();

        if($c->distype == 'fix'){

            $offerText[]['text'] = 'Get flat '.$rate->symbol.sprintf("%.2f",$c->amount * $rate->exchange_rate).' off';
            
        }

        if($c->distype == 'per'){
            $offerText[]['text'] = 'Get '.$c->amount.'% off';
        }

        if($c->minamount != null){
            $validationText[]['text'] = 'Valid on orders above '.$rate->symbol. sprintf("%.2f",$c->minamount * $rate->exchange_rate);
        }

        if($c->is_login == 1){
           
            $validationText[]['text'] = 'Offer applicable for registered users only.';
        }

       return response()->json([
           'c' => $c,
           'offerText' => $offerText,
           'validationText' => $validationText
       ]);

    } 
    
    public function appliedCoupan($rate){

            $cpn = Cart::getCoupanDetail();

            if($cpn){

                if($cpn->pro_id != null){

                    $linkedto = array(
                        'id' => $cpn->product->id,
                        'name' => $cpn->product->getTranslations('name'),
                        'appliedon' => $cpn->link_by,
                    );

                }elseif($cpn->cat_id != null){

                    $linkedto = array(

                        'id' => $cpn->cate->id,
                        'name' => $cpn->cate->getTranslations('title'),
                        'appliedon' => $cpn->link_by,
                    );

                }else{
                    $linkedto = null;
                }

    
                $offerText = array();
    
                $validationText = array();
        
                if($cpn->distype == 'fix'){
        
                    $offerText[]['text'] = 'Get flat '.$rate->symbol.sprintf("%.2f",$cpn->amount * $rate->exchange_rate).' off';
                    
                }
        
                if($cpn->distype == 'per'){
                    $offerText[]['text'] = 'Get '.$cpn->amount.'% off';
                }
        
                if($cpn->minamount != null){
                    $validationText[]['text'] = 'Valid on orders above '.$rate->symbol. sprintf("%.2f",$cpn->minamount * $rate->exchange_rate);
                }
        
                if($cpn->is_login == 1){
                   
                    $validationText[]['text'] = 'Offer applicable for registered users only.';
                }
    
                return response()->json([
                    'coupanid' => $cpn->id,
                    'code' => $cpn->code,
                    'discount' => $cpn->distype == 'fix' ? (float) sprintf("%.2f",$cpn->amount * $rate->exchange_rate) : (int) $cpn->amount ,
                    'discount_type' => $cpn->distype,
                    'minamount' => (float) sprintf("%.2f",$cpn->minamount * $rate->exchange_rate),
                    'is_login' => $cpn->is_login,
                    'description' => $cpn->description,
                    'linked_to' => $linkedto,
                    'offertext' => $offerText,
                    'validationText' => $validationText
                ]);
            }
    }

}
