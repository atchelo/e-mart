<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommonVariants extends Model
{
    public function products()
    {
    	return $this->belongsTo('App\Product','pro_id','id');
    }

    public function attribute(){
    	return $this->belongsTo('App\ProductAttributes','cm_attr_id','id');
    }

    public function provalues(){
    	return $this->belongsTo('App\ProductValues','cm_attr_val','id');
    }
}
