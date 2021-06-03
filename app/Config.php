<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = [
        'MERCHANT_KEY','instamojo_key','instamojo_auth_key','paytm_enable','instamojo_enable','stripe_enable','paypal_enable','braintree_enable','paystack_enable'
    ];

}
