<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HelpDesk extends Model
{
    public function users_t()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }
}
