<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintainence extends Model
{
    protected $table = 'table_maintainence_mode';

    protected $fillable = ['allowed_ips','message','status'];

    protected $casts = ['allowed_ips' => 'array'];
}
