<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyCheckout extends Model
{
    protected $fillable = ['multicurrency_id','currency','default','checkout_currency','payment_method','created_at','updated_at'];
}
