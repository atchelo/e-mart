<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductValues extends Model
{
    public function proattr()
    {
    	return $this->belongsTo('App\ProductAttributes','atrr_id','id');
    }

    public function pro_attr_values()
    {
    	return $this->hasMany('App\AddProductVariant','attr_value');
    }
}
