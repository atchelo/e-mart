<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CanceledOrders extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }

    public function order(){
    	return $this->belongsTo('App\Order','order_id','id');
    }

    public function singleOrder(){
    	return $this->belongsTo('App\InvoiceDownload','inv_id','id');
    }

    public function bank()
    {
        return $this->belongsTo('App\Userbank','bank_id','id');
    }
}
