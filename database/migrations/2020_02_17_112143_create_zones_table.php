<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateZonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('zones') ) {
			Schema::create('zones', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('title', 191)->nullable();
				$table->integer('country_id')->unsigned()->nullable();
				$table->text('name', 65535)->nullable();
				$table->string('code', 191)->nullable();
				$table->enum('status', array('0','1'));
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
		Schema::drop('zones');
	}

}
