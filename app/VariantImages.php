<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VariantImages extends Model
{
    public function subvariant(){
    	return $this->belongsTo('App\AddSubVariant','var_id','id');
    }
}
