<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Return_Product extends Model
{
    // protected $fillable = [
    //     'pro_id', 'qty','pro_price','account','ifsc','branch','payment_status','vendor_id','user_id','created_at','updated_at'
    // ];

    protected $casts = [
    	'pickup_location' => 'array'
    ];


     public function bank()
     {
         return $this->belongsTo('App\Userbank','bank_id','id');
     }

     public function getorder()
     {
         return $this->belongsTo('App\InvoiceDownload','order_id','id');
     }

     public function user()
     {
         return $this->belongsTo('App\User','user_id','id');
     }

     public function mainOrder()
     {
         return $this->belongsTo('App\Order','main_order_id','id');
     }

}
