<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotdeal extends Model
{
     protected $fillable = [
        'pro_id','start','end','status'
    ];


     public function pro()
     {
     	return $this->belongsTo('App\Product','pro_id');  
     }

}
