<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHotdealsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('hotdeals') ) {
			Schema::create('hotdeals', function(Blueprint $table)
			{
				$table->increments('id')->unsigned();
				$table->integer('pro_id')->unsigned()->nullable();
				$table->enum('status', array('0','1'));
				$table->timestamps();
				$table->date('start');
				$table->date('end');
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
		Schema::drop('hotdeals');
	}

}
