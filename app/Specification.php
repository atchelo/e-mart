<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
	protected $fillable = [
        'name', 'group_id', 'status'
    ];

    public function group(){
    	return $this->belongsTo('App\Group_specification','group_id');
    }
}
