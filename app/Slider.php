<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Slider extends Model
{
    use HasTranslations;

    public $translatable = ['heading', 'topheading', 'buttonname', 'des'];

    protected $fillable = [
        'heading', 'des', 'price', 'offer_price', 'product_id', 'status', 'image', 'category_id', 'child', 'grand_id', 'topheading', 'buttonname', 'buttonlink', 'button_status',
    ];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    public function subcategory()
    {
        return $this->belongsTo('App\Subcategory', 'child', 'id');
    }

    public function child()
    {
        return $this->belongsTo('App\Grandcategory', 'grand_id', 'id');
    }

    public function products()
    {
        return $this->belongsTo('App\Product', 'product_id', 'id');
    }

}
