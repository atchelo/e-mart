<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    protected $fillable = [
    	'qty','pro_id','user_id','semi_total','variant_id','price_total','vender_id','ori_price','ori_offer_price','shipping','gift_pkg_charge'
    ];


     public function product()
     {
     	return $this->belongsTo('App\Product','pro_id')->withTrashed();  
     }

     public function variant()
     {
     	return $this->belongsTo('App\AddSubVariant','variant_id','id')->withTrashed();
     }

     public static function isCoupanApplied(){
        $status = 0;

        if(Auth::check()){

            foreach (auth()->user()->cart as $key => $c) {
                if($c->coupan_id){
                    $status = 1;
                    break;
                }
            }
        }

        return $status;
     }

     public static function getCoupanDetail(){
       
        $coupan = null;

        if(Auth::check()){
        
            foreach (auth()->user()->cart as $key => $c) {
                if($c->coupan_id){
                    $coupan = Coupan::find($c->coupan_id);
                    break;
                }
            }
        }

        return $coupan;
     }

     public static function getDiscount(){
    

        $totaldiscount = 0;

        if(Auth::check()){
            foreach (Auth::user()->cart as $cart) {

                if ($cart->semi_total != 0) {
    
                    $totaldiscount = $totaldiscount + $cart->disamount;
    
                } else {
    
                    $totaldiscount = $totaldiscount + $cart->disamount;
    
                }
    
            }
        }

        return $totaldiscount;
     }

}
