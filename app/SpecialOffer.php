<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    protected $fillable = [
        'pro_id','status'
    ];


     public function pro()
     {
     	return $this->belongsTo('App\Product','pro_id');  
     }

}
