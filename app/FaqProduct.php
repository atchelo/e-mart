<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaqProduct extends Model
{
    protected $fillable = [

        'question', 'answer', 'pro_id',

    ];

    public function product()
    {
        return $this->belongsTo('App\Product', 'pro_id','id');
    }

}
