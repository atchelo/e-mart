<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Spatie\Translatable\HasTranslations;

class Genral extends Model
{
	use HasTranslations;

	public $translatable = ['project_name','title','address','copyright'];

    protected $fillable=[
	
		'project_name','email','title','currency_code','currency_symbol','pincode','logo','address','mobile','store_owner','login','status','copyright','right_click','inspect','wallet_enable','fevicon','guest_login','vendor_enable','cod','cart_amount','handlingcharge','chargeterm','captcha_enable','otp_enable','email_verify_enable'

	];
}
