<?php

namespace App;
use App\State;
use App\Country;
use Illuminate\Database\Eloquent\Model;
class City extends Model
{

	protected $fillable = [
		'city_name','state_id','country_id'
	];

    public function state(){
    	return $this->belongsTo(State::class);
    }

     public function country(){
    	return $this->belongsTo(Country::class);
    }
}
