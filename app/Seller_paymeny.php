<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller_paymeny extends Model
{
   public function order()
     {
     	return $this->belongsTo('App\Order','order_id');  
     }

      public function vender(){
        return $this->belongsTo('App\User','vender_id');  
      }
}
