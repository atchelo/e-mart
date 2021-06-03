<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class multiCurrency extends Model
{
     protected $fillable = ['position','currency_id','add_amount','currency_symbol','default_currency','created_at','updated_at'];
     
     public function currency(){
    	     return $this->belongsTo('App\CurrencyNew','currency_id','id');  
     }

     public function checkoutCurrencySettings(){
          return $this->hasOne('App\CurrencyCheckout','multicurrency_id','id');
     }

     public function currencyLocationSettings(){
          
          return $this->hasOne('App\Location','multi_currency','id');
     
     }
}
