<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class ProductNotify extends Model
{
    protected $table = 'product_stock_subscription';

    protected $fillable = ['email','user_id','var_id'];

}
