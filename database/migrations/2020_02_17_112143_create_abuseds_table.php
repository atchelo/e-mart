<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAbusedsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('abuseds') ) {
			Schema::create('abuseds', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 191);
				$table->string('rep', 191);
				$table->enum('status', array('0','1',''));
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
		Schema::drop('abuseds');
	}

}
