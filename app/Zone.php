<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    
	protected $fillable = [
	        'title','country_id', 'name', 'code','status','state_id',
	    ];

	protected $casts = [
    	'name' => 'array', 
	];

	public function country(){
        return $this->belongsTo(Allcountry::class,'country_id');
    }

    public function state(){
        return $this->belongsTo(Allstate::class,'state_id');
    }

}
