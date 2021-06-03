<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Store extends Model
{

    use SoftDeletes;

    protected $fillable = [

        'user_id', 'name', 'address','phone','mobile','email','city_id','country_id','state_id','pin_code','store_logo','website','status','verified_store','featured','branch','ifsc','account','bank_name','account_name','paypal_email','paytem_mobile','preferd','apply_vender','vat_no','uuid','description','cover_photo','document'
        
    ];

    public function state(){
    	return $this->belongsTo('App\Allstate','state_id');
    }

    public function city(){
    	return $this->belongsTo('App\Allcity','city_id');
    }

    public function country(){
    	return $this->belongsTo('App\Allcountry','country_id');
    }

    public function user(){
    	return $this->hasOne('App\User','id','user_id');
    }

    public function products(){
        return $this->hasMany('App\Product','store_id');
    }

    public static function generateUUID(){
        return (string) Str::orderedUuid();
    }
}
