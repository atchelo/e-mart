<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admin_return_product extends Model
{
    protected $fillable = [
        'name','amount', 'days', 'des','status','return_acp','created_by'
    ];
}
