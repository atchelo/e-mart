<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSpecifications extends Model
{
    protected $fillable = [
    	'pro_id','prokeys','provalues'
    ];

    public function products(){
    	return $this->belongsTo('App\Product','pro_id','id');
    }
}
