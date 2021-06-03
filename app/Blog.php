<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Spatie\Translatable\HasTranslations;

class Blog extends Model implements Viewable
{
	use InteractsWithViews;

	use HasTranslations;

	public $translatable = ['heading','user','about','post','des'];

    protected $fillable = [
        'heading', 'image', 'des','user','status','about','post','slug'
    ];

    public function comments(){
		return $this->hasMany('App\BlogComment','post_id');
    }
}
