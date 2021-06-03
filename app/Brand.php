<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{

    protected $fillable = [
        'name', 'image', 'status', 'show_image', 'category_id', 'brand_proof', 'is_requested',
    ];

    protected $casts = [
        'category_id' => 'array',
    ];

    public function products()
    {
        return $this->hasMany('App\Product', 'brand_id', 'id');
    }

}
