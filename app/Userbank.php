<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Userbank extends Model
{
    protected $fillable = [
    	'acname','bankname','acno','ifsc','user_id'
    ];

    public function user(){
    	return $this->belongsTo('App\User','user_id','id');
    }
}
