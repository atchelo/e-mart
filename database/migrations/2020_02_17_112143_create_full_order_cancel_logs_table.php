<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFullOrderCancelLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('full_order_cancel_logs') ) {
			Schema::create('full_order_cancel_logs', function(Blueprint $table)
			{
				$table->integer('id', true);
				$table->integer('order_id');
				$table->string('inv_id', 191);
				$table->integer('user_id')->unsigned();
				$table->string('method_choosen', 10)->nullable();
				$table->string('comment', 191)->nullable();
				$table->text('txn_id');
				$table->string('status', 191)->nullable();
				$table->float('amount', 10, 0);
				$table->float('txn_fee', 10, 0)->nullable();
				$table->integer('bank_id')->unsigned()->nullable();
				$table->string('is_refunded', 100)->nullable();
				$table->dateTime('read_at')->nullable();
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
		Schema::drop('full_order_cancel_logs');
	}

}
