<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUnitValuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('unit_values') ) {
			Schema::create('unit_values', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('unit_values', 191);
				$table->string('short_code', 191)->nullable();
				$table->integer('unit_id')->unsigned();
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
		Schema::drop('unit_values');
	}

}
