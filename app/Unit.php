<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable=[
	
		'title','status',

	];

	public function unitvalues()
	{
		return $this->hasMany('App\UnitValues','unit_id');
	}

	public function linkedAttributes(){
		return $this->hasMany('App\ProductAttributes','unit_id');
	}
}
