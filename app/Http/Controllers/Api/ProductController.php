<?php

namespace App\Http\Controllers\Api;

use App\AddSubVariant;
use App\Allcity;
use App\Commission;
use App\CommissionSetting;
use App\Coupan;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Controller;
use App\Product;
use App\ProductAttributes;
use App\ProductValues;
use App\UserReview;
use App\Wishlist;
use App\WishlistCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    
    public function detailProduct(Request $request, $productid, $variantid)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'currency' => 'required|string|max:3|min:3'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }
            
            if($errors->first('currency')){
				return response()->json(['msg' => $errors->first('currency'), 'status' => 'fail']);
			}
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        $rates = new CurrencyController;

        $this->rate = $rates->fetchRates($request->currency)->getData();

        $product = AddSubVariant::where([
            ['id', '=', $variantid],
            ['pro_id', '=', $productid],
        ])->first();

        if (!$product) {
            return response()->json(['msg' => '404 | No Product Found !','status' => 'fail']);
        }

        $pro = $product->products; // Main Product

        $orivar = $product; //Variant

        $varcount = count($orivar->main_attr_value);
        $var_main = '';
        $i = 0;

        /** Common variants  */

        if(isset($pro->commonvars)){

            foreach($pro->commonvars as $cvar){

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

        /** End */

        /**  Variants */

        $result = array();

        foreach ($pro->subvariants as $key => $othervariant) {

            $varcount = count($othervariant->main_attr_value);
            $var_main;
            $i = 0;
            $othervariantName = null;

            $variants = null;

            foreach ($othervariant->main_attr_value as $key => $orivars) {

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
                    'varvalueid' => $getvarvalue->id,
                    'attr_id' => $loopgetattrname->id,
                    'var_name' => $othervariantName,
                    'attr_name' => $loopgetattrname['attr_name'],
                    'type' => $loopgetattrname['attr_name'] == 'color' || $loopgetattrname['attr_name'] == 'Color' || $loopgetattrname['attr_name'] == 'colour' || $loopgetattrname['attr_name'] == 'Colour' ? 'c' : 's',
                );

            }

            if($this->getprice($pro, $othervariant)->getData()->offerprice != 0){

                $mp = sprintf("%.2f", $this->getprice($pro, $othervariant)->getData()->mainprice*$this->rate->exchange_rate);
                $op = sprintf("%.2f", $this->getprice($pro, $othervariant)->getData()->offerprice*$this->rate->exchange_rate);
    
                $getdisprice = $mp - $op;
    
                $discount = $getdisprice / $mp;
    
                $offamount = $discount * 100;

            }else{

                $offamount = 0;

            }

            $combinations[] = array(
                'id' => $othervariant->id,
                'stock' => $othervariant->stock,
                'mainprice' => (double) sprintf("%.2f",$this->getprice($pro, $othervariant)->getData()->mainprice*$this->rate->exchange_rate),
                'offerprice' => (double) sprintf("%.2f",$this->getprice($pro, $othervariant)->getData()->offerprice*$this->rate->exchange_rate),
                'pricein'    => $this->rate->code,
                'symbol' => $this->rate->symbol,
                'weight' => $othervariant->weight . $othervariant->unitname['short_code'],
                'images' => $othervariant->variantimages,
                'variants' => $variants,
                'off_in_percent' => (int) round($offamount),
                'minorderlimit' => $othervariant->min_order_qty,
                'maxorderlimit' => $othervariant->max_order_qty,
                'default' => $othervariant->def ? "Yes" : "No",
            );

        }

        $result = json_encode($result);

        // Make a PHP array from the JSON string.
        $all_attr = json_decode($result);

        // Only keep unique values, by using array_unique with SORT_REGULAR as flag.
        // We're using array_values here, to only retrieve the values and not the keys.
        // This way json_encode will give us a nicely formatted JSON string later on.
        $attributes = array_values(array_unique($all_attr, SORT_REGULAR));

        if ($product->products->free_shipping == 1) {

            $otherservices[] = array(
                'type' => 'freeshipping',
                'text' => __('staticwords.freedelivery'),
            );

        }

        if ($product->products->return_avbl == 1) {

            $otherservices[] = array(
                'type' => 'return',
                'text' => $product->products->returnPolicy->days . ' ' . __('staticwords.returndays'),
            );

        }

        if ($product->products->codcheck == 1) {

            $otherservices[] = array(
                'type' => 'cod',
                'text' => __('staticwords.podtext'),
            );

        }

        $special_services[] = array(
            'heading' => __('staticwords.FastDelivery'),
            'description' => __('staticwords.fastdtext'),
        );

        $special_services[] = array(
            'heading' => __('staticwords.QualityAssurance'),
            'description' => __('staticwords.qtext'),
        );

        $special_services[] = array(
            'heading' => __('staticwords.PurchaseProtection'),
            'description' => __('staticwords.PayementGatewaytext'),
        );

        $wishlist = new WishlistController;

        $productdetails = [

            'product_id' => $product->products->id,
            'product_name' => $product->products->getTranslations('name'),
            'brand_name' => $product->products->brand->name,
            'store_name' => $product->products->store->name,
            'store_logo_path' => url('/images/store'),
            'store_logo' => $product->products->store->store_logo,
            'store_id' => $product->products->store->id,
            'key_features' => array_map(function ($v) {
                return trim(strip_tags($v));
            }, $product->products->getTranslations('key_features')),
            'description' => array_map(function ($v) {
                return trim(strip_tags($v));
            }, $product->products->getTranslations('des')),
            'tags' => $product->products->tags,
            'rating' => (double) $this->getproductrating($pro),
            'reviews' => (int) $this->getProductReviews($pro)->count(),
            'attributes' => $attributes,
            'videoThumbnail' => $product->video_thumbnail,
            'videoUrl' => $product->video_preview,
            'videoThumburl' => url('images/videothumbnails/'),
            'thumbnail_path' => url('variantimages/thumbanails'),
            'images_path' => url('variantimages'),
            'common_variant' => $common_variant ?? null,
            'combinations' => $combinations,
            'tax_info' => $pro->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes"),
            'other_services' => $otherservices,
            'warranty' => $product->products->w_d . ' ' . $product->products->w_my . ' ' . $product->products->w_type,
            'special_services' => $special_services,
            'coupans' => $this->productCoupans($product->products),
            'comments' => $product->products->comments->where('status', '1'),
            'ratingsAndreviews' => $this->allratings($product->products),
            'is_in_wishlist' => $wishlist->isItemInWishlist($product)
        ];

      

        $maincontroller = new MainController;

        $content = array();

        return response()->json([
            'product' => $productdetails,
            'relatedProducts' => $this->getRelatedProducts($product->products),
            'hotdeals' => $maincontroller->hotdeals($request,$content),
        ], 200);

    }

    public function productCoupans($product){

        $coupans = Coupan::where('link_by','cart')->whereDate('expirydate','>',Carbon::now())->get();

        $productcoupans = Coupan::where('pro_id',$product->id)->whereDate('expirydate','>',Carbon::now())->get();

        $productcategorycoupans = Coupan::where('cat_id',$product->category_id)->get();

        $content = array();

        foreach($coupans as $c){
            $content[] = $c;
        }

        foreach($productcoupans as $c1){
            $content[] = $c1;
        }

        foreach($productcategorycoupans as $c3){
            $content[] = $c3;
        }

        return $content = array_unique($content);

    }

    public function getRelatedProducts($product)
    {

        $content = array();

        if (isset($product->subvariants)) {
            if ($product->relsetting->status == '1') {

                if (isset($product->relproduct)) {

                    foreach ($product->relproduct->related_pro as $relpro) {
                        $relproduct = Product::find($relpro);
                        if ($relproduct->subvariants->count() > 0) {
                            $content[] = array(
                                'variantid' => $relproduct->subvariants->where('def', '=', 1)->first()->id,
                                'productid' => $relproduct->id,
                                'productname' => $relproduct->getTranslations('name'),
                                'price' => $this->getprice($relproduct, $relproduct->subvariants->where('def', '=', 1)->first())->getData(),
                                'rating' => $this->getproductrating($relproduct),
                                'thumbnail' => $relproduct->subvariants->where('def', '=', 1)->first()->variantimages->main_image,
                                'thumbnail_path' => url('variantimages/thumbanails'),
                            );
                        }
                    }

                }

            } else {

                if (isset($product->subcategory->products)) {

                    foreach ($product->subcategory->products as $relpro) {

                        if ($relpro->subvariants->count() > 0) {

                            $content[] = array(
                                'variantid' => $relpro->subvariants->where('def', '=', 1)->first()->id,
                                'productid' => $relpro->id,
                                'productname' => $relpro->getTranslations('name'),
                                'price' => $this->getprice($relpro, $relpro->subvariants->where('def', '=', 1)->first())->getData(),
                                'rating' => $this->getproductrating($relpro),
                                'thumbnail' => $relpro->subvariants->where('def', '=', 1)->first()->variantimages->main_image,
                                'thumbnail_path' => url('variantimages/thumbanails'),
                            );
                        }

                    }

                }

            }
        }

        return $content;

    }

    public function allratings($product)
    {

        $content = array();

        $reviews = $product->reviews->where('status', '1');

        foreach ($reviews as $review) {

            $user_count = count([$review]);
            $user_sub_total = 0;
            $user_review_t = $review->price * 5;
            $user_price_t = $review->price * 5;
            $user_value_t = $review->value * 5;
            $user_sub_total = $user_sub_total + $user_review_t + $user_price_t + $user_value_t;

            $user_count = ($user_count * 3) * 5;
            $rat1 = $user_sub_total / $user_count;

            $content[] = array(
                'rating' => $rat1,
                'user'   => $review->users->name,
                'userid' => $review->users->id,
                'review' => $review->review,
            );

        }

        return $content;

    }

    public function wishlist(Request $request)
    {
         

        $validator = Validator::make($request->all(), [
            'currency' => 'required|max:3|min:3',
        ]);

        if($validator->fails()){
            $error = $validator->errors();

            if($error->first('currency')){
                return response()->json([
                    'msg' => $error->first('currency'),
                    'status' => 'fail'
                ]);
            }
        }

        $data = Wishlist::where('user_id', '=', Auth::user()->id)->where('collection_id','=',NULL)->get();

        $totalitems = count($data);

        $wishlistItem = array();

        foreach ($data as $item) {

                $getvariant = new CartController;

                $mainprice = $this->getprice($item->variant->products, $item->variant);

                $price = $mainprice->getData();

                $rating = $this->getproductrating($item->variant->products);

                $rates = new CurrencyController;

                $rate = $rates->fetchRates($request->currency)->getData();
                // Pushing value in main result

                if ($this->getprice($item->variant->products, $item->variant)->getData()->offerprice != '0') {

                    $mp = sprintf("%.2f", $this->getprice($item->variant->products, $item->variant)->getData()->mainprice);
                    $op = sprintf("%.2f", $this->getprice($item->variant->products, $item->variant)->getData()->offerprice);

                    $getdisprice = $mp - $op;

                    $discount = $getdisprice / $mp;

                    $offamount = $discount * 100;
                } else {
                    $offamount = 0;
                }

                $wishlistItem[] = array(
                    'productid' => $item->variant->products->id,
                    'variantid' => $item->variant->id,
                    'productname' => $item->variant->products->getTranslations('name'),
                    'variant' => $getvariant->variantDetail($item->variant),
                    'thumpath' => url('variantimages/thumbnails/'),
                    'thumbnail' => $item->variant->variantimages->main_image,
                    'price' => (double) sprintf('%.2f', $price->mainprice * $rate->exchange_rate),
                    'offerprice' => (double) sprintf("%.2f", $price->offerprice * $rate->exchange_rate),
                    'stock' => $item->variant->stock != 0 ? "In Stock" : "Out of Stock",
                    'rating' => (double) $rating,
                    'symbol' => $rate->symbol,
                    'off_in_percent' => (int) round($offamount),
                    'tax_info' => $item->variant->products->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes"),
                );

            }


            //Sort in desc order
            rsort($wishlistItem);

        $thumbpath = url('variantimages/thumbnails/');

        return response()->json(['status' => 'success','totalitem' => $totalitems, 'items' => $wishlistItem, 'thumbpath' => $thumbpath]);
    }

    public function additeminWishlist(Request $request,$variantid)
    {

        if (!Auth::guard('api')->check()) {
            return response()->json(['msg' => "Login to add item in wishlist !", 'status' => 'fail']);
        }

        if($variantid){
            $findvariant = AddSubVariant::find($variantid);

            if(!$findvariant){
                return response()->json(['msg' => 'Product not found  !','status' => 'fail']);
            }
        }

        $ifCheck = Wishlist::firstWhere('pro_id', $variantid);

        if ($ifCheck) {
            return response()->json(['msg' => 'Item is already in your wishlist !','status' => 'success']);
        }

       
        $checkadd = Wishlist::create([
            'user_id'    => Auth::guard('api')->user()->id,
            'pro_id'     => $variantid,
            'collection_id' => WishlistCollection::find($request->collection_id)->id ?? null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($checkadd) {
            return response()->json(['msg' => 'Item is added to your wishlist !','status' => 'success']);
        }


    }

    public function removeitemfromWishlist($wishlistid)
    {

        if (!Auth::guard('api')->check()) {
            return response()->json(['msg' => "Login to remove item from wishlist !",'status' => 'fail']);
        }

        $ifCheck = Wishlist::find($wishlistid);

        if ($ifCheck) {
            $ifCheck->delete();
            return response()->json(['msg' => 'Item is removed from your wishlist','status' => 'fail']);
        }

        return response()->json(['msg' => "Wishlist item not found !",'status' => 'fail']);

    }

    public function getprice($pro, $orivar)
    {

        $convert_price = 0;
        $show_price = 0;

        $commision_setting = CommissionSetting::first();

        if ($commision_setting->type == "flat") {

            $commission_amount = $commision_setting->rate;

            if ($commision_setting->p_type == 'f') {

                if ($pro->tax_r != '') {

                    $cit = $commission_amount * $pro->tax_r / 100;
                    $totalprice = $pro->vender_price + $orivar->price + $commission_amount + $cit;
                    $totalsaleprice = $pro->vender_offer_price + $cit + $orivar->price +
                        $commission_amount;

                    if ($pro->vender_offer_price == null) {
                        $show_price = $totalprice;
                    } else {
                        $totalsaleprice;
                        $convert_price = $totalsaleprice == '' ? $totalprice : $totalsaleprice;
                        $show_price = $totalprice;
                    }

                } else {
                    $totalprice = $pro->vender_price + $orivar->price + $commission_amount;
                    $totalsaleprice = $pro->vender_offer_price + $orivar->price + $commission_amount;

                    if ($pro->vender_offer_price == null) {
                        $show_price = $totalprice;
                    } else {
                        $totalsaleprice;
                        $convert_price = $totalsaleprice == '' ? $totalprice : $totalsaleprice;
                        $show_price = $totalprice;
                    }

                }

            } else {

                $totalprice = ($pro->vender_price + $orivar->price) * $commission_amount;

                $totalsaleprice = ($pro->vender_offer_price + $orivar->price) * $commission_amount;

                $buyerprice = ($pro->vender_price + $orivar->price) + ($totalprice / 100);

                $buyersaleprice = ($pro->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                if ($pro->vender_offer_price == null) {
                    $show_price = round($buyerprice, 2);
                } else {
                    round($buyersaleprice, 2);

                    $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                    $show_price = $buyerprice;
                }

            }
        } else {

            $comm = Commission::where('category_id', $pro->category_id)->first();
            if (isset($comm)) {
                if ($comm->type == 'f') {

                    if ($pro->tax_r != '') {

                        $cit = $comm->rate * $pro['tax_r'] / 100;

                        $price = $pro->vender_price + $comm->rate + $orivar->price + $cit;

                        if ($pro->vender_offer_price != null) {
                            $offer = $pro->vender_offer_price + $comm->rate + $orivar->price + $cit;
                        } else {
                            $offer = $pro->vender_offer_price;
                        }

                        if ($pro->vender_offer_price == null) {
                            $show_price = $price;
                        } else {

                            $convert_price = $offer;
                            $show_price = $price;
                        }

                    } else {

                        $price = $pro->vender_price + $comm->rate + $orivar->price;

                        if ($pro->vender_offer_price != null) {
                            $offer = $pro->vender_offer_price + $comm->rate + $orivar->price;
                        } else {
                            $offer = $pro->vender_offer_price;
                        }

                        if ($pro->vender_offer_price == 0 || $pro->vender_offer_price == null) {
                            $show_price = $price;
                        } else {

                            $convert_price = $offer;
                            $show_price = $price;
                        }

                    }

                } else {

                    $commission_amount = $comm->rate;

                    $totalprice = ($pro->vender_price + $orivar->price) * $commission_amount;

                    $totalsaleprice = ($pro->vender_offer_price + $orivar->price) * $commission_amount;

                    $buyerprice = ($pro->vender_price + $orivar->price) + ($totalprice / 100);

                    $buyersaleprice = ($pro->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                    if ($pro->vender_offer_price == null) {
                        $show_price = round($buyerprice, 2);
                    } else {
                        $convert_price = round($buyersaleprice, 2);

                        $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                        $show_price = round($buyerprice, 2);
                    }

                }
            } else {
                $commission_amount = 0;

                $totalprice = ($pro->vender_price + $orivar->price) * $commission_amount;

                $totalsaleprice = ($pro->vender_offer_price + $orivar->price) * $commission_amount;

                $buyerprice = ($pro->vender_price + $orivar->price) + ($totalprice / 100);

                $buyersaleprice = ($pro->vender_offer_price + $orivar->price) + ($totalsaleprice / 100);

                if ($pro->vender_offer_price == null) {
                    $show_price = round($buyerprice, 2);
                } else {
                    $convert_price = round($buyersaleprice, 2);

                    $convert_price = $buyersaleprice == '' ? $buyerprice : $buyersaleprice;
                    $show_price = round($buyerprice, 2);
                }
            }
        }


        return response()->json(['mainprice' => sprintf("%.2f",$show_price), 'offerprice' => sprintf("%.2f",$convert_price)]);

    }

    public function getproductrating($pro)
    {

        $reviews = UserReview::where('pro_id', $pro->id)->where('status', '1')->get();

        if (!empty($reviews[0])) {

            $review_t = 0;
            $price_t = 0;
            $value_t = 0;
            $sub_total = 0;
            $count = UserReview::where('pro_id', $pro->id)->count();

            foreach ($reviews as $review) {
                $review_t = $review->price * 5;
                $price_t = $review->price * 5;
                $value_t = $review->value * 5;
                $sub_total = $sub_total + $review_t + $price_t + $value_t;
            }

            $count = ($count * 3) * 5;
            $rat = $sub_total / $count;
            $ratings_var = ($rat * 100) / 5;

            $overallrating = ($ratings_var / 2) / 10;

            return round($overallrating, 1);

        } else {
            return $overallrating = 0.00;
        }
    }

    public function getProductReviews($pro)
    {

        $reviews = UserReview::where('pro_id', $pro->id)->where('review', '!=', null)->where('status', '1')->get();

        return $reviews;

    }

    public function checkPincode(Request $request){


        $validator = Validator::make($request->all(),[
            'pincode' => 'required|numeric',
            'secret' => 'required'
        ]);

        if($validator->fails()){
            $errors = $validator->errors();
            
			if($errors->first('pincode')){
				return response()->json(['msg' => $errors->first('pincode'), 'status' => 'fail']);
            }
            
            if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
			}
        }


        $avbl_pincode = Allcity::where('pincode', $request->pincode)->first();

        if(!$avbl_pincode){
            return response()->json(['msg' => 'Delivery is not available for selected pincode','status' => 'fail']);
        }

        if (strlen($avbl_pincode) > 12)
        {

            return response()->json(['msg' => 'Invalid Pincode','status' => 'fail']);

        }


        return response()->json([
            'cityid' => $avbl_pincode->id,
            'cityname' => $avbl_pincode->name,
            'stateid' => $avbl_pincode->state->id,
            'statename' => $avbl_pincode->state->name,
            'countryid' => $avbl_pincode->state->country->id,
            'countryname' => $avbl_pincode->state->country->nicename,
            'msg' => 'Delivery is available for selected pincode',
            'status' => 'success'
        ]);
        
    }
}
