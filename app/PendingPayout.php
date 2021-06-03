<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PendingPayout extends Model
{
    public function singleorder(){
    	return $this->belongsTo('App\InvoiceDownload','orderid','id');
    }
}
