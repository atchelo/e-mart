<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategorySlider extends Model
{
    public $timestamps = false;

    protected $fillable = [
    	'category_ids','pro_limit','status'
    ];

    protected $casts = [
    	'category_ids' => 'array'
    ];
}
