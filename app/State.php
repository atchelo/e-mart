<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Country;
use App\State;
use App\City;

class State extends Model
{
    
    protected $fillable = [
        'state', 'country_id'
    ];

    public function country(){
    	return $this->belongsTo(Country::class);
    }

    public function city(){
    	return $this->hasMany(City::class);
    }
}
