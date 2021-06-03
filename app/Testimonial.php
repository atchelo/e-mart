<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Testimonial extends Model
{
	use HasTranslations;

	public $translatable = ['name','post','des'];

    protected $fillable = [
        'name', 'des', 'post','rating','image','status',
    ];
}
