<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerPlans extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id','name','price','detail','validity','period','product_create','csv_product','status'
    ];

    public function subscriptions(){
        return $this->hasMany('App\SellerSubscription','plan_id');
    }
}
