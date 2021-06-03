<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specifiction_product extends Model
{
    protected $fillable = [
        'product_id', 'specification_id', 'des'
    ];
    
    public function product(){
    	return $this->belongsTo('App\Product','product_id');  
      }
      public function specification(){
    	return $this->belongsTo('App\Specification','specification_id');  
      }
      
}
