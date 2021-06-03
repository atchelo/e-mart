<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupan extends Model
{

    protected $fillable = [
        'code', 'distype', 'amount', 'link_by', 'maxusage', 'minamount', 'expirydate', 'pro_id', 'cat_id', 'is_login',
    ];

    public function cate()
    {
        return $this->belongsTo("App\Category", "cat_id",'id');
    }

    public function product()
    {
        return $this->belongsTo("App\Product", "pro_id",'id');
    }

}
