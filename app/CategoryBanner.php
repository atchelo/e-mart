<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryBanner extends Model
{
    
 protected $fillable = [
        'product_id','image','category_id','des','buttonlink','buttonname','heading','status',
    ];


	public function product(){
    	return $this->belongsTo('App\Product','product_id');
    }

     public function category(){
    	return $this->belongsTo('App\Category','category_id');  
      }

    public function subcategory(){
    	return $this->belongsTo('App\Subcategory','child');  
      }

}
