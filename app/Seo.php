<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Translatable\HasTranslations;

class Seo extends Model
{
	use HasTranslations;

	public $translatable = ['project_name','metadata_des','metadata_key'];

    protected $fillable=[
	
		'metadata_des','metadata_key','google_analysis','fb_pixel','project_name',

	];

}