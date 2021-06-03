<?php

namespace App\Http\Controllers\Api;

use App\Brand;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\MainController;
use Illuminate\Support\Facades\Validator;
use DB;

class BrandController extends Controller
{
    public function getBrandProducts(Request $request, $brandid)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'currency' => 'required|string|max:3|min:3',
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

        $brand = Brand::find($brandid);

       
        if (!$brand) {
            return response(['msg' => 'No brand found with that id !','status' => 'fail']);
        }

        if ($brand->status == 0) {
            return response()->json(['msg' => 'Brand is not active !','status' => 'fail']);
        }



        $brand = array(
            'brandid' => $brand['id'],
            'name' => $brand['name'],
            'image' => $brand['image'] ?? null,
            'image_path' => url('images/brands/'),
            'products' => $this->brandproducts($request,$brand) != null ? $this->brandproducts($request,$brand) : null,
        );

        

        return response()->json($brand);

    }

    public function brandproducts($request,$brand)
    {

        $content = array();

        $rates = new CurrencyController;

        $this->rate = $rates->fetchRates($request->currency)->getData();

        foreach ($brand->products->where('status', '1') as $product) {

        

            if ($product->subvariants()->count() > 0) {

               
                foreach ($product->subvariants as $orivar) {
                    
                   
               
                    if ($orivar->def == 1) {
                        
                        $v = new MainController;

                        $variant = $v->getVariant($orivar);

                        $variant = $variant->getData();

                        $mainprice = $v->getprice($product, $orivar);

                        $price = $mainprice->getData();

                        $rating = $v->getproductrating($product);

                        if ($v->getprice($product, $orivar)->getData()->offerprice != '0') {
                            $mp = sprintf("%.2f", $v->getprice($product, $orivar)->getData()->mainprice);
                            $op = sprintf("%.2f", $v->getprice($product, $orivar)->getData()->offerprice);
    
                            $getdisprice = $mp - $op;
    
                            $discount = $getdisprice / $mp;
    
                            $offamount = $discount * 100;
                        } else {
                            $offamount = 0;
                        }

                        $review = new ProductController;
                        

                        $content[] = array(

                            'variantid' => $orivar->id,
                            'productid' => $product->id,
                            'productname' => $product->getTranslations('name'),
                            'mainprice' => (double) sprintf("%.2f", $price->mainprice * $this->rate->exchange_rate),
                            'offerprice' => (double) sprintf("%.2f", $price->offerprice * $this->rate->exchange_rate),
                            'pricein' => $this->rate->code,
                            'symbol' => $this->rate->symbol,
                            'rating' => (double) $rating,
                            'reviews' => (int) $review->getProductReviews($product)->count(),
                            'off_in_percent' => (int) round($offamount),
                            'thumbnail' => $orivar->variantimages->main_image,
                            'thumbnail_path' => url('variantimages/thumbnails'),
                            'otherimagepath' => url('variantimages/'),
                            'otherimages' => $orivar->images,
                            'tax_info' =>$product->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes"),
                            
                        );
                    }

                }

            }

        }

        return $content;

    }

    public function brandprices($request,$brand){

       

        $offamount_array = array();
        $startprice_array_of = array();
        $startprice_array_mrp = array();

        $rates = new CurrencyController;

        $this->rate = $rates->fetchRates($request)->getData();

        if($brand->products()->count() > 0){
            foreach ($brand->products->where('status', '1') as $product) {

        

                if ($product->subvariants()->count() > 0) {
    
                   
                    foreach ($product->subvariants as $orivar) {
                        
                       
                   
                        if ($orivar->def == 1) {
                            
                            $v = new MainController;
    
                            $variant = $v->getVariant($orivar);
    
                            $variant = $variant->getData();

                            if ($v->getprice($product, $orivar)->getData()->offerprice != '0') {

                                $mp = sprintf("%.2f", $v->getprice($product, $orivar)->getData()->mainprice);
                                $op = sprintf("%.2f", $v->getprice($product, $orivar)->getData()->offerprice);
        
                                $getdisprice = $mp - $op;
        
                                $discount = $getdisprice / $mp;
        
                                $offamount = $discount * 100;

                            } else {
                                $offamount = 0;
                            }
                            
    
                            array_push($offamount_array,$offamount);

                            array_push($startprice_array_of,sprintf("%.2f", $v->getprice($product, $orivar)->getData()->offerprice*$this->rate->exchange_rate));
                            
                            array_push($startprice_array_mrp,sprintf("%.2f", $v->getprice($product, $orivar)->getData()->mainprice*$this->rate->exchange_rate));
                            
                            
                        }
    
                    }
    
                }
    
            }
        }

       
        if(array_sum($offamount_array) == 0){

            if(array_sum($startprice_array_of) == 0){

                if(array_sum($startprice_array_mrp) == 0){
                    return null;
                }else{
                    return 'Starting '.$this->rate->symbol.min($startprice_array_mrp);
                }

            }else{
                return 'Starting '.$this->rate->symbol. ' ' .min($startprice_array_of);
            }

        }else{
           
            return 'Up to '.sprintf("%.2f",max($offamount_array)).'% Off';
        }
        
              
        

    }
}
