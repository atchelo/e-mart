<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxClass extends Model
{
    protected $fillable = [
		'title','des','taxRate_id','based_on','priority',
	];

	public function zones(){
        return $this->belongsTo(Allstate::class,'zone');
    }

    public function products(){
    	return $this->hasMany('App\Product','tax');
    }

    protected $casts = [
    	'taxRate_id' => 'array','based_on' => 'array','priority' => 'array',
    ];

}
