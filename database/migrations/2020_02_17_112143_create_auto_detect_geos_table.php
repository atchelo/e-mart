<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAutoDetectGeosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('auto_detect_geos') ) {
			Schema::create('auto_detect_geos', function(Blueprint $table)
			{
				$table->increments('id');
				$table->enum('enabel_multicurrency', array('0','1'))->default('0');
				$table->enum('auto_detect', array('0','1'))->nullable();
				$table->string('default_geo_location', 191)->nullable();
				$table->enum('currency_by_country', array('0','1'))->nullable();
				$table->enum('enable_cart_page', array('0','1'))->nullable();
				$table->enum('checkout_currency', array('0','1'))->nullable();
				$table->timestamps();
			});
		}
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('auto_detect_geos');
	}

}
