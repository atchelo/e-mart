<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';

    protected $fillable =[
    	'user_id','pro_id','collection_id'
    ];

    public function user()
    {
    	return $this->belongsTo('App\User','user_id','id');
    }

    public function variant(){
    	return $this->belongsTo('App\AddSubVariant','pro_id','id');
    }
}
