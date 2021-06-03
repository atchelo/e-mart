<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFrontCatsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('front_cats') ) {
			Schema::create('front_cats', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 191)->nullable();
				$table->enum('status', array('0','1'))->nullable();
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
		Schema::drop('front_cats');
	}

}
