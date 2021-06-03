<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Footer extends Model
{
	use HasTranslations;

	public $translatable = ['shiping','mobile','return','money','footer2','footer3','footer4'];

    protected $fillable=[
	
		'shiping','mobile','return','money','footer2','footer3','footer4','icon_section1','icon_section2','icon_section3','icon_section4'

	];
}
