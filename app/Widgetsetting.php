<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Widgetsetting extends Model
{
    protected $fillable = [

    	'home','shop'

    ];

    public $timestamps = false;
}
