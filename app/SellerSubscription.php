<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'user_id',
        'txn_id',
        'method',
        'start_date',
        'end_date',
        'status',
        'original_amount',
        'paid_amount',
        'paid_currency'
    ];

    public function plan(){
        return $this->belongsTo('App\SellerPlans','plan_id','id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id','id');
    }
}
