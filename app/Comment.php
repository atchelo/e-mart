<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function products(){
    	return $this->belongsTo('App\Product','pro_id','id');
    }
}
