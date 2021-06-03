<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VisitorChart extends Model
{
    protected $fillable = [
        'country_code','ip_address','visit_count'
    ];
}
