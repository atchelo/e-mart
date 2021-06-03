<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductAttributes extends Model
{
    protected $fillable = [
    	'attr_name','cats_id','unit_id'
    ];

    protected $casts = [
        'cats_id' => 'array'
    ];

    public function provalues()
    {
    	return $this->hasMany('App\ProductValues','atrr_id');
    }

    public function pro_var_attr()
    {
    	return $this->hasMany('App\AddProductVariant','attr_name');
    }

    public function cate() {

     return $this->belongsTo('App\Category','cats_id','id');
     
    }

}
