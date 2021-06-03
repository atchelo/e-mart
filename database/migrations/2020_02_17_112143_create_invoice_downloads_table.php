<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceDownloadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('invoice_downloads') ) {
			Schema::create('invoice_downloads', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('inv_no', 100)->nullable();
				$table->string('order_id', 191);
				$table->integer('qty')->unsigned();
				$table->integer('variant_id')->unsigned();
				$table->integer('vender_id')->unsigned();
				$table->float('price', 10, 0)->unsigned();
				$table->float('discount', 10, 0)->nullable()->default(0);
				$table->string('tax_amount', 100)->nullable();
				$table->string('shipping', 100)->nullable();
				$table->float('handlingcharge', 10, 0)->default(0);
				$table->string('status', 100)->nullable()->default('Pending');
				$table->string('local_pick', 100)->nullable();
				$table->dateTime('loc_deliv_date')->nullable();
				$table->timestamps();
				$table->string('paid_to_seller', 100)->default('YES');
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
		Schema::drop('invoice_downloads');
	}

}
