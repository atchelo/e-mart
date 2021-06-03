<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommissionSetting extends Model
{
    protected $fillable = [
		'rate','type','p_type',
	];
}
