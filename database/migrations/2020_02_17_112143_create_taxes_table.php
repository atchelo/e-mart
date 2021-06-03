<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('taxes') ) {
			Schema::create('taxes', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 191)->nullable();
				$table->integer('zone_id')->nullable();
				$table->string('rate', 191)->nullable();
				$table->enum('type', array('p','f'));
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
		Schema::drop('taxes');
	}

}
