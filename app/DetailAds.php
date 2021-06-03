<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class DetailAds extends Model
{
    use HasTranslations;

	public $translatable = ['top_heading','sheading','btn_text'];

	

    public $timestamps = false;

    public function category(){
    	return $this->belongsTo('App\Category','cat_id','id');
    }

    public function product(){
    	return $this->belongsTo('App\Product','pro_id','id');
    }

   
}
