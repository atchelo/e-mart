<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWidgetsettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('widgetsettings') ) {
			Schema::create('widgetsettings', function(Blueprint $table)
			{
				$table->increments('id')->unsigned();
				$table->string('name', 191);
				$table->enum('home', array('0','1'));
				$table->enum('shop', array('0','1'));
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
		Schema::drop('widgetsettings');
	}

}
