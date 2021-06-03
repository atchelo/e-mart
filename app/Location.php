<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function linkedtomulticurrency(){
    	return $this->belongsTo('App\multiCurrency','multi_currency','id');
    }
}
