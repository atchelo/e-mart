<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable=[
	
		'city_id','country_id','state_id','pincode','address','mobile','image','gender'

	];
}
