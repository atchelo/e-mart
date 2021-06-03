<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSellerpayoutsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('sellerpayouts') ) {
			Schema::create('sellerpayouts', function(Blueprint $table)
			{
				$table->integer('id')->unsigned()->primary();
				$table->string('payoutid', 100);
				$table->bigInteger('orderid')->unsigned();
				$table->integer('sellerid')->unsigned();
				$table->integer('paidby')->unsigned();
				$table->string('paid_in', 191);
				$table->float('orderamount', 10, 0);
				$table->float('txn_fee', 10, 0)->nullable()->default(0);
				$table->text('txn_id', 65535);
				$table->string('status', 11)->nullable();
				$table->string('txn_type', 100)->nullable();
				$table->string('paidvia', 100);
				$table->string('acno', 191)->nullable();
				$table->string('ifsccode', 191)->nullable();
				$table->string('bankname', 191)->nullable();
				$table->string('acholder', 191)->nullable();
				$table->bigInteger('pending_payout_id')->unsigned();
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
		Schema::drop('sellerpayouts');
	}

}
