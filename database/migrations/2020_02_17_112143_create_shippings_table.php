<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShippingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('shippings') ) {
			Schema::create('shippings', function(Blueprint $table)
			{
				$table->integer('id')->unsigned()->primary();
				$table->string('name', 191)->nullable();
				$table->float('price', 10, 0)->nullable();
				$table->string('free', 191)->nullable();
				$table->enum('login', array('0','1'));
				$table->enum('default_status', array('0','1'));
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
		Schema::drop('shippings');
	}

}
