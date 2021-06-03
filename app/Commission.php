<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $fillable = [
		'category_id','rate','type','status',
	];

	public function category()
	{
    	return $this->belongsTo('App\Category','category_id');  
    }
}
