<?php

namespace App;
use App\State;

use Illuminate\Database\Eloquent\Model;
class Country extends Model
{
	protected $table = 'countries';
	
	protected $fillable=[
	
		'country'

	];

    public function state(){
    	return $this->hasMany(State::class);
    }
}
