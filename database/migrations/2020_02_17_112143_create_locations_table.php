<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('locations') ) {
			Schema::create('locations', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('multi_currency')->nullable();
				$table->string('country_id', 191)->nullable();
				$table->string('currency', 191)->nullable();
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
		Schema::drop('locations');
	}

}
