<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWidgetFootersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('widget_footers') ) {
			Schema::create('widget_footers', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('widget_name', 191)->nullable();
				$table->string('widget_position', 191)->nullable();
				$table->string('menu_name', 191)->nullable();
				$table->string('url', 191)->nullable();
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
		Schema::drop('widget_footers');
	}

}
