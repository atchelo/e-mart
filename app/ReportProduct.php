<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportProduct extends Model
{
    protected $fillable = [
    	'pro_id','title','email','des'
    ];
}
