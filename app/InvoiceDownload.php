<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class InvoiceDownload extends Model
{
    use SoftDeletes;
    
    public function order()
    {
    	return $this->belongsTo('App\Order','order_id','id');
    }

    public function variant()
    {
    	return $this->belongsTo('App\AddSubVariant','variant_id','id')->withTrashed();
    }

    public function seller(){
    	return $this->belongsTo('App\User','vender_id','id');
    }

    public function payouts(){
        return $this->hasMany('App\SellerPayout','orderid');
    }

    public function refundlog(){
        return $this->hasOne('App\Return_Product','order_id','id');
    }

    public static function createTrackingID()
    {
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'
            . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
            . '0123456789$&@'); 
        shuffle($seed); 
        $rand = '';
        foreach (array_rand($seed, 10) as $k) {
            $rand .= $seed[$k];
        }

        return Str::upper($rand);
    }
}
