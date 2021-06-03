<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAllstatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('allstates') ) {
			Schema::create('allstates', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 30);
				$table->integer('country_id')->default(1);
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
		Schema::drop('allstates');
	}

}
