<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PinCod extends Model
{
     protected $fillable = [
 			'city_id','country_id','state_id','pin_code','status',
     	];


     	
    public function city(){
        return $this->belongsTo(Allcity::class,'city_id');
    }

    public function country(){
        return $this->belongsTo(Allcountry::class,'country_id');
    }

    public function state(){
        return $this->belongsTo(Allstate::class,'state_id');
    }
}
