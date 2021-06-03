<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Related_setting extends Model
{
    
	public function product()
	{
		return $this->belongsTo('App\Product','pro_id','id');
	}

}
