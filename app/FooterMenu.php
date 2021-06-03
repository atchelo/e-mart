<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FooterMenu extends Model
{
	use HasTranslations;

    public $timestamps = false;

    public $translatable = ['title'];

    protected $fillable = [
    	'link_by', 'title', 'position', 'widget_postion','page_id','url','status'
    ];

    public function gotopage(){
    	return $this->belongsTo('App\Page','page_id','id');
    }
}
