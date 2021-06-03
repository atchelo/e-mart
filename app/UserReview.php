<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReview extends Model
{
    public function pro(){
    	return $this->belongsTo('App\Product','pro_id');
    }

    public function users(){
    	return $this->belongsTo('App\User','user','id');
    }
}
