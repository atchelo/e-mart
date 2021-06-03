<?php

namespace App;

use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements Viewable
{
    use HasTranslations;
    use InteractsWithViews;
    use SoftDeletes;

    public $translatable = ['name', 'des', 'tags', 'key_features', 'tax_name'];

    protected $fillable = [
        'category_id', 'child', 'grand_id', 'store_id', 'name', 'des', 'tags', 'model', 'sku', 'price', 'offer_price', 'website', 'dimension', 'weight', 'status', 'featured', 'brand_id', 'vender_id', 'sale', 'tax', 'free_shipping', 'return_avbl', 'cancel_avl', 'vender_price', 'vender_offer_price', 'commission_rate', 'return_policy', 'selling_start_at', 'key_features', 'codcheck', 'shipping_id', 'price_in', 'w_d', 'w_my', 'w_type', 'tax_r', 'tax_name', 'video_preview', 'video_thumbnail','catlog','gift_pkg_charge'
    ];

    protected $casts = [
        'name' => 'array',
    ];

    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function shippingmethod(){
        return $this->belongsTo('App\Shipping','shipping_id','id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment', 'pro_id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory', 'child');
    }

    public function childcat()
    {
        return $this->belongsTo('App\Grandcategory', 'grand_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Brand', 'brand_id');
    }

    public function store()
    {
        return $this->belongsTo('App\Store', 'store_id');
    }

    public function hotdeal()
    {
        return $this->hasOne('App\Hotdeal', 'pro_id','id');
    }

    
    public function specialoffer(){
        return $this->hasOne('App\SpecialOffer', 'pro_id','id');
    }

    public function coupans()
    {
        return $this->hasMany('App\Coupan', 'pro_id');
    }

    public function vender()
    {
        return $this->belongsTo('App\User', 'vender_id', 'id');
    }

    public function variants()
    {
        return $this->hasMany('App\AddProductVariant', 'pro_id');
    }

    public function subvariants()
    {
        return $this->hasMany('App\AddSubVariant', 'pro_id', 'id');
    }

    public function commonvars()
    {
        return $this->hasMany('App\CommonVariants', 'pro_id');
    }

    public function returnPolicy()
    {
        return $this->belongsTo('App\admin_return_product', 'return_policy');
    }

    public function reviews()
    {
        return $this->hasMany('App\UserReview', 'pro_id');
    }

    public function relsetting()
    {
        return $this->hasOne('App\Related_setting', 'pro_id');
    }

    public function relproduct()
    {
        return $this->hasOne('App\RealatedProduct', 'product_id');
    }

    public function taxclass()
    {
        return $this->belongsTo('App\TaxClass', 'tax', 'id');
    }

    public function specs()
    {
        return $this->hasMany('App\ProductSpecifications', 'pro_id');
    }

    public function faq(){
        return $this->hasMany('App\FaqProduct','pro_id');
    }


    public function getURL($orivar)
    {
        $url = '#';
        
        if(isset($orivar)){
            $var_name_count = count($orivar['main_attr_id']);

            $name = array();
            $var_name = array();

            

            for ($i = 0; $i < $var_name_count; $i++) {

                $var_id = $orivar['main_attr_id'][$i];
                $var_name[$i] = $orivar['main_attr_value'][$var_id];
                $name[$i] = ProductAttributes::where('id', $var_id)->first();

            }

            try {
                $url = url('details') . '/' . $this->id . '?' . $name[0]['attr_name'] . '=' . $var_name[0] . '&' . $name[1]['attr_name'] . '=' . $var_name[1];
            } catch (\Exception $e) {
                $url = url('details') . '/' . $this->id . '?' . $name[0]['attr_name'] . '=' . $var_name[0];
            }
        }

        return $url;
    }

}
