<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Adv;
use App\Allcity;
use App\Allstate;
use App\Blog;
use App\Brand;
use App\Category;
use App\CategorySlider;
use App\Commission;
use App\CommissionSetting;
use App\Country;
use App\Faq;
use App\FooterMenu;
use App\FrontCat;
use App\Genral;
use App\Grandcategory;
use App\Hotdeal;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Controller;
use App\Menu;
use App\Page;
use App\Product;
use App\ProductAttributes;
use App\ProductValues;
use App\Slider;
use App\SpecialOffer;
use App\Subcategory;
use App\Testimonial;
use App\UserReview;
use App\UserWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class MainController extends Controller
{

    public function homepage(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'currency' => 'required|max:3|min:3',
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

        $item = array();

        $content = array();

        /** List app settings */
        $response = $this->appSettings();

        $response = $response->getData();

        $appheader = array(
            'name' => 'appheader',
            'logopath' => $response->logopath,
            'logo' => $response->logo,
            'current_lang' => app()->getLocale(),
            'current_time' => date('Y-m-d H:i:s')
        );
        /** End */

        /** Sidebar Categories */
        $response = $this->sidebarcategories($content);

        $categories = array(
            'name' => 'categories',
            'layout' => 'vertical',
            'enable' => true,
            'path' => url('/images/category/'),
            'items' => $response,
        );
        /** End */

        /** Specialoffers products */
        $response = $this->specialoffer($content);
        /** End */

        $specialoffers = array(
            'layout' => 'vertical',
            'name' => 'specialoffers',
            'enable' => true,
            'path' => url('/variantimages/thumbnails/'),
            'items' => $response,
        );

        /** Getting Sliders */

        $response = $this->slider($content);

        /** End */

        $sliders = array(
            'name' => 'slider',
            'layout' => 'vertical',
            'autoslide' => true,
            'enable' => true,
            'path' => url('images/slider'),
            'items' => $response,
        );

        /** Top categories */

        $response = $this->topcategories($content);

        $topcategories = array(
            'name' => 'topcategories',
            'layout' => 'vertical',
            'enable' => true,
            'path' => url('/images/category/'),
            'items' => $response,
        );

        /** Recent Products with Categories */

        $response = $this->recentProducts($content);

        $recentProducts = array(
            'name' => 'newProducts',
            'layout' => 'vertical',
            'enable' => true,
            'path' => url('variantimages/thumbnails/'),
            'items' => $response,
        );

        
        // /** Getting Blogs */


       $blogs = array(
            'name' => 'blogs',
            'layout' => 'vertical',
            'enable' => true,
            'path' => url('/images/blog/'),
            'items' => $this->gettingBlogs($content = array())
        );

        // Final Response //

        $homepage = [
            'appheaders' => $appheader,
            'categories' => $categories,
            'specialoffers' => $specialoffers,
            'sliders' => $sliders,
            'TwoEqualAdvertise' => $this->advertise('abovenewproduct', 'Two non equal image layout') != null ? $this->advertise('abovenewproduct', 'Two non equal image layout') : null,
            'hotdeals' => $this->hotdeals($request, $content),
            'featuredProducts' => $this->featuredProducts($content),
            'ThreeEqualAdvertise' => $this->advertise('afterfeaturedproduct', 'Three Image Layout') != null ? $this->advertise('afterfeaturedproduct', 'Three Image Layout') : null,
            'topCatgories' => $topcategories,
            'SingleAdvertise' => $this->advertise('abovelatestblog', 'Single Image Layout') != null ? $this->advertise('abovelatestblog', 'Single Image Layout') : null,
            'brands' => $this->brandSlider($request),
            'TwoNonEqualAdvertise' => $this->advertise('abovenewproduct', 'Two non equal image layout') != null ? $this->advertise('abovenewproduct', 'Two non equal image layout') : null,
            'blogs' => $blogs,
            'newProducts' => $this->tabbedProducts(),
        ];

        return response()->json($homepage, 200);

    }

    public function sidebarcategories($content)
    {

        $categories = Category::orderBy('position', 'ASC')->select('title as title', 'id', 'image', 'icon')->get();

        foreach ($categories as $key => $cat) {
            $content[] = array(
                'id' => $cat->id,
                'title' => $cat->getTranslations('title'),
                'icon' => $cat->icon,
                'image' => $cat->image,
                'url' => url('/api/category/' . $cat->id),
            );
        }

        return $content;
    }

    public function brandSlider($request)
    {

        $content = array();

        $brands = Brand::where('status', '=', '1')->where('show_image', '=', 1)->get();

        $saleT = new BrandController;

       
       
        foreach ($brands as $brand) {
            $content[] = array(
                'id' => $brand['id'],
                'name' => $brand['name'],
                'image' => $brand['image'] ?? null,
                'image_path' => url('images/brands/'),
                'url' => url('/brands/'.$brand['id'].'/products'),
                'sale_text' => $brand->products->count() > 0 ? $saleT->brandprices($request->currency,$brand) : null
            );
        }

        return $content;

    }

    public function advertise($position, $type)
    {

        $content = array();

        $adv = Adv::where('position', $position)->where('layout', $type)->get();

        foreach ($adv as $ad) {

            if ($type == 'Three Image Layout') {

                $linkby = '';

                if ($ad->cat_id1 != '') {
                    $linkby = url('api/category/' . $ad->cat_id1);
                } elseif ($ad->pro_id1 != '') {
                    $linkby = url('api/details/' . $ad->pro_id1 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                } elseif ($ad->url1 != '') {
                    $linkby = $ad->url1;
                }

                $linkby2 = '';

                if ($ad->cat_id2 != '') {
                    $linkby2 = url('api/category/' . $ad->cat_id2);
                } elseif ($ad->pro_id2 != '') {
                    $linkby2 = url('api/details/' . $ad->pro_id2 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                } elseif ($ad->url2 != '') {
                    $linkby2 = $ad->url2;
                }

                $linkby3 = '';

                if ($ad->cat_id3 != '') {
                    $linkby3 = url('api/category/' . $ad->cat_id3);
                } elseif ($ad->pro_id3 != '') {
                    $linkby3 = url('api/details/' . $ad->pro_id3 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                } elseif ($ad->url3 != '') {
                    $linkby3 = $ad->url3;
                }

                $content[] = array(
                    'adimagepath' => url('images/layoutads'),
                    'image1' => $ad->image1,
                    'image2' => $ad->image2,
                    'image3' => $ad->image3,
                    'image1linkby' => $linkby,
                    'image2linkby' => $linkby2,
                    'image3linkby' => $linkby3,
                );

            }

            if ($type == 'Two non equal image layout') {

                $linkby = '';

                if ($ad->cat_id1 != '') {
                    $linkby = url('api/category/' . $ad->cat_id1);
                } elseif ($ad->pro_id1 != '') {
                    $linkby = url('api/details/' . $ad->pro_id1 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                } elseif ($ad->url1 != '') {
                    $linkby = $ad->url1;
                }

                $linkby2 = '';

                if ($ad->cat_id2 != '') {
                    $linkby2 = url('api/category/' . $ad->cat_id2);
                } elseif ($ad->pro_id2 != '') {
                    $linkby2 = url('api/details/' . $ad->pro_id2 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                } elseif ($ad->url2 != '') {
                    $linkby2 = $ad->url2;
                }

                $content[] = array(
                    'adimagepath' => url('images/layoutads'),
                    'image1' => $ad->image1,
                    'image2' => $ad->image2,
                    'image1linkby' => $linkby,
                    'image2linkby' => $linkby2,
                );

            }

            if ($type == 'Two equal image layout') {

                $linkby = '';

                if ($ad->cat_id1 != '') {
                    $linkby = url('api/category/' . $ad->cat_id1);
                } elseif ($ad->pro_id1 != '') {
                    $linkby = url('api/details/' . $ad->pro_id1 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                } elseif ($ad->url1 != '') {
                    $linkby = $ad->url1;
                }

                $linkby2 = '';

                if ($ad->cat_id2 != '') {
                    $linkby2 = url('api/category/' . $ad->cat_id2);
                } elseif ($ad->pro_id2 != '') {
                    $linkby2 = url('api/details/' . $ad->pro_id2 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                } elseif ($ad->url2 != '') {
                    $linkby2 = $ad->url2;
                }

                $content[] = array(
                    'adimagepath' => url('images/layoutads'),
                    'image1' => $ad->image1,
                    'image2' => $ad->image2,
                    'image1linkby' => $linkby,
                    'image2linkby' => $linkby2,
                );

            }

            if ($type == 'Single image layout') {

                $linkby = '';

                if ($ad->cat_id1 != '') {
                    $linkby = url('api/category/' . $ad->cat_id1);
                } elseif ($ad->pro_id1 != '') {
                    $linkby = url('api/details/' . $ad->pro_id1 . '/' . $ad->product->subvariants->where('def', 1)->first()->id . '/');
                } elseif ($ad->url1 != '') {
                    $linkby = $ad->url1;
                }

                $content[] = array(
                    'adimagepath' => url('images/layoutads'),
                    'image1' => $ad->image1,
                    'image1linkby' => $linkby,
                );

            }

        }

        return $content;

    }

    public function appSettings()
    {

        $settings = Genral::first();

        if (isset($settings)) {
            return response()->json(['logo' => $settings->logo, 'logopath' => url('/images/genral/')]);
        }
    }

    public function slider($content)
    {

        $sliders = Slider::where('status', '=', '1')->get();

        foreach ($sliders as $key => $slider) {

            $type = '';

            if ($slider->link_by == 'cat') {

                $type = 'category';

            } elseif ($slider->link_by == 'sub') {
                $type = 'subcategory';
            } elseif ($slider->link_by == 'url') {
                $type = 'subcategory';
            } else {
                $type = 'None';
            }

            $id = '';

            if ($slider->link_by == 'cat') {

                $id = $slider->category_id;

            } elseif ($slider->link_by == 'sub') {
                $id = $slider->child;
            } elseif ($slider->link_by == 'url') {
                $id = $slider->url;
            }

            $content[] = array(

                'image' => $slider->image,
                'linkedTo' => $type,
                'linked_id' => $id,
                'topheading' => $slider->getTranslations('topheading'),
                'headingtextcolor' => $slider->headingtextcolor,
                'heading' => $slider->getTranslations('heading'),
                'subheadingcolor' => $slider->subheadingcolor,
                'buttonname' => $slider->getTranslations('buttonname'),
                'btntextcolor' => $slider->btntextcolor,
                'btnbgcolor' => $slider->btnbgcolor,
                'moredescription' => $slider->moredesc != null ? $slider->moredesc : 'Not found',
                'descriptionTextColor' => $slider->moredesccolor,
                'status' => $slider->status,
            );

        }

        return $content;
    }

    public function tabbedProducts(){

        $tabbed = array();

        $frontcat = FrontCat::first();

        if(isset($frontcat) && $frontcat->name != '' && $frontcat->status == '1'){
            $tabbed[] = array(
                'tabname' => array(
                    'en' => __("ALL")
                ),
                'products' => $this->recentProducts($content = array()) != NULL ? $this->recentProducts($content = array()) : 'No Products found'
            );
            
            foreach(explode(',',$frontcat->name) as $name){

                $category = Category::find($name);
                
                if(isset($category)){

                    $tabbed[] = array(
                        'tabname' => $category->getTranslations('title'),
                        'products' => $this->categoryproducts($category) != NULL ? $this->categoryproducts($category) : 'No Product found !'
                    );

                }
            }

        }

        return $tabbed;
    }

    public function recentProducts($content)
    {

        $products = Product::orderBy('id', 'DESC')->take(20)->get();

        foreach ($products as $product) {
            if ($product->subvariants->count() > 0) {

                $attributeName = array();

                foreach ($product->subvariants as $orivar) {

                    $variant = $this->getVariant($orivar);

                    $variant = $variant->getData();

                    array_push($attributeName, $variant->attrName);

                    $attributeName = array_unique($attributeName);

                    $price = $this->getprice($product, $orivar)->getData();

                    $rating = $this->getproductrating($product);

                    if ($this->getprice($product, $orivar)->getData()->offerprice != '0') {
                        $mp = sprintf("%.2f", $this->getprice($product, $orivar)->getData()->mainprice);
                        $op = sprintf("%.2f", $this->getprice($product, $orivar)->getData()->offerprice);

                        $getdisprice = $mp - $op;

                        $discount = $getdisprice / $mp;

                        $offamount = $discount * 100;
                    } else {
                        $offamount = 0;
                    }

                    $reviews = new ProductController;

                    $tag = '';
                    $tagbgcolor = '';

                    if($product->featured == '1') { 
                        $tag = __('staticwords.Hot');
                        $tagbgcolor = '#FF585D';
                    }elseif($product->offer_price != '0'){
                        $tag = __('staticwords.Sale');
                        $tagbgcolor = '#2940B0';
                    }else{
                        $tag =  __('staticwords.New');
                        $tagbgcolor = '#5D6276';
                    }

                    $wishlist = new WishlistController;


                    $content[] = array(
                        'productid' => $product->id,
                        'variantid' => $orivar->id,
                        'productname' => $product->getTranslations('name'),
                        'description' => array_map(function ($v) {
                            return trim(strip_tags($v));
                        }, $product->getTranslations('des')),
                        'mainprice' => round($price->mainprice * $this->rate->exchange_rate,2),
                        'offerprice' =>  round($price->offerprice * $this->rate->exchange_rate,2),
                        'pricein' => $this->rate->code,
                        'symbol' => $this->rate->symbol,
                        'rating' => (double) $rating,
                        'review' => (int) $reviews->getProductReviews($product)->count(),
                        'thumbnail' => $orivar->variantimages->main_image,
                        'thumbnail_path' => url('/variantimages/thumbnails'),
                        'off_in_percent' => (int) round($offamount),
                        'tax_info' => $product->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes"),
                        'tag' => $tag,
                        'tag_bg_color' => $tagbgcolor,
                        'is_in_wishlist' => $wishlist->isItemInWishlist($orivar)
                    );

                  

                }
            }
        }

        return $content;
    }

    public function categoryproducts($category){

        $content = array();

        $products = Product::orderBy('id', 'DESC')->where('category_id','=',$category->id)->take(20)->get();

        foreach ($products as $product) {
            if ($product->subvariants->count() > 0) {

                $attributeName = array();

                foreach ($product->subvariants as $orivar) {

                    $variant = $this->getVariant($orivar);

                    $variant = $variant->getData();

                    array_push($attributeName, $variant->attrName);

                    $attributeName = array_unique($attributeName);

                    $price = $this->getprice($product, $orivar)->getData();

                    $rating = $this->getproductrating($product);

                    if ($this->getprice($product, $orivar)->getData()->offerprice != '0') {
                        $mp = sprintf("%.2f", $this->getprice($product, $orivar)->getData()->mainprice);
                        $op = sprintf("%.2f", $this->getprice($product, $orivar)->getData()->offerprice);

                        $getdisprice = $mp - $op;

                        $discount = $getdisprice / $mp;

                        $offamount = $discount * 100;
                    } else {
                        $offamount = 0;
                    }

                    $reviews = new ProductController;

                    $wishlist = new WishlistController;

                    $tag = '';
                    $tagbgcolor = '';

                    if($product->featured == '1') { 
                        $tag = __('staticwords.Hot');
                        $tagbgcolor = '#FF585D';
                    }elseif($product->offer_price != '0'){
                        $tag = __('staticwords.Sale');
                        $tagbgcolor = '#2940B0';
                    }else{
                        $tag =  __('staticwords.New');
                        $tagbgcolor = '#5D6276';
                    }


                    $content[] = array(
                        'productid' => $product->id,
                        'variantid' => $orivar->id,
                        'productname' => $product->getTranslations('name'),
                        'description' => array_map(function ($v) {
                            return trim(strip_tags($v));
                        }, $product->getTranslations('des')),
                        'mainprice' => round($price->mainprice * $this->rate->exchange_rate,2),
                        'offerprice' =>  round($price->offerprice * $this->rate->exchange_rate,2),
                        'pricein' => $this->rate->code,
                        'symbol' => $this->rate->symbol,
                        'rating' => (double) $rating,
                        'review' => (int) $reviews->getProductReviews($product)->count(),
                        'thumbnail' => $orivar->variantimages->main_image,
                        'thumbnail_path' => url('/variantimages/thumbnails'),
                        'off_in_percent' => (int) round($offamount),
                        'tax_info' => $product->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes"),
                        'tag' => $tag,
                        'tag_bg_color' => $tagbgcolor,
                        'is_in_wishlist' => $wishlist->isItemInWishlist($orivar)
                    );

                  

                }
            }
        }

        return $content;

    }

    public function topcategories($content)
    {

        $topcats = CategorySlider::first();

        if ($topcats && $topcats->category_ids !='') {

            foreach ($topcats->category_ids as $categoryid) {

                $category = Category::where('id', $categoryid)->where('status', '1')->first();

                if ($category) {

                    $content[] = array(
                        'id' => $category->id,
                        'name' => $category->getTranslations('title'),
                        'description' => array_map(function ($v) {
                            return trim(strip_tags($v));
                        }, $category->getTranslations('description')),
                        'image' => $category->image,
                        'icon' => $category->icon,
                        'url' => url('/api/category/' . $category->id),
                    );

                }

            }

        }

        return $content;

    }

    public function categories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
			}
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        $categories = Category::orderBy('position', 'ASC')->get();
        return response()->json(['categories' => $categories]);
    }

    public function gettingBlogs($content)
    {

        $blogs = Blog::where('status', '1')->get();

        foreach ($blogs as $blog) {

            $content[] = array(
                'title' => $blog->getTranslations('heading'),
                'des' =>  array_map(function ($v) {
                    return trim(strip_tags($v));
                }, $blog->getTranslations('des')),
                'author' => $blog->getTranslations('user'),
                'image' => $blog->image,
                'created_on' => date('M jS, Y',strtotime($blog->created_at)),
                'url' => url('/api/blog/post/' . $blog->slug),
            );

        }

        return $content;
    }

    public function featuredProducts($content)
    {

        $featuredproducts = Product::where('featured', '=', '1')->orderBy('id', 'DESC')->take(20)->get();

        foreach ($featuredproducts as $product) {
            if ($product->subvariants) {

                foreach ($product->subvariants as $orivar) {

                    if ($orivar->def == '1') {
                        $variant = $this->getVariant($orivar);

                        $variant = $variant->getData();

                        $mainprice = $this->getprice($product, $orivar);

                        $price = $mainprice->getData();

                        $rating = $this->getproductrating($product);

                        $mp = sprintf("%.2f", $this->getprice($product, $orivar)->getData()->mainprice);

                        $op = sprintf("%.2f", $this->getprice($product, $orivar)->getData()->offerprice);

                        $getdisprice = $mp - $op;

                        $discount = $getdisprice / $mp;

                        $offamount = $discount * 100;

                        $wishlist = new WishlistController;

                        $content[] = array(
                            'productid' => $product->id,
                            'variantid' => $orivar->id,
                            'productname' => $product->getTranslations('name'),
                            'description' => array_map(function ($v) {
                                return trim(strip_tags($v));
                            }, $product->getTranslations('des')),
                            'tax_info' => $product->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes"),
                            'mainprice' => (float) sprintf("%.2f", $price->mainprice * $this->rate->exchange_rate),
                            'offerprice' => (float) sprintf("%.2f", $price->offerprice * $this->rate->exchange_rate),
                            'pricein' => $this->rate->code,
                            'symbol' => $this->rate->symbol,
                            'off_percent' => (int) round($offamount),
                            'rating' => (double) $rating,
                            'thumbnail' => $orivar->variantimages->main_image,
                            'thumbnail_path' => url('variantimages/thumbnails'),
                            'is_in_wishlist' => $wishlist->isItemInWishlist($orivar)
                        );
                    }

                }
            }
        }

        return $content;

    }

    public function testimonials($content)
    {

        $testimonials = Testimonial::orderBy('id', 'DESC')->where('status', '1')->get();

        foreach ($testimonials as $value) {

            $content[] = array(
                'name' => $value->getTranslations('name'),
                'des' => $value->getTranslations('des'),
                'designation' => $value->post,
                'rating' => $value->rating,
                'profilepicture' => $value->image,
            );

        }

        return $content;
    }

    public function subcategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
			}
	
		}

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        $categories = Subcategory::orderBy('position', 'ASC')->get();
        return response()->json(['categories' => $categories],200);
    }

    public function childcategories(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Secret Key is required','status' => 'fail']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' =>'Invalid Secret Key !','status' => 'fail']);
        }

        $categories = Grandcategory::orderBy('position', 'ASC')->get();
        return response()->json(['categories' => $categories],200);
    }

    public function getcategoryproduct(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'currency' => 'required|max:3|min:3',
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

        $cat = Category::find($id);

        if (!$cat) {
            return response()->json(['msg' => 'Category not found !','status' => 'fail']);
        }

        if ($cat->status != 1) {
            return response()->json(['msg' => 'Category is not active !','status' => 'fail']);
        }

        $pros = $cat->products;

        $result = array();

        foreach ($pros as $pro) {

            if ($pro->subvariants->count() > 0) {

                foreach ($pro->subvariants as $orivar) {

                    $variant = $this->getVariant($orivar);

                    $variant = $variant->getData();

                    $mainprice = $this->getprice($pro, $orivar);

                    $price = $mainprice->getData();

                    $rating = $this->getproductrating($pro);

                    if ($this->getprice($pro, $orivar)->getData()->offerprice != '0') {
                        $mp = sprintf("%.2f", $this->getprice($pro, $orivar)->getData()->mainprice);
                        $op = sprintf("%.2f", $this->getprice($pro, $orivar)->getData()->offerprice);

                        $getdisprice = $mp - $op;

                        $discount = $getdisprice / $mp;

                        $offamount = $discount * 100;
                    } else {
                        $offamount = 0;
                    }

                    $wishlist = new WishlistController;

                    $review = new ProductController;

                    $result[] = array(
                        'productid' => $pro->id,
                        'productname' => $pro->getTranslations('name'),
                        'variantid' => $orivar->id,
                        'variantname' => $variant->value,
                        'desciption' => array_map(function ($v) {
                            return trim(strip_tags($v));
                        }, $pro->getTranslations('des')),
                        'mainprice' =>  (double) sprintf("%.2f", $this->getprice($pro, $orivar)->getData()->mainprice * $this->rate->exchange_rate),
                        'offerprice' =>  (double) sprintf("%.2f", $this->getprice($pro, $orivar)->getData()->offerprice * $this->rate->exchange_rate),
                        'pricein' => $this->rate->code,
                        'symbol' => $this->rate->symbol,
                        'rating' => (double) $rating,
                        'review' => (int) $review->getProductReviews($pro)->count(),
                        'off_in_percent' => (int) round($offamount),
                        'thumbpath' => url('variantimages/thumbnails/'),
                        'images' => $orivar->variantimages->main_image,
                        'detail_page_url' => url('/api/details/' . $pro->id . '/' . $orivar->id . ''),
                        'is_in_wishlist' => $wishlist->isItemInWishlist($orivar)
                    );

                }

            }

        }

        if (empty($result)) {
            $result[] = 'No Products Found in this category !';
        }

        $category = array(
            'id' => $cat->id,
            'name' => $cat->getTranslations('title'),
            'desciption' => array_map(function ($v) {
                return trim(strip_tags($v));
            }, $cat->getTranslations('description')),
            'icon' => $cat->icon,
            'image' => $cat->image,
            'imagepath' => url('images/grandcategory/'),
        );

        $finalresponse = [

            'category' => $category,
            'products' => $result,

        ];

        return response()->json($finalresponse);

    }

    public function getsubcategoryproduct(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'currency' => 'required||string|max:3|min:3',
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

        $subcat = Subcategory::find($id);

        if (!$subcat) {
            return response()->json(['msg' => 'Subcategory not found !','status' => 'fail']);
        }

        if ($subcat->status != 1) {
            return response()->json(['msg' => 'Subcategory is not active !','status' => 'fail']);
        }

        $pros = $subcat->products;

        $result = array();

        $attributeName = array();

        foreach ($pros as $pro) {

            if ($pro->subvariants->count() > 0) {

                foreach ($pro->subvariants as $orivar) {

                    $variant = $this->getVariant($orivar);

                    $variant = $variant->getData();

                    array_push($attributeName, $variant->attrName);

                    $attributeName = array_unique($attributeName);

                    $mainprice = $this->getprice($pro, $orivar);

                    $price = $mainprice->getData();

                    $rating = $this->getproductrating($pro);

                    if ($this->getprice($pro, $orivar)->getData()->offerprice != '0') {
                        $mp = sprintf("%.2f", $this->getprice($pro, $orivar)->getData()->mainprice);
                        $op = sprintf("%.2f", $this->getprice($pro, $orivar)->getData()->offerprice);

                        $getdisprice = $mp - $op;

                        $discount = $getdisprice / $mp;

                        $offamount = $discount * 100;
                    } else {
                        $offamount = 0;
                    }

                    $review = new ProductController;

                    $wishlist = new WishlistController;

                    $result[] = array(
                        'productid' => $pro->id,
                        'productname' => $pro->getTranslations('name'),
                        'variantid' => $orivar->id,
                        'variantname' => $variant->value,
                        'desciption' => array_map(function ($v) {
                            return trim(strip_tags($v));
                        }, $pro->getTranslations('des')),
                        'mainprice' =>  (double) sprintf("%.2f", $this->getprice($pro, $orivar)->getData()->mainprice * $this->rate->exchange_rate),
                        'offerprice' =>  (double) sprintf("%.2f", $this->getprice($pro, $orivar)->getData()->offerprice * $this->rate->exchange_rate),
                        'pricein' => $this->rate->code,
                        'symbol' => $this->rate->symbol,
                        'rating' => (double) $rating,
                        'review' => (int) $review->getProductReviews($pro)->count(),
                        'off_in_percent' => (int) round($offamount),
                        'thumbpath' => url('variantimages/thumbnails/'),
                        'images' => $orivar->variantimages->main_image,
                        'detail_page_url' => url('/api/details/' . $pro->id . '/' . $orivar->id . ''),
                        'is_in_wishlist' => $wishlist->isItemInWishlist($orivar)
                    );

                }

            }

        }

        if (empty($result)) {
            $result[] = 'No Products Found in this category !';
        }

        $subcategory = array(
            'id' => $subcat->id,
            'name' => $subcat->getTranslations('title'),
            'desciption' => array_map(function ($v) {
                return trim(strip_tags($v));
            }, $subcat->getTranslations('description')),
            'icon' => $subcat->icon,
            'image' => $subcat->image,
            'imagepath' => url('images/grandcategory/'),
        );

        $finalresponse = [

            'subcategory' => $subcategory,
            'products' => $result,

        ];

        return response()->json($finalresponse);

    }

    public function getchildcategoryproduct(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'currency' => 'required|max:3|min:3',
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

        $childcat = Grandcategory::find($id);

        if (!$childcat) {
            return response()->json(['msg' =>  'Childcategory not found !','status' => 'fail']);
        }

        if ($childcat->status != 1) {
            return response()->json(['msg' => 'Childcategory is not active !','status' => 'fail']);
        }

        $pros = $childcat->products;

        $result = array();

        foreach ($pros as $pro) {

            if ($pro->subvariants->count() > 0) {

                foreach ($pro->subvariants as $orivar) {

                    $variant = $this->getVariant($orivar);

                    $variant = $variant->getData();

                    $rating = $this->getproductrating($pro);

                    if ($this->getprice($pro, $orivar)->getData()->offerprice != '0') {
                        $mp = sprintf("%.2f", $this->getprice($pro, $orivar)->getData()->mainprice);
                        $op = sprintf("%.2f", $this->getprice($pro, $orivar)->getData()->offerprice);

                        $getdisprice = $mp - $op;

                        $discount = $getdisprice / $mp;

                        $offamount = $discount * 100;
                    } else {
                        $offamount = 0;
                    }
                    
                    $review = new ProductController;

                    $wishlist = new WishlistController;

                    $result[] = array(
                        'productid' => $pro->id,
                        'productname' => $pro->getTranslations('name'),
                        'variantid' => $orivar->id,
                        'variantname' => $variant->value,
                        'desciption' => array_map(function ($v) {
                            return trim(strip_tags($v));
                        }, $pro->getTranslations('des')),
                        'mainprice' => (double) sprintf("%.2f", $this->getprice($pro, $orivar)->getData()->mainprice * $this->rate->exchange_rate),
                        'offerprice' =>  (double) sprintf("%.2f", $this->getprice($pro, $orivar)->getData()->offerprice * $this->rate->exchange_rate),
                        'pricein' => $this->rate->code,
                        'symbol' => $this->rate->symbol,
                        'rating' => (double) $rating,
                        'review' => (int) $review->getProductReviews($pro)->count(),
                        'off_in_percent' => (int) round($offamount),
                        'thumbpath' => url('variantimages/thumbnails/'),
                        'images' => $orivar->variantimages->main_image,
                        'detail_page_url' => url('/api/details/' . $pro->id . '/' . $orivar->id . ''),
                        'is_in_wishlist' => $wishlist->isItemInWishlist($orivar)
                    );

                }

            }

        }

        if (empty($result)) {
            $result[] = 'No Products Found in this category !';
        }

        $chilcategory = array(
            'id' => $childcat->id,
            'name' => $childcat->getTranslations('title'),
            'desciption' => array_map(function ($v) {
                return trim(strip_tags($v));
            }, $childcat->getTranslations('description')),
            'image' => $childcat->image,
            'imagepath' => url('images/grandcategory/'),
        );

        $finalresponse = [

            'subcategory' => $chilcategory,
            'products' => $result,

        ];

        return response()->json($finalresponse);
    }

    public function hotdeals(Request $request, $content)
    {
        $hotdeals = Hotdeal::where('status', '=', '1')->where('end', '>', date('Y-m-d'))->get();

       

        if (!isset($this->rate)) {
            $rates = new CurrencyController;

            $this->rate = $rates->fetchRates($request->currency)->getData();
        }

        foreach ($hotdeals as $deal) {

            if ($deal->pro->subvariants()->count() > 0 && $deal->pro->status == '1') {

                foreach ($deal->pro->subvariants as $key => $orivar) {

                    if ($orivar->def == '1') {
                        $variant = $this->getVariant($orivar);

                        $variant = $variant->getData();

                        $mainprice = $this->getprice($deal->pro, $orivar);

                        $price = $mainprice->getData();

                        $rating = $this->getproductrating($deal->pro);

                        if ($this->getprice($deal->pro, $orivar)->getData()->offerprice != '0') {
                            $mp = sprintf("%.2f", $this->getprice($deal->pro, $orivar)->getData()->mainprice);
                            $op = sprintf("%.2f", $this->getprice($deal->pro, $orivar)->getData()->offerprice);
    
                            $getdisprice = $mp - $op;
    
                            $discount = $getdisprice / $mp;
    
                            $offamount = $discount * 100;
                        } else {
                            $offamount = 0;
                        }

                        $review = new ProductController;
                        

                        $content[] = array(
                            'start_date' => $deal->start,
                            'end_date' => $deal->end,
                            'variantid' => $orivar->id,
                            'productid' => $deal->pro->id,
                            'productname' => $deal->pro->getTranslations('name'),
                            'mainprice' => (double) sprintf("%.2f", $price->mainprice * $this->rate->exchange_rate),
                            'offerprice' => (double) sprintf("%.2f", $price->offerprice * $this->rate->exchange_rate),
                            'pricein' => $this->rate->code,
                            'symbol' => $this->rate->symbol,
                            'rating' => (double) $rating,
                            'reviews' => (int) $review->getProductReviews($deal->pro)->count(),
                            'off_in_percent' => (int) round($offamount),
                            'thumbnail' => $orivar->variantimages->main_image,
                            'thumbnail_path' => url('variantimages/thumbnails'),
                            'otherimagepath' => url('variantimages/'),
                            'otherimages' => $orivar->variantimages()->select('image1','image2','image3','image4','image5','image6')->get(),
                            'tax_info' =>$deal->pro->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes"),
                            'hotdeal_bg_path' => url('images/hotdeal_backgrounds/'),
                            'hotdeal_bg' => 'default.jpg'
                        );
                    }

                }

            }

        }

        return $content;
    }

    public function specialoffer($content)
    {

        $specialOffers = SpecialOffer::where('status', '=', '1')->get();

        if (empty($specialOffers)) {
            return response()->json('No Specialoffer created !');
        }

        foreach ($specialOffers as $sp) {

            if (isset($sp->pro)) {
                if (isset($sp->pro->subvariants)) {

                    foreach ($sp->pro->subvariants as $key => $orivar) {

                        if ($orivar->def == '1') {
                            $variant = $this->getVariant($orivar);

                            $variant = $variant->getData();

                            $mainprice = $this->getprice($sp->pro, $orivar);

                            $price = $mainprice->getData();

                            $rating = $this->getproductrating($sp->pro);

                            if ($this->getprice($sp->pro, $orivar)->getData()->offerprice != '0') {
                                $mp = sprintf("%.2f", $this->getprice($sp->pro, $orivar)->getData()->mainprice);
                                $op = sprintf("%.2f", $this->getprice($sp->pro, $orivar)->getData()->offerprice);
        
                                $getdisprice = $mp - $op;
        
                                $discount = $getdisprice / $mp;
        
                                $offamount = $discount * 100;
                            } else {
                                $offamount = 0;
                            }

                            $content[] = array(
                                'productname' => $sp->pro->getTranslations('name'),
                                'productid' => $sp->pro->id,
                                'variantid' => $orivar->id,
                                'mainprice' => (double) sprintf("%.2f", $price->mainprice * $this->rate->exchange_rate),
                                'offerprice' => (double) sprintf("%.2f", $price->offerprice * $this->rate->exchange_rate),
                                'pricein' => $this->rate->code,
                                'symbol' => $this->rate->symbol,
                                'rating' => (double) $rating,
                                'thumbnail' => $orivar->variantimages->main_image,
                                'off_in_percent' => (int) round($offamount)
                            );
                        }

                    }

                }
            }

        }

        return $content;
    }

    public function brands(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Secret Key is required','status' => 'fail']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !', 'status' => 'fail']);
        }

        $brand = Brand::where('status', '=', '1')->where('show_image', '=', 1)->get();
        return response()->json($brand);
    }

    public function page(Request $request, $slug)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Secret Key is required','status' => 'fail']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' =>'Invalid Secret Key !', 'status' => 'fail']);
        }

        $page = Page::where('slug', '=', $slug)->first();
        return response()->json($page);

    }

    public function menus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Secret Key is required','status' => 'fail']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        $topmenu = Menu::orderBy('position', 'ASC')->get();

        return response()->json($topmenu);
    }

    public function footermenus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Secret Key is required','status' => 'fail']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        $footermenus = FooterMenu::get();

        return response()->json($footermenus = FooterMenu::get());
    }

    public function userprofile(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Secret Key is required','status' => 'fail']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        if (!Auth::check()) {
            return response()->json(['msg' => "You're not logged in !",'status' => 'fail']);
        } else {
            $user = Auth::user();
            return response()->json($user);
        }

    }

    public function mywallet(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => 'Secret Key is required','status' => 'fail']);
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        if (!Auth::check()) {
            return response()->json(['msg' => "You're not logged in !",'status' => 'fail']);
        }

        $wallet = UserWallet::firstWhere('user_id', '=', Auth::user()->id);
        $wallethistory = $wallet->wallethistory;
        return response()->json(['wallet' => $wallet, 'wallethistory' => $wallethistory]);
    }

    public function getuseraddress(Request $request)
    {
       

        if (!Auth::check()) {
            return response()->json(['msg' => "You're not logged in !",'status' => 'fail'],401);
        }

        $address = array();

        foreach (Auth::user()->addresses->sortByDesc('id') as $key => $ad) {

            $address[] = array(
                'id' => $ad->id,
                'name' => $ad->name,
                'email' => $ad->email,
                'address' => strip_tags($ad->address),
                'type' => $ad->type,
                'phone' => $ad->phone,
                'pin_code' => $ad->pin_code,
                'country' => array(
                    'id' => (int) $ad->country_id,
                    'name' => $ad->getCountry ? $ad->getCountry->nicename : null
                ),
                'state' => array(
                    'id' => (int) $ad->state_id,
                    'name' => $ad->getstate ? $ad->getstate->name : null
                ),
                'city' => array(
                    'id' => (int) $ad->city_id,
                    'name' => $ad->getcity ? $ad->getcity->name : null
                ),
                'defaddress' => $ad->defaddress,
            );
        }

        return response()->json(['address' => $address,'status' => 'success']);
    }

    public function getuserbanks(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
			}
	
		}

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        if (!Auth::check()) {
            return response()->json(['msg' => "You're not logged in !",'status' => 'fail']);
        }

        $userbanklist = Auth::user()->banks;
        return response()->json($userbanklist);
    }

    public function faqs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
			}
	
		}

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        $faqs = Faq::all();

        return response()->json(['faqs' => $faqs]);
    }

    public function listallblog(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();

			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
			}
	
		}

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        $blogs = Blog::orderBy('id', 'DESC')->get();
        return response()->json($blogs);
    }

    public function blogdetail(Request $request, $slug)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
			}
	
		}

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        $blog = Blog::firstWhere('slug', '=', $slug);

        if (!isset($blog)) {
            return response()->json(['msg' => '404 Blog post not found !','status' => 'fail']);
        }

        return response()->json($blog);
    }

    public function myNotifications(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
			}
	
		}

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        if (!Auth::check()) {
            return response()->json(['msg' => "You're not logged in !",'status' => 'fail']);
        }

        $notifications = auth()->user()->unreadNotifications->where('n_type', '!=', 'order_v');

        $notificationsCount = auth()->user()->unreadNotifications->where('n_type', '!=', 'order_v')->count();

        return response()->json(['notifications' => $notifications, 'count' => $notificationsCount]);
    }

    public function getprice($pro, $orivar)
    {

        $convert_price = 0.00;
        $show_price = 0.00;

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

        return response()->json(['mainprice' => sprintf("%.2f", $show_price), 'offerprice' => sprintf("%.2f", $convert_price)]);

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

            return sprintf('%.2f',$overallrating);

        } else {
            return $overallrating = 0;
        }
    }

    public function getVariant($orivar)
    {
        $varcount = count($orivar->main_attr_value);
        $i = 0;
        $othervariantName = null;

        foreach ($orivar->main_attr_value as $key => $orivars) {

            $i++;

            $loopgetattrname = ProductAttributes::where('id', $key)->first()->attr_name;
            $getvarvalue = ProductValues::where('id', $orivars)->first();

            if ($i < $varcount) {
                if (isset($getvarvalue) && strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {
                    if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

                        $othervariantName = $getvarvalue->values . ',';

                    } else {
                        $othervariantName = $getvarvalue->values . $getvarvalue->unit_value . ',';
                    }
                } else {
                    $othervariantName = $getvarvalue->values ?? '';
                }

            } else {

                if (isset($getvarvalue) && strcasecmp($getvarvalue->unit_value, $getvarvalue->values) != 0 && $getvarvalue->unit_value != null) {

                    if ($getvarvalue->proattr->attr_name == "Color" || $getvarvalue->proattr->attr_name == "Colour" || $getvarvalue->proattr->attr_name == "color" || $getvarvalue->proattr->attr_name == "colour") {

                        $othervariantName = $getvarvalue->values;

                    } else {
                        $othervariantName = $getvarvalue->values . $getvarvalue->unit_value;
                    }

                } else {
                    $othervariantName = $getvarvalue->values ?? '';
                }

            }

        }

        return response()->json(['value' => $othervariantName, 'attrName' => $loopgetattrname]);
    }

    public function createaddress(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'phone' => 'required|numeric',
            'pincode' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'defaddress' => 'required|in:1,0',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('name')){
				return response()->json(['msg' => $errors->first('name'), 'status' => 'fail']);
            }

            if($errors->first('email')){
				return response()->json(['msg' => $errors->first('email'), 'status' => 'fail']);
            }

            if($errors->first('address')){
				return response()->json(['msg' => $errors->first('address'), 'status' => 'fail']);
            }

            if($errors->first('phone')){
				return response()->json(['msg' => $errors->first('phone'), 'status' => 'fail']);
            }

            if($errors->first('pincode')){
				return response()->json(['msg' => $errors->first('pincode'), 'status' => 'fail']);
            }

            if($errors->first('country_id')){
				return response()->json(['msg' => $errors->first('country_id'), 'status' => 'fail']);
            }

            if($errors->first('state_id')){
				return response()->json(['msg' => $errors->first('state_id'), 'status' => 'fail']);
            }

            if($errors->first('city_id')){
				return response()->json(['msg' => $errors->first('city_id'), 'status' => 'fail']);
            }

            if($errors->first('defaddress')){
				return response()->json(['msg' => $errors->first('defaddress'), 'status' => 'fail']);
            }
        }

        if ($request->defaddress == 1)
        {
            //Remove any previous default address
            Address::where('user_id', Auth::user()->id)
                ->where('defaddress', '=', 1)
                ->update(['defaddress' => 0]);
        }

        $createdaddress = Auth::user()->addresses()->create([
            'name' => $request->name,
            'address' => $request->address,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->type ?? null,
            'pin_code' => $request->pincode,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'defaddress' => $request->defaddress,
            'user_id' => Auth::user()->id
        ]);

        $address = array(
            'id' => $createdaddress->id,
            'name' => $createdaddress->name,
            'email' => $createdaddress->email,
            'address' => $createdaddress->address,
            'type' => $createdaddress->type,
            'phone' => $createdaddress->phone,
            'pin_code' => $createdaddress->pin_code,
            'country' => array(
                'id' => (int) $createdaddress->country_id,
                'name' => $createdaddress->getCountry ? $createdaddress->getCountry->nicename : null
            ),
            'state' => array(
                'id' => (int) $createdaddress->state_id,
                'name' => $createdaddress->getstate ? $createdaddress->getstate->name : null
            ),
            'city' => array(
                'id' => (int) $createdaddress->city_id,
                'name' => $createdaddress->getcity ? $createdaddress->getcity->name : null
            ),
            'defaddress' => $createdaddress->defaddress,
        );

        return response()->json(['msg' => 'Address created successfully', 'address' => $address,'status' => 'success' ]);

    }

    public function listbillingaddress(){

        $address = array();

        foreach (Auth::user()->billingAddress->sortByDesc('id') as $key => $ad) {

            $address[] = array(
                'id' => $ad->id,
                'name' => $ad->firstname,
                'email' => $ad->email,
                'address' => strip_tags($ad->address),
                'mobile' => (int) $ad->mobile,
                'pincode' => (int) $ad->pincode,
                'type' => $ad->type,
                'country' => array(
                    'id' => (int) $ad->country_id,
                    'name' => $ad->countiess ? $ad->countiess->nicename : null
                ),
                'state' => array(
                    'id' => (int) $ad->state,
                    'name' => $ad->states ? $ad->states->name : null
                ),
                'city' => array(
                    'id' => (int) $ad->city,
                    'name' => $ad->cities ? $ad->cities->name : null
                )
            );
        }

        return response()->json(['billingaddress' =>$address,'status' => 'success']);
    }   

    public function createbillingaddress(Request $request){

       

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'address' => 'required|string',
            'phone' => 'required|numeric',
            'pincode' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('name')){
				return response()->json(['msg' => $errors->first('name'), 'status' => 'fail']);
            }

            if($errors->first('email')){
				return response()->json(['msg' => $errors->first('email'), 'status' => 'fail']);
            }

            if($errors->first('address')){
				return response()->json(['msg' => $errors->first('address'), 'status' => 'fail']);
            }

            if($errors->first('phone')){
				return response()->json(['msg' => $errors->first('phone'), 'status' => 'fail']);
            }

            if($errors->first('pincode')){
				return response()->json(['msg' => $errors->first('pincode'), 'status' => 'fail']);
            }

            if($errors->first('country_id')){
				return response()->json(['msg' => $errors->first('country_id'), 'status' => 'fail']);
            }

            if($errors->first('state_id')){
				return response()->json(['msg' => $errors->first('state_id'), 'status' => 'fail']);
            }

            if($errors->first('city_id')){
				return response()->json(['msg' => $errors->first('city_id'), 'status' => 'fail']);
            }

            if($errors->first('defaddress')){
				return response()->json(['msg' => $errors->first('defaddress'), 'status' => 'fail']);
            }
        }

        $createdaddress = Auth::user()->billingAddress()->create([
            'firstname' => $request->name,
            'email' => $request->email,
            'type' => $request->type ?? null,
            'address' => $request->address,
            'mobile' => $request->phone,
            'pincode' => $request->pincode,
            'country_id' => $request->country_id,
            'state' => $request->state_id,
            'city' => $request->city_id,
            'user_id' => Auth::user()->id
        ]);

        $address = array(
            'id' => $createdaddress->id,
            'name' => $createdaddress->firstname,
            'email' => $createdaddress->email,
            'address' => $createdaddress->address,
            'type' => $createdaddress->type,
            'phone' => $createdaddress->mobile,
            'pincode' => $createdaddress->pincode,
            'country' => array(
                'id' => (int) $createdaddress->country_id,
                'name' => $createdaddress->countiess ? $createdaddress->countiess->nicename : null
            ),
            'state' => array(
                'id' => (int) $createdaddress->state,
                'name' => $createdaddress->states ? $createdaddress->states->name : null
            ),
            'city' => array(
                'id' => (int) $createdaddress->city,
                'name' => $createdaddress->cities ? $createdaddress->cities->name : null
            )
        );

        return response()->json(['msg' => 'Billing address created successfully', 'billingaddress' => $address,'status' => 'success' ]);

    }

    public function listofcountries(Request $request){

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }


        $data = Country::join('allcountry', 'allcountry.iso3', '=', 'countries.country')->select('allcountry.id as id','allcountry.nicename as name')->get();

        return response()->json([
            'countries' => $data,
            'status' => 'success'
        ]);


    }

    public function listofstates(Request $request,$id){

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        $data = Allstate::where('country_id','=',$id)->get();

        return response()->json(['states' => $data,'success' => 'success']);

    }

    public function listofcities(Request $request,$id){

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }
        }

        $key = DB::table('api_keys')->where('secret_key', '=', $request->secret)->first();

        if (!$key) {
            return response()->json(['msg' => 'Invalid Secret Key !','status' => 'fail']);
        }

        $data = Allcity::where('state_id','=',$id)->get();

        return response()->json(['cities' => $data,'status' => 'success']);

    }

    public function searchcity(Request $request){

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'name' => 'required|string'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

            if($errors->first('name')){
				return response()->json(['msg' => $errors->first('name'), 'status' => 'fail']);
            }
        }

        $result = Allcity::where('name', 'LIKE', '%' . $request->name . '%')
        ->get();

        $finalResult = array();

        foreach ($result as $key => $value) {
           $finalResult[] = array(
               'cityid' => $value->id,
               'cityname' => $value->name,
               'pincode' => $value->pincode,
               'stateid' => $value->state ? $value->state->id : null,
               'statename' => $value->state ? $value->state->name : null,
               'countryid' => $value->state->country ? $value->state->country->id : null,
               'countryname' => $value->state->country ? $value->state->country->nicename : null,
           );
        }

        if(count($finalResult) < 1){
            return response()->json(
                [
                    'msg' => 'No result found !',
                    'status' => 'fail'
                ]
                );
        }

        return response()->json($finalResult);

    }

    public function fetchPinCodeAddressForGuest(Request $request){

        $validator = Validator::make($request->all(), [
            'secret' => 'required|string',
            'pincode' => 'required|string'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

            if($errors->first('pincode')){
				return response()->json(['msg' => $errors->first('pincode'), 'status' => 'fail']);
            }
        }

        if (strlen($request->pincode) > 12)
        {

            return response()->json(['msg' => 'Invalid Pincode','status' => 'fail']);

        }

        $term = $request->pincode;

        $result = array();

       

        $queries2 = Allcity::where('pincode', 'LIKE', '%' . $term . '%')->get();

        

        foreach ($queries2 as $value)
        {


            $result[] = [
                'cityid' => $value->id,
                'cityname' => $value->name,
                'pincode' => $value->pincode,
                'stateid' => $value->state ? $value->state->id : null,
                'statename' => $value->state ? $value->state->name : null,
                'countryid' => $value->state->country ? $value->state->country->id : null,
                'countryname' => $value->state->country ? $value->state->country->nicename : null,
            ];

        }

        if(count($result) < 1){
            return response()->json(
                [
                    'msg' => 'No result found !',
                    'status' => 'fail'
                ]
                );
        }

        return response()->json($result);
        
    }

    public function fetchPinCodeAddressForAuthUser(Request $request){

        $validator = Validator::make($request->all(), [
            'pincode' => 'required|string'
        ]);

        if ($validator->fails()) {

            $errors = $validator->errors();
            
			if($errors->first('secret')){
				return response()->json(['msg' => $errors->first('secret'), 'status' => 'fail']);
            }

            if($errors->first('pincode')){
				return response()->json(['msg' => $errors->first('pincode'), 'status' => 'fail']);
            }
        }

        if (strlen($request->pincode) > 12)
        {

            return response()->json(['msg' => 'Invalid Pincode','status' => 'fail']);

        }

        $term = $request->pincode;

        $result = array();

        if (Auth::check())
        {
            $queries = Address::where('user_id', Auth::user()
                ->id)->where('pin_code', 'LIKE', '%' . $term . '%')->get();
        }

        $queries2 = Allcity::where('pincode', 'LIKE', '%' . $term . '%')->get();

        if (Auth::check())
        {
            foreach ($queries as $value)
            {

                $address = strlen($value->address) > 100 ? substr($value->address, 0, 100) . "..." : $value->address;

                $result[] = [
                    'address' => $address,
                    'cityid' => $value->getcity->id,
                    'cityname' => $value->getcity->name,
                    'pincode' => $value->pin_code,
                    'stateid' => $value->getstate ? $value->getstate->id : null,
                    'statename' => $value->getstate ? $value->getstate->name : null,
                    'countryid' => $value->getstate->getCountry ? $value->getstate->getCountry->country->id : null,
                    'countryname' => $value->getstate->getCountry ? $value->getstate->getCountry->country->nicename : null
                ];

            }
        }

        foreach ($queries2 as $value)
        {


            $result[] = [
                'cityid' => $value->id,
                'cityname' => $value->name,
                'pincode' => $value->pincode,
                'stateid' => $value->state ? $value->state->id : null,
                'statename' => $value->state ? $value->state->name : null,
                'countryid' => $value->state->country ? $value->state->country->id : null,
                'countryname' => $value->state->country ? $value->state->country->nicename : null,
            ];

        }

        if(count($result) < 1){
            return response()->json(
                [
                    'msg' => 'No result found !',
                    'status' => 'fail'
                ]
                );
        }

        return response()->json($result);
    }

}
