<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FullOrderCancelLog extends Model
{
    protected $casts = [
    	'inv_id' => 'array'
    ];

    public function user()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }

    public function getorderinfo()
    {
    	return $this->belongsTo('App\Order','order_id','id');
    }

    public function bank()
    {
        return $this->belongsTo('App\Userbank','bank_id','id');
    }
}
