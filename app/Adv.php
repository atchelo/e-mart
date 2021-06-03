<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adv extends Model
{
    protected $fillable = [

    	'layout','position','status','image1','image2','image3','url1','url2','url3','pro_id1','pro_id2','pro_id3','cat_id1','cat_id2','cat_id3'

    ];

    public function category()
    {
    	return $this->belongsTo('App\Category','url','id');
    }

    public function product1(){
        return $this->belongsTo('App\Product','pro_id1','id');
    }

    public function product2(){
        return $this->belongsTo('App\Product','pro_id2','id');
    }

    public function product3(){
        return $this->belongsTo('App\Product','pro_id3','id');
    }
}
