<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePinCodsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('pin_cods') ) {
			Schema::create('pin_cods', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('country_id')->unsigned()->nullable();
				$table->integer('state_id')->unsigned()->nullable();
				$table->integer('city_id')->unsigned()->nullable();
				$table->string('pin_code', 191)->nullable();
				$table->boolean('status')->nullable();
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
		Schema::drop('pin_cods');
	}

}
