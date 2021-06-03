<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Menu extends Model
{
    use HasTranslations;

    public $translatable = ['title','tag_text'];

    public $timestamps = false;

    protected $fillable = [

    	 'title','icon','link_by','cat_id','page_id','url','show_cat_in_dropdown','linked_parent','show_child_in_dropdown','linked_child','bannerimage','img_link','menu_tag','tag_bg','tag_color','tag_text','status','position','show_image'

    ];

    protected $casts = ['linked_parent' => 'array', 'linked_child' => 'array'];

    public function gotopage(){
    	return $this->belongsTo('App\Page','page_id','id');
    }

    
}
