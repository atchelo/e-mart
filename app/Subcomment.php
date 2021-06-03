<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcomment extends Model
{
    public function comment()
     {
     	return $this->belongsTo('App\Commment','comment_id');  
     }
}
