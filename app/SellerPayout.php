<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellerPayout extends Model
{
    protected $table = 'sellerpayouts';

    public function singleorder(){
    	return $this->belongsTo('App\InvoiceDownload','orderid','id');
    }

    public function vender()
    {
    	return $this->belongsTo('App\User','sellerid','id');
    }
}
