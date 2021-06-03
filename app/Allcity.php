<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allcity extends Model
{
    protected $table = 'allcities';

    protected $fillable = [
        'name','state_id','pincode'
    ];

    public $timestamps = false;

    public function state(){
    	return $this->belongsTo('App\Allstate','state_id','id');
    }
}
