<?php

namespace App\Http\Controllers\Web;

use App\AddSubVariant;
use App\Blog;
use App\Cart;
use App\Category;
use App\CategorySlider;
use App\FrontCat;
use App\Genral;
use App\Grandcategory;
use App\Helpers\CategoryUrl;
use App\Helpers\ChidCategoryUrl;
use App\Helpers\ProductUrl;
use App\Helpers\SubcategoryUrl;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CurrencyController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Controller;
use App\Menu;
use App\OfferPopup;
use App\Product;
use App\Slider;
use App\Subcategory;
use App\Testimonial;
use App\Widgetsetting;
use App\Wishlist;
use Avatar;
use GuestCartShipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Mtownsend\ReadTime\ReadTime;
use ProductRating;
use ShippingPrice;

class HomeController extends Controller
{
    public function __construct()
    {


        try{
            
            $this->sellerSystem = Genral::select('vendor_enable')->first();
           
        }catch(\Exception $e){
            
        }
    }

    public function newHomepage()
    {
        require base_path() . '/app/Http/Controllers/price.php';

        $offersettings = OfferPopup::first();

        return view('front.homepage', compact('conversion_rate','offersettings'));
    }

    public function index()
    {

        $lang = session()->get('changed_language');
        $fallback_local = config('translatable.fallback_locale');

        $data = array(
            'lang' => $lang,
            'fallback_local' => $fallback_local,
            'featuredproducts' => $this->featuredProducts(),
            'date' => now(),
            'guest_price' => Genral::first()->login,
            'logged_in' => Auth::check() ? 1 : 0,
        );

        return response()->json($data);

    }

    public function slider()
    {

        $sliders = Slider::where('status', '=', '1')->get();
        

        $sliders = $sliders->map(function ($query) {

            if ($query->link_by == 'cat') {

                $url = CategoryUrl::getURL($query->category_id);

            } elseif ($query->link_by == 'sub') {

                $url = SubcategoryUrl::getURL($query->category_id);

            } elseif ($query->link_by == 'url') {

                $url = ChidCategoryUrl::getURL($query->grand_id);

            } elseif ($query->link_by == 'pro') {

                $url = ProductUrl::getUrl($query->products->subvariants[0]['id'] ?? '#');

            } else {
                $url = '#';
            }

            $content['linkedTo'] = $url;

            $id = '';

            if ($query->link_by == 'cat') {

                $id = $query->category_id;

            } elseif ($query->link_by == 'sub') {

                $id = $query->child;

            } elseif ($query->link_by == 'url') {

                $id = $query->url;

            }

            $content['linked_id'] = $id;

            $content['image'] = url('images/slider/' . $query->image);
            $content['topheading'] = $query->getTranslations('topheading');
            $content['headingtextcolor'] = $query->headingtextcolor;
            $content['heading'] = $query->getTranslations('heading');
            $content['subheadingcolor'] = $query->subheadingcolor;
            $content['buttonname'] = $query->getTranslations('buttonname');
            $content['btntextcolor'] = $query->btntextcolor;
            $content['btnbgcolor'] = $query->btnbgcolor;
            $content['moredescription'] = $query->moredesc != null ? $query->moredesc : 'Not found';
            $content['descriptionTextColor'] = $query->moredesccolor;
            $content['status'] = $query->status;

            return $content;

        });

        $lang = session()->get('changed_language');
        $fallback_local = config('translatable.fallback_locale');

        $enable = Widgetsetting::where('name','=','slider')->first()->home;

        return response()->json(['enable' => $enable ,'sliders' => $sliders, 'lang' => $lang, 'fallbacklang' => $fallback_local]);
    }

    public function blog()
    {

        $blog = Blog::get();
        

        try{
            $blog = $blog->map(function ($q) {
                $q['read_time'] = (new ReadTime($q->des))->get();
                $q['created_on'] = date('M jS, Y', strtotime($q->created_at));
                $q['image'] = url('images/blog/' . $q->image);
                $q['des'] = trim(strip_tags($q->des));
                $q['url'] = route('front.blog.show', $q->slug);
                return $q;
            });
    
            $lang = session()->get('changed_language');
            $fallback_local = config('translatable.fallback_locale');
    
            return response()->json([
                'blogs' => $blog,
                'lang' => $lang,
                'fallbacklang' => $fallback_local,
            ]);
        }catch(\Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function featuredProducts()
    {   
        $sellerSystem = $this->sellerSystem;

        $featuredproducts = Product::with('category')->whereHas('category',function($q){

            $q->where('status','=','1');

        })->with('subcategory')->wherehas('subcategory',function($q){

            $q->where('status','1');

        })->with('vender')->whereHas('vender',function($query) use ($sellerSystem) {
 
            if($sellerSystem->vendor_enable == 1){
                $query->where('status','=','1')->where('is_verified','1');
            }else{
                $query->where('status','=','1')->where('role_id','=','a')->where('is_verified','1');
            }
    
        })->with('store')->whereHas('store',function($query){
    
            return $query->where('status','=','1');
    
        })->with('subvariants')->whereHas('subvariants',function($query){
    
            $query->where('def','=','1');
    
        })->with('subvariants.variantimages')->whereHas('subvariants.variantimages')->where('status','=','1')->where('featured', '=', '1')->orderBy('id', 'DESC')->take(20)->get();
        


        $get_product_data = new MainController;

        $conversion_rate = new CurrencyController;

        $conversion_rate = $conversion_rate->fetchRates(session()->get('currency')['id'])->getData()->exchange_rate;

        $content = array();

        $featuredproducts = $featuredproducts->map(function ($q) use ($get_product_data, $content, $conversion_rate) {

            $orivar = $q->subvariants[0];

            if (isset($orivar)) {

                $variant = $get_product_data->getVariant($orivar);
                $variant = $variant->getData();
                $mainprice = $get_product_data->getprice($q, $orivar);
                $price = $mainprice->getData();
                $rating = $get_product_data->getproductrating($q);

                $content['productid'] = $q->id;
                $content['variantid'] = $orivar->id;
                $content['productname'] = $q->getTranslations('name');

                $content['selling_start_at'] = $q->selling_start_at;

                $content['mainprice'] = (float) sprintf("%.2f", $price->mainprice * $conversion_rate);

                $content['offerprice'] = (float) sprintf("%.2f", $price->offerprice * $conversion_rate);

                $content['rating'] = (double) $rating;
                $content['thumbnail'] = url('variantimages/thumbnails/' . $orivar->variantimages->main_image);
                $content['hover_thumbnail'] = url('variantimages/hoverthumbnail/' . $orivar->variantimages->image2);
                $content['is_in_wishlist'] = $this->isItemInWishlist($orivar);
                $content['stock'] = $orivar->stock;
                $content['featured'] = $q->featured;
                $content['rating'] = ProductRating::getReview($q);
                $content['pricein'] = session()->get('currency')['id'];
                $content['symbol'] = session()->get('currency')['value'];
                $content['position'] = session()->get('currency')['position'];
                $content['cartURL'] = route('add.cart.vue', ['id' => $q->id, 'variantid' => $orivar->id, 'varprice' => $price->mainprice, 'varofferprice' => $price->offerprice, 'qty' => $orivar->min_order_qty]);

                $content['producturl'] = $q->getURL($orivar);

                return $content;

            }

        });

        return $featuredproducts->filter();
    }

    public function topProducts()
    {

        $top_categories = CategorySlider::first();

        $result = array();

        if (isset($top_categories) && $top_categories->category_ids != '') {

            foreach ($top_categories->category_ids as $category) {

                $category = Category::where('status', '1')->where('id', $category)->first();

                if (isset($category) && $category->status == '1') {

                    $result[] = array(
                        'category_name' => $category->getTranslations('title'),
                        'products' => $this->categoryproducts($top_categories, $category),
                    );

                }

            }
        }

        return response()->json($result);
    }

    public function categoryproducts($top_categories, $category)
    {

        $sellerSystem = $this->sellerSystem;
       
        $topcatproducts = Product::with('category')->whereHas('category',function($q) use($category) {

            $q->where('status','=','1')->where('id',$category->id);

        })->with('subcategory')->wherehas('subcategory',function($q){

            $q->where('status','1');

        })->with('vender')->whereHas('vender',function($query) use ($sellerSystem) {
 
            if($sellerSystem->vendor_enable == 1){
                $query->where('status','=','1')->where('is_verified','1');
            }else{
                $query->where('status','=','1')->where('role_id','=','a')->where('is_verified','1');
            }
    
        })->with('store')->whereHas('store',function($query){
    
            return $query->where('status','=','1');
    
        })->with('subvariants')->whereHas('subvariants',function($query){
    
            $query->where('def','=','1');
    
        })->with('subvariants.variantimages')->whereHas('subvariants.variantimages')->where('status','=','1')->orderBy('id', 'DESC')->take($top_categories->pro_limit)->get();
        

        $get_product_data = new MainController;

        $conversion_rate = new CurrencyController;

        $conversion_rate = $conversion_rate->fetchRates(session()->get('currency')['id'])->getData()->exchange_rate;

        $content = array();

        $topcatproducts = $topcatproducts->map(function ($q) use ($get_product_data, $content, $conversion_rate) {

            $orivar = $q->subvariants[0];

            if (isset($orivar)) {

                $variant = $get_product_data->getVariant($orivar);
                $variant = $variant->getData();
                $mainprice = $get_product_data->getprice($q, $orivar);
                $price = $mainprice->getData();

                $content['productid'] = $q->id;
                $content['variantid'] = $orivar->id;
                $content['productname'] = $q->getTranslations('name');
                $content['selling_start_at'] = $q->selling_start_at;
                $content['mainprice'] = (float) sprintf("%.2f", $price->mainprice * $conversion_rate);

                $content['offerprice'] = (float) sprintf("%.2f", $price->offerprice * $conversion_rate);

                $content['pricein'] = session()->get('currency')['id'];
                $content['symbol'] = session()->get('currency')['value'];
                $content['position'] = session()->get('currency')['position'];

                $content['thumbnail'] = url('variantimages/thumbnails/' . $orivar->variantimages->main_image);
                $content['hover_thumbnail'] = url('variantimages/hoverthumbnail/' . $orivar->variantimages->image2);
                $content['is_in_wishlist'] = $this->isItemInWishlist($orivar);
                $content['stock'] = $orivar->stock;
                $content['featured'] = $q->featured;
                $content['rating'] = ProductRating::getReview($q);
                $content['cartURL'] = route('add.cart.vue', ['id' => $q->id, 'variantid' => $orivar->id, 'varprice' => $price->mainprice, 'varofferprice' => $price->offerprice, 'qty' => $orivar->min_order_qty]);

                $content['producturl'] = $q->getURL($orivar);

                return $content;

            }

        });

        $topcatproducts = $topcatproducts->filter();

        return $topcatproducts;

    }

    public function getTabbedProducts()
    {

        $newproductcat = FrontCat::first();

        if (isset($newproductcat)) {
            $othercats = explode(",", $newproductcat->name);
        } else {
            $othercats = '';
        }

        $cats = array();

        $all = array(
            'products' => $this->getProducts('all'),
        );

        if (isset($othercats) && $othercats != '') {

            foreach ($othercats as $cat) {

                $category = Category::find($cat);

                if (isset($category)) {
                    $cats[] = array(
                        'id' => $category->id,
                        'title' => $category->getTranslations('title'),
                    );
                }

            }
        }

        return response()->json(['all' => $all, 'cats' => $cats]);

    }

    public function getProducts($type)
    {

        $content = array();

        $get_product_data = new MainController;

        $conversion_rate = new CurrencyController;

        $sellerSystem = $this->sellerSystem;

        $conversion_rate = $conversion_rate->fetchRates(session()->get('currency')['id'])->getData()->exchange_rate;

        if ($type == 'all') {


            $products = Product::with('category')->whereHas('category',function($q) {

                $q->where('status','=','1');
    
            })->with('subcategory')->wherehas('subcategory',function($q){
    
                $q->where('status','1');
    
            })->with('vender')->whereHas('vender',function($query) use ($sellerSystem) {
 
                if($sellerSystem->vendor_enable == 1){
                    $query->where('status','=','1')->where('is_verified','1');
                }else{
                    $query->where('status','=','1')->where('role_id','=','a')->where('is_verified','1');
                }
        
            })->with('store')->whereHas('store',function($query){
        
                return $query->where('status','=','1');
        
            })->with('subvariants')->whereHas('subvariants',function($query){
        
                $query->where('def','=','1');
        
            })->with('subvariants.variantimages')->whereHas('subvariants.variantimages')->where('status','1')->orderBy('id', 'DESC')->take(20)->get();
        
            $content = array();

            $products = $products->map(function ($q) use ($get_product_data, $content, $conversion_rate) {

                $orivar = $q->subvariants[0];

                if (isset($orivar)) {

                    $variant = $get_product_data->getVariant($orivar);
                    $variant = $variant->getData();
                    $mainprice = $get_product_data->getprice($q, $orivar);
                    $price = $mainprice->getData();

                    $content['productid'] = $q->id;
                    $content['variantid'] = $orivar->id;
                    $content['productname'] = $q->getTranslations('name');
                    $content['selling_start_at'] = $q->selling_start_at;
                    $content['mainprice'] = (float) sprintf("%.2f", $price->mainprice * $conversion_rate);

                    $content['offerprice'] = (float) sprintf("%.2f", $price->offerprice * $conversion_rate);

                    $content['pricein'] = session()->get('currency')['id'];
                    $content['symbol'] = session()->get('currency')['value'];
                    $content['thumbnail'] = url('variantimages/thumbnails/' . $orivar->variantimages->main_image);
                    $content['hover_thumbnail'] = url('variantimages/hoverthumbnail/' . $orivar->variantimages->image2);
                    $content['is_in_wishlist'] = $this->isItemInWishlist($orivar);
                    $content['stock'] = $orivar->stock;
                    $content['featured'] = $q->featured;
                    $content['rating'] = ProductRating::getReview($q);
                    $content['position'] = session()->get('currency')['position'];
                    $content['cartURL'] = route('add.cart.vue', ['id' => $q->id, 'variantid' => $orivar->id, 'varprice' => $price->mainprice, 'varofferprice' => $price->offerprice, 'qty' => $orivar->min_order_qty]);

                    $content['producturl'] = $q->getURL($orivar);

                    return $content;

                }

            });

            return $products->filter();

        } else {

            $limit = 10;

            $category = Category::find($type);

            if (isset($category)) {

                    $topcatproducts = Product::with('category')->whereHas('category',function($q) use($category) {

                        return $q->where('status','=','1')->where('id','=',$category->id);

                    })->with('subcategory')->whereHas('subcategory',function($q){

                        return $q->where('status','=','1');

                    })->with('vender')->whereHas('vender',function($query) use ($sellerSystem) {
 
                        if($sellerSystem->vendor_enable == 1){
                            $query->where('status','=','1')->where('is_verified','1');
                        }else{
                            $query->where('status','=','1')->where('role_id','=','a')->where('is_verified','1');
                        }
                
                    })->with('store')->whereHas('store',function($query){
                
                        return $query->where('status','=','1');
                
                    })->with('subvariants')->whereHas('subvariants',function($query){
                
                        $query->where('def','=','1');
                
                    })->with('subvariants.variantimages')->whereHas('subvariants.variantimages')->where('status','1')->orderBy('id', 'DESC')->take($limit)->get();
                   
                

                $content = array();

                $topcatproducts = $topcatproducts->map(function ($q) use ($get_product_data, $content, $conversion_rate) {

                    $orivar = $q->subvariants[0];

                    if (isset($orivar)) {

                        $variant = $get_product_data->getVariant($orivar);
                        $variant = $variant->getData();
                        $mainprice = $get_product_data->getprice($q, $orivar);
                        $price = $mainprice->getData();

                        $content['productid'] = $q->id;
                        $content['variantid'] = $orivar->id;
                        $content['productname'] = $q->getTranslations('name');
                        $content['selling_start_at'] = $q->selling_start_at;
                        $content['mainprice'] = (float) sprintf("%.2f", $price->mainprice * $conversion_rate);

                        $content['offerprice'] = (float) sprintf("%.2f", $price->offerprice * $conversion_rate);
                        $content['position'] = session()->get('currency')['position'];
                        $content['pricein'] = session()->get('currency')['id'];
                        $content['symbol'] = session()->get('currency')['value'];
                        $content['thumbnail'] = url('variantimages/thumbnails/' . $orivar->variantimages->main_image);
                        $content['hover_thumbnail'] = url('variantimages/hoverthumbnail/' . $orivar->variantimages->image2);
                        $content['is_in_wishlist'] = $this->isItemInWishlist($orivar);
                        $content['stock'] = $orivar->stock;
                        $content['featured'] = $q->featured;
                        $content['rating'] = ProductRating::getReview($q);

                        $content['cartURL'] = route('add.cart.vue', ['id' => $q->id, 'variantid' => $orivar->id, 'varprice' => $price->mainprice, 'varofferprice' => $price->offerprice, 'qty' => $orivar->min_order_qty]);

                        $content['producturl'] = $q->getURL($orivar);

                        return $content;

                    }

                });

                return $topcatproducts->filter();

            }

        }

    }

    public function sidebarcategories()
    {
        $sellerSystem = $this->sellerSystem;

        $pirmarycategories = Category::whereHas('products', function ($q) {
            return $q->where('status', '1');
        })->whereHas('products.vender', function ($query) use ($sellerSystem) {

            if ($sellerSystem->vendor_enable == 1) {
                $query->where('status', '=', '1')->where('is_verified', '1');
            } else {
                $query->where('status', '=', '1')->where('role_id', '=', 'a')->where('is_verified', '1');
            }

        })
        ->whereHas('products.subvariants')
        ->whereHas('products.subvariants.variantimages')
        ->orderBy('position', 'ASC')
        ->select('categories.id', 'categories.title', 'categories.icon')
        ->where('categories.status', '=', '1')->with(['subcategory' => function ($query) {
            return $query->select('parent_cat', 'id', 'title', 'icon');

        }, 'subcategory.childcategory' => function ($q) {
            return $q->select('subcat_id', 'id', 'title');
        }])->get();
        
        $t = Testimonial::where('status', '=', '1')->get();
       

        $testimonials = $t->map(function ($tml) {

            $tml['name'] = $tml->name;
            $tml['post'] = $tml->post;
            $tml['des'] = strip_tags($tml->des);
            $tml['image'] = $tml->image != '' && file_exists(public_path() . '/images/testimonial/' . $tml->image) ? url('images/testimonial/' . $tml->image) : Avatar::create($tml->name)->toBase64();

            return $tml;
        });

        $lang = session()->get('changed_language');
        $fallback_local = config('translatable.fallback_locale');

        $specialoffers = Product::with('specialoffer')->whereHas('specialoffer',function($query){

            return $query->where('status','1');

        })->with('category')->whereHas('category',function($q) {

            $q->where('status','=','1');

        })->with('subcategory')->whereHas('subcategory',function($q){

            $q->where('status','1');

        })->with('vender')->whereHas('vender',function($query) use ($sellerSystem) {
 
            if($sellerSystem->vendor_enable == 1){
                $query->where('status','=','1')->where('is_verified','1');
            }else{
                $query->where('status','=','1')->where('role_id','=','a')->where('is_verified','1');
            }
    
        })->with('store')->whereHas('store',function($query){
    
            return $query->where('status','=','1');
    
        })->with('subvariants')->whereHas('subvariants',function($query){
    
            $query->where('def','=','1');
    
        })->with('subvariants.variantimages')->whereHas('subvariants.variantimages')->where('status','=','1')->orderBy('id', 'DESC')->get();

        $get_product_data = new MainController;

        $rate = new CurrencyController;
        $conversion_rate = $rate->fetchRates(session()->get('currency')['id'])->getData()->exchange_rate;

        $get_product_data = new MainController;

        $content = array();

        $specialoffers = $specialoffers->map(function ($q) use ($get_product_data, $content, $conversion_rate) {

            $orivar = $q->subvariants[0];

            if (isset($orivar)) {

                $variant = $get_product_data->getVariant($orivar);
                $variant = $variant->getData();
                $mainprice = $get_product_data->getprice($q, $orivar);
                $price = $mainprice->getData();

                $content['productid'] = $q->id;
                $content['variantid'] = $orivar->id;
                $content['productname'] = $q->getTranslations('name');
                $content['selling_start_at'] = $q->selling_start_at;
                $content['mainprice'] = (float) sprintf("%.2f", $price->mainprice * $conversion_rate);

                $content['offerprice'] = (float) sprintf("%.2f", $price->offerprice * $conversion_rate);
                $content['position'] = session()->get('currency')['position'];
                $content['pricein'] = session()->get('currency')['id'];
                $content['symbol'] = session()->get('currency')['value'];
                $content['thumbnail'] = url('variantimages/thumbnails/' . $orivar->variantimages->main_image);
                $content['hover_thumbnail'] = url('variantimages/hoverthumbnail/' . $orivar->variantimages->image2);
                $content['stock'] = $orivar->stock;
                $content['rating'] = ProductRating::getReview($q);
                $content['producturl'] = $q->getURL($orivar);

                return $content;

            }

        });

        $hotdeal = array();

        $hotdeal = $this->hotdeals();

        return response()->json([
            'categories' => $pirmarycategories->unique(),
            'lang' => $lang, 'fallback_local' => $fallback_local,
            'hotdeals' => $hotdeal,
            'testimonials' => $testimonials,
            'specialoffers' => $specialoffers,
            'guest_price' => Genral::first()->login,
            'logged_in' => Auth::check() ? 1 : 0,
            'date' => now(),
        ]);

    }

    public function hotdeals()
    {

        $sellerSystem = $this->sellerSystem;

        $hotdeals = Product::with('hotdeal')->whereHas('hotdeal',function($query){

            return $query->where('status','1')->whereDate('end','>=',now());

        })->with('category')->whereHas('category',function($q) {

            $q->where('status','=','1');

        })->with('subcategory')->whereHas('subcategory',function($q){

            $q->where('status','1');

        })->with('vender')->whereHas('vender',function($query) use ($sellerSystem) {
 
            if($sellerSystem->vendor_enable == 1){
                $query->where('status','=','1')->where('is_verified','1');
            }else{
                $query->where('status','=','1')->where('role_id','=','a')->where('is_verified','1');
            }
    
        })->with('store')->whereHas('store',function($query){
    
            return $query->where('status','=','1');
    
        })->with('subvariants')->whereHas('subvariants',function($query){
    
            $query->where('def','=','1');
    
        })->with('subvariants.variantimages')->whereHas('subvariants.variantimages')->where('status','=','1')->orderBy('id', 'DESC')->get();

        

        $content = array();

        $rates = new CurrencyController;

        $conversion_rate = $rates->fetchRates(session()->get('currency')['id'])->getData()->exchange_rate;

        $get_product_data = new MainController;

        $content = array();

        if($hotdeals){
            $hotdeals = $hotdeals->map(function ($q) use ($get_product_data, $content, $conversion_rate) {

                $orivar = $q->subvariants[0];
    
                if (isset($orivar)) {
    
                    $variant = $get_product_data->getVariant($orivar);
                    $variant = $variant->getData();
                    $mainprice = $get_product_data->getprice($q, $orivar);
                    $price = $mainprice->getData();
    
                    $mp = sprintf("%.2f", $get_product_data->getprice($q, $orivar)->getData()->mainprice);
    
                    $op = sprintf("%.2f", $get_product_data->getprice($q, $orivar)->getData()->offerprice);
    
                    $getdisprice = $mp - $op;
    
                    $discount = $getdisprice / $mp;
    
                    $offamount = $discount * 100;
    
                    $content['start_date'] = $q->hotdeal->start;
                    $content['end_date'] = $q->hotdeal->end;
                    $content['productid'] = $q->id;
                    $content['variantid'] = $orivar->id;
                    $content['productname'] = $q->getTranslations('name');
    
                    $content['tax_info'] = $q->tax_r == '' ? __("Exclusive of tax") : __("Inclusive of all taxes");
                    $content['selling_start_at'] = $q->selling_start_at;
                    $content['mainprice'] = (float) sprintf("%.2f", $price->mainprice * $conversion_rate);
    
                    $content['offerprice'] = (float) sprintf("%.2f", $price->offerprice * $conversion_rate);
                    $content['position'] = session()->get('currency')['position'];
                    $content['pricein'] = session()->get('currency')['id'];
                    $content['symbol'] = session()->get('currency')['value'];
                    $content['off_percent'] = (int) round($offamount);
                    $content['thumbnail'] = url('variantimages/thumbnails/' . $orivar->variantimages->main_image);
                    $content['hover_thumbnail'] = url('variantimages/hoverthumbnail/' . $orivar->variantimages->image2);
                    $content['stock'] = $orivar->stock;
                    $content['featured'] = $q->featured;
                    $content['rating'] = ProductRating::getReview($q);
                    $content['in_cart'] = $this->incart($orivar->id);
                    $content['cartURL'] = route('add.cart.vue', ['id' => $q->id, 'variantid' => $orivar->id, 'varprice' => $price->mainprice, 'varofferprice' => $price->offerprice, 'qty' => $orivar->min_order_qty]);
    
                    $content['producturl'] = $q->getURL($orivar);
    
                    return $content;
    
                }
    
            });
    
            $hotdeals = $hotdeals->filter();
        }

        return $hotdeals;
    }

    public function incart($variantid)
    {

        if (Auth::check()) {

            $in = Cart::where('variant_id', $variantid)->where('user_id', auth()->user()->id)->first();

            if (isset($in)) {
                return 1;
            } else {
                return 0;
            }

        } else {

            $flag = 0;

            if (!empty(session()->get('cart'))) {

                foreach (session()->get('cart') as $cart) {

                    if ($variantid == $cart['variantid']) {

                        $flag = 1;

                    } else {

                        $flag = 0;

                    }
                }

            } else {
                $flag = 0;
            }

            return $flag;

        }
    }

    public function getCategoryUrl(Request $request)
    {

        $category = Category::find($request->id);

        if (!$category) {
            return response()->json(['message' => 'Something went wrong !', 'status' => 'fail']);
        }

        return response()->json($category->getURL());
    }

    public function getSubCategoryUrl(Request $request)
    {

        $subcategory = Subcategory::find($request->id);

        if (!$subcategory) {
            return response()->json(['message' => 'Something went wrong !', 'status' => 'fail']);
        }

        return response()->json($subcategory->getURL());
    }

    public function getChildCategoryUrl(Request $request)
    {
        $childcategory = Grandcategory::find($request->id);

        if (!$childcategory) {
            return response()->json(['message' => 'Something went wrong !', 'status' => 'fail']);
        }

        return response()->json($childcategory->getURL());
    }

    public function addtoCompare(Request $request)
    {

        if (!empty(Session::get('comparison'))) {

            $countComparison = count(Session::get('comparison'));

            if ($countComparison < 4) {

                $comproducts = Session::get('comparison');
                $avbl = 0;

                $fpro = 0;

                foreach ($comproducts as $key => $value) {
                    $fpro = $comproducts[$key]['proid'];
                }

                $firstProduct = Product::find($fpro);
                $currentpro = Product::find($request->id);

                if ($firstProduct->child != $currentpro->child) {

                    return response()->json([
                        'message' => 'Only similar product can be compared',
                        'status' => 'fail',
                    ]);

                    exit;
                }

                foreach ($comproducts as $key => $pro) {

                    if ($pro['proid'] == $request->id) {

                        $avbl = 1;
                        break;

                    } else {

                        $avbl = 0;

                    }
                }

                if ($avbl == 0) {

                    Session::push('comparison', ['proid' => $request->id]);

                    return response()->json([
                        'message' => 'Product added to your compare list !',
                        'status' => 'success',
                    ]);

                } else {

                    return response()->json([
                        'message' => 'Product is already added to your comparison list !',
                        'status' => 'fail',
                    ]);

                }

            } else {

                return response()->json([
                    'message' => 'You can compare only 4 product at a time !',
                    'status' => 'fail',
                ]);
            }

        } else {

            Session::push('comparison', ['proid' => $request->id]);

            return response()->json([
                'message' => 'Product added to your compare list !',
                'status' => 'success',
            ]);
        }
    }

    public function topmenus()
    {

        $lang = session()->get('changed_language');
        $fallback_local = config('translatable.fallback_locale');

        $menus = Menu::where('status', '=', '1')->orderBy('position', 'ASC')->with('gotopage')->get();

        $menus = $menus->map(function ($item) {

            if ($item->show_cat_in_dropdown == '1' && $item->linked_parent != null) {
                $item['megamenu'] = $this->megamenu($item)->getData();

                return $item;
            } else if ($item->show_child_in_dropdown == '1' && $item->linked_parent != null) {
                $item['megamenu'] = $this->megamenuchild($item)->getData();

                return $item;
            } else {
                $item['megamenu'] = null;
                return $item;
            }

        });

        return response()->json(['menus' => $menus, 'lang' => $lang, 'fallback_local' => $fallback_local]);
    }

    public function megamenu($menu)
    {

        if ($menu->show_cat_in_dropdown == 1 && $menu->linked_parent != null) {

            $result = array();

            $extrarray = array();
            $extrarray2 = array();

            if(isset($menu->linked_parent)){
                foreach ($menu->linked_parent as $key => $parent) {

                    $cat = Category::find($parent);
    
                    $x = $key + 1;
    
                    if (isset($cat)) {
    
                        $result[] = array(
                            'id' => $cat->id,
                            'type' => 'category',
                            'title' => $cat->title,
                            'cattype' => 'primary',
                        );
    
                        if(isset($menu->linked_child)){
                            foreach ($menu->linked_child as $key2 => $child) {
    
                                $subcat = Subcategory::find($child);
        
                                $x2 = $key2 + 1;
        
                                if (isset($subcat) && $subcat->parent_cat == $parent) {
        
                                    $result[] = array(
                                        'id' => $subcat->id,
                                        'type' => 'subcategory',
                                        'title' => $subcat->title,
                                        'cattype' => 'subcat',
                                    );
        
                                    $result[] = array(
                                        'type' => 'detail',
                                        'title' => strip_tags($subcat->description),
                                    );
                                }
        
                            }
                        }
    
                    }
    
                }
            }

            $slCount = count($result) / 17;
            $whole = floor($slCount);
            $floor = fmod($slCount, 1);
            if ($floor > 0) {
                $slCount = $whole + 1;
            } else {
                $slCount = $whole;
            }

            $last = 0;
            for ($j = 0; $j < $slCount; $j++) {
                $extrarray = [];
                for ($i = 1; $i <= 17; $i++) {

                    if ($last < count($result)) {
                        if (isset($result[$last])) {
                            $extrarray[] = $result[$last];
                        }
                    }

                    $last = $last + 1;

                }
                $extrarray2[] = $extrarray;

            }

        }

        $extrarray2 = array_filter($extrarray2);

        return response()->json($extrarray2);

    }

    public function megamenuchild($menu)
    {

        if ($menu->show_child_in_dropdown == 1 && $menu->linked_parent != null) {

            $result = array();

            $extrarray = array();
            $extrarray2 = array();

            if(isset($menu->linked_parent)){
                foreach ($menu->linked_parent as $key => $parent) {

                    $cat = Subcategory::find($parent);
    
                    $x = $key + 1;
    
                    if (isset($cat)) {
    
                        $result[] = array(
                            'id' => $cat->id,
                            'type' => 'category',
                            'title' => $cat->title,
                            'cattype' => 'subcat',
                        );
    
                        if(isset($menu->linked_child)){
                            foreach ($menu->linked_child as $key2 => $child) {
    
                                $subcat = Grandcategory::find($child);
        
                                $x2 = $key2 + 1;
        
                                if (isset($subcat) && $subcat->subcat_id == $parent) {
        
                                    $result[] = array(
                                        'id' => $subcat->id,
                                        'type' => 'subcategory',
                                        'title' => $subcat->title,
                                        'cattype' => 'child',
                                    );
        
                                    $result[] = array(
                                        'type' => 'detail',
                                        'title' => strip_tags($subcat->description),
                                    );
                                }
        
                            }
                        }
    
                    }
    
                }
            }

            $slCount = count($result) / 17;
            $whole = floor($slCount);
            $floor = fmod($slCount, 1);
            if ($floor > 0) {
                $slCount = $whole + 1;
            } else {
                $slCount = $whole;
            }

            $last = 0;
            for ($j = 0; $j < $slCount; $j++) {
                $extrarray = [];
                for ($i = 1; $i <= 17; $i++) {

                    if ($last < count($result)) {
                        if (isset($result[$last])) {
                            $extrarray[] = $result[$last];
                        }
                    }

                    $last = $last + 1;

                }
                $extrarray2[] = $extrarray;

            }

        }

        $extrarray2 = array_filter($extrarray2);

        return response()->json($extrarray2);

    }

    public function totalCart()
    {

        try {
            $count = 0;

            $shipping = 0;

            $discount = 0;

            $rate = new CurrencyController;

            $total = 0;

            $items = array();

            $conversion_rate = $rate->fetchRates(session()->get('currency')['id'])->getData()->exchange_rate;

            $getvariant = new CartController;

            if (Auth::check()) {

                $count = Auth::user()->cart->count();

                if ($count > 0) {

                    $discount = Cart::getDiscount();

                    foreach (auth()->user()->cart as $key => $val) {
                        $shipping = $shipping + ShippingPrice::calculateShipping($val);

                        if ($val->product->tax_r != null && $val->product->tax == 0) {

                            if ($val->semi_total != 0) {

                                $price = $val->semi_total;

                            } else {

                                $price = $val->price_total;

                            }

                        }else{
                            if ($val->semi_total != 0) {

                                $price = $val->semi_total;
            
                            } else {
            
                                $price = $val->price_total;
            
                            }
                        }

                        $total = $total + $price;

                        $items[] = array(
                            'id' => $val->id,
                            'main_attr_count' => count($val->variant->main_attr_id),
                            'image' => url('/variantimages/thumbnails/'.$val->variant->variantimages->main_image),
                            'name' => $val->product->getTranslations('name'),
                            'variant' => $getvariant->variantDetail($val->variant),
                            'qty' => $val->qty,
                            'price' => (double) sprintf('%.2f', $price * $conversion_rate)
                        );

                    }
                }

            } else {

                if (session()->has('cart')) {
                    $c = array();

                    $c = session()->get('cart');

                    if (!empty($c)) {
                        $c = array_filter($c);
                    } else {
                        $c = [];
                    }

                    if (session()->has('coupanapplied')) {
                        $discount = session()->get('coupanapplied')['discount'];
                    }

                    $count = count($c);

                    foreach (session()->get('cart') as $cart) {

                        $pros = Product::where('id', '=', $cart['pro_id'])->first();

                        $variant = AddSubVariant::withTrashed()->where('id', '=', $cart['variantid'])->first();

                        if ($pros->free_shipping == 0) {
                            $shipping += GuestCartShipping::shipping($variant, $cart);
                        }

                        if ($cart['varofferprice'] != 0) {
                            $price = $cart['qty'] * $cart['varofferprice'];
                        } else {
                            $price = $cart['qty'] * $cart['varprice'];
                        }

                        $total = sprintf("%.2f", $total + $price);

                        $items[] = array(
                            'variantid' => $variant->id,
                            'main_attr_count' => count($variant->main_attr_id),
                            'image' => url('/variantimages/thumbnails/'.$variant->variantimages->main_image),
                            'name' => $pros->getTranslations('name'),
                            'variant' => $getvariant->variantDetail($variant),
                            'qty' => $cart['qty'],
                            'price' => (double) sprintf('%.2f', $price * $conversion_rate)
                        );
                    }
                }

            }

            $subtotal = sprintf("%.2f", ($total - $discount) * $conversion_rate);

            $total = $total - $discount;

            $total = $total + $shipping;

            $total = sprintf('%.2f', $total * $conversion_rate);

            $lang = session()->get('changed_language');
            $fallback_local = config('translatable.fallback_locale');

            return response()->json([
                'items' => $items, 
                'currency' => session()->get('currency'),
                'count' => $count, 
                'shipping' => $shipping * $conversion_rate, 
                'subtotal' => (float) $subtotal, 
                'discount' => (float) sprintf("%.2f", $discount * $conversion_rate), 
                'total' => (float) $total,
                'fallback_local' => $fallback_local,
                'lang' => $lang,
                'login' => Auth::check() ? 1 : 0
            ]);

        } catch (\Exception $e) {

            return response()->json($e->getMessage());
            
        }

    }

    public function notifications()
    {
        $count = auth()->user()->unreadnotifications->where('n_type', '!=', 'order_v')->count();

        return response()->json([
            'count' => $count,
            'notifications' => auth()->user()->unreadnotifications->where('n_type', '!=', 'order_v')->map(function ($q) {
                $q['date'] = date('jS M y', strtotime($q->created_at));
                return $q;
            }),
        ]);
    }

    public function isItemInWishlist($variant)
    {

        if (Auth::check()) {

            $result = Wishlist::where('user_id', Auth::user()->id)->where('pro_id', $variant->id)->first();

            if (isset($result)) {
                return 1;
            } else {
                return 0;
            }

        } else {

            return 0;

        }

    }

    public function add_or_removewishlist(Request $request)
    {

        $id = $request->variantid;

        if (Auth::check() && $id) {

            $wish = DB::table('wishlists')->where('user_id', Auth::user()
                    ->id)
                    ->where('pro_id', $id)->first();

            if (!empty($wish)) {
                DB::table('wishlists')->where('user_id', Auth::user()
                        ->id)
                        ->where('pro_id', $id)->delete();

                return response()->json(['message' => 'Removed from wishlist !', 'status' => 'success']);
            } else {
                $wishlist = new Wishlist;

                $wishlist->user_id = Auth::user()->id;
                $wishlist->pro_id = $id;
                $wishlist->save();

                return response()->json(['message' => 'Added in wishlist !', 'status' => 'success']);
            }

        } else {
            return response()->json([
                'message' => 'Something went wrong !',
                'status' => 'fail',
            ]);
        }

    }

    public function wishlistcount()
    {

        try{
            if (Auth::check()) {
                $data = Wishlist::where('user_id', Auth::user()->id)->get();
    
                $data->map(function ($q) {
                    if (isset($q->variant->products) && isset($q->variant)) {
                        if ($q->variant->products->status == '1') {
                            return $q;
                        }
                    }
                });
            }
    
            return response()->json($data->count());
            
        }catch(\Exception $e){

            return response()->json($e->getMessage());
        }
        
    }

    public function comparecount()
    {
        if (Session::has('comparison')) {

            $clist = Session::get('comparison');

            foreach ($clist as $k => $row) {

                $findpro = Product::find($row);

                if (!isset($findpro)) {

                    unset($clist[$k]);

                }
            }

            Session::put('comparison', $clist);
        }

        return response()->json(Session::get('comparison') != null ? count(Session::get('comparison')) : 0);
    }

    public function sidebarconfigs()
    {
        $data = Widgetsetting::get();
        return response()->json($data);
    }
}
