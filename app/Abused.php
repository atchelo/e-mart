<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Abused extends Model
{
    protected $fillable = [
        'name', 'rep', 'status',
    ];
}
