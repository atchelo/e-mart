<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UnitValues extends Model
{
    public function units()
    {
    	return $this->belongsTo('App\Unit','unit_id','id');
    }
}
