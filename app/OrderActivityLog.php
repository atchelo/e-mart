<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderActivityLog extends Model
{
    public function order()
    {
    	return $this->belongsTo('App\Order','order_id','id');
    }

    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }
}
