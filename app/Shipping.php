<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public $timestamps = false;

    
    protected $fillable = ['name', 'price','type','login','free','default_status'];
}
