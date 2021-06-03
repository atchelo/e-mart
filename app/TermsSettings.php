<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TermsSettings extends Model
{
    protected $table = 'terms_settings';
    
    protected $fillable = ['key','title','description'];
    
}
