<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLocalesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('locales') ) {
			Schema::create('locales', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('lang_code', 191)->nullable();
				$table->string('name', 191)->nullable();
				$table->integer('def')->unsigned()->default(0);
				$table->integer('status')->unsigned()->default(0);
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
		Schema::drop('locales');
	}

}
