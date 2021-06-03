<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
	use SoftDeletes;
	
	protected $fillable = [
		'name','email','phone', 'user_id','address','pin_code','defaddress','user_id','country_id','state_id','city_id','type'
	];
	
    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }

    public function getstate(){
    	return $this->belongsTo('App\Allstate','state_id','id');
	}
	
	public function getcity(){
    	return $this->belongsTo('App\Allcity','city_id','id');
	}
	
	public function getCountry(){
    	return $this->belongsTo('App\Allcountry','country_id','id');
    }
}
