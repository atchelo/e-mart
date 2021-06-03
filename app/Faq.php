<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
	use HasTranslations;

	public $translatable = ['que','ans'];

  	protected $fillable=[
	
		'que','ans','status'

	];
   
}
