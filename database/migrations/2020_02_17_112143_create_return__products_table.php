<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReturnProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('return__products') ) {
			Schema::create('return__products', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('method_choosen', 100);
				$table->string('pay_mode', 100);
				$table->integer('user_id')->unsigned();
				$table->integer('order_id')->unsigned();
				$table->integer('main_order_id')->unsigned();
				$table->integer('qty')->unsigned();
				$table->float('amount', 10, 0)->unsigned();
				$table->string('txn_id', 191);
				$table->string('txn_fee', 191)->nullable();
				$table->text('pickup_location', 65535);
				$table->text('reason', 65535);
				$table->string('status', 100);
				$table->text('additional_comment', 65535)->nullable();
				$table->integer('bank_id')->unsigned()->nullable();
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
		Schema::drop('return__products');
	}

}
