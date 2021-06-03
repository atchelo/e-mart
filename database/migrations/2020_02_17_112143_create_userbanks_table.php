<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserbanksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('userbanks') ) {
			Schema::create('userbanks', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('bankname', 191);
				$table->bigInteger('acno');
				$table->string('acname', 191);
				$table->string('ifsc', 191);
				$table->integer('user_id')->unsigned();
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
		Schema::drop('userbanks');
	}

}
