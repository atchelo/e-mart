<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingAddress extends Model
{
    protected $fillable = [
        'firstname','address','email','mobile','pincode','country_id','state','city','user_id','type'
    ];

    public function cities(){
        return $this->belongsTo(Allcity::class,'city');
    }

    public function countiess(){
        return $this->belongsTo(Allcountry::class,'country_id');
    }

    public function states(){
        return $this->belongsTo(Allstate::class,'state');
    }
}
