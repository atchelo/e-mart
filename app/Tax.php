<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Tax extends Model
{
	    protected $fillable = [
			'tax_class','rate','type','status','zone_id','name',
		];


	 	public function tax(){
      		return $this->belongsTo(TaxClass::class,'tax_class');  
      	}

      	public function zone(){
      		return $this->belongsTo(Zone::class,'zone_id');  
      	}

      	
}
