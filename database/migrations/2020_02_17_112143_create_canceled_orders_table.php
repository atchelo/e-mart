<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCanceledOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('canceled_orders') ) {
			Schema::create('canceled_orders', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('order_id')->unsigned();
				$table->integer('inv_id')->unsigned()->nullable();
				$table->integer('user_id')->unsigned();
				$table->text('comment', 65535)->nullable();
				$table->string('method_choosen', 191)->nullable();
				$table->float('amount', 10, 0);
				$table->string('is_refunded', 100)->nullable();
				$table->integer('bank_id')->nullable();
				$table->text('transaction_id')->nullable();
				$table->float('txn_fee', 10, 0)->unsigned()->nullable();
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
		Schema::drop('canceled_orders');
	}

}
