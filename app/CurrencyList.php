<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CurrencyList extends Model
{
    protected $table = 'currency_list';

    public $timestamps = false;

    public function currency()
    {
    	return $this->hasMany('App\multiCurrency','currency_id');
    }
}
