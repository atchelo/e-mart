<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddSubVariant extends Model
{
    protected $fillable = [
    	'main_attr_id','main_attr_value','pro_id','price','stock','def','min_order_qty','max_order_qty','weight','w_unit'
    ];

    protected $casts = [
    'main_attr_id' => 'array', // Will convarted to (Array)
    'main_attr_value' => 'array'
   ];

   use SoftDeletes;

  protected $dates = ['deleted_at'];

   public function products()
   {
   	 return $this->belongsTo('App\Product','pro_id','id')->withTrashed();
   }

   public function variantimages(){
    return $this->hasOne('App\VariantImages','var_id');
   }

   public function unitname()
   {
     return $this->belongsTo('App\UnitValues','w_unit','id');
   }

   public function order(){
      return $this->hasMany('App\InvoiceDownload','variant_id');
   }

   
}