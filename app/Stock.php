<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Stock extends Model
{
    protected $fillable = [
        'display_stock', 'stock_delivery','status'
    ];
}
