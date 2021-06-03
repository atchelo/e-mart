<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $table = 'blogcomments';

    protected $fillable = ['name','email','comment','post_id','status'];

    public function post(){
    	return $this->belongsTo('App\Blog','post_id','id');
    }
}
