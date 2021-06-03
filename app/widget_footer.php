<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class widget_footer extends Model
{
     protected $fillable = [
		'widget_name','widget_position','menu_name','url','status',
	];
}
