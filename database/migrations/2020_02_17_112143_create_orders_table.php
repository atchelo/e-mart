<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('orders') ) {
			Schema::create('orders', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('order_id', 191)->nullable();
				$table->integer('qty_total')->unsigned()->nullable();
				$table->integer('user_id')->unsigned()->nullable()->index('orders_user_id_foreign');
				$table->string('vender_ids', 191)->nullable();
				$table->string('pro_id', 191)->nullable();
				$table->string('main_pro_id', 191)->nullable();
				$table->integer('delivery_address')->unsigned()->nullable();
				$table->text('billing_address', 65535)->nullable();
				$table->string('payment_method', 191)->nullable();
				$table->enum('payment_receive', array('no','yes'));
				$table->string('transaction_id', 191)->nullable();
				$table->string('sale_id', 191)->nullable();
				$table->string('order_status', 191)->nullable();
				$table->integer('status');
				$table->float('discount', 10, 0);
				$table->string('distype', 100)->nullable();
				$table->string('coupon', 191)->nullable();
				$table->float('order_total', 10, 0)->unsigned()->nullable();
				$table->float('handlingcharge', 10, 0)->nullable()->default(0);
				$table->string('shipping', 191)->nullable();
				$table->string('paid_in', 200)->nullable();
				$table->string('tax_amount', 191)->nullable();
				$table->timestamps();
				$table->string('paid_in_currency', 100)->nullable();
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
		Schema::drop('orders');
	}

}
