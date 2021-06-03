<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrderActivityLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('order_activity_logs') ) {
			Schema::create('order_activity_logs', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('order_id', 191);
				$table->integer('inv_id')->unsigned();
				$table->integer('user_id')->unsigned();
				$table->integer('variant_id')->unsigned()->nullable();
				$table->text('log', 65535);
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
		Schema::drop('order_activity_logs');
	}

}
