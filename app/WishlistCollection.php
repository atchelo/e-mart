<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WishlistCollection extends Model
{
    protected $fillable = [
        'name','user_id'
    ];

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }

    public function items(){
        return $this->hasMany('App\Wishlist','collection_id');
    }

}
