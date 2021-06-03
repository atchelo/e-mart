<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealatedProduct extends Model
{
	protected $table = 'relatedproducts';

    protected $fillable = [
		'product_id','offer_price','status','related_pro'
	];

	protected $casts = [
		'related_pro' => 'array'
	];

	public function product(){
    	return $this->belongsTo('App\Product','product_id');
    }
}
