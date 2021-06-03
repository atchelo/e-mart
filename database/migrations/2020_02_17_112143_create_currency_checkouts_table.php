<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrencyCheckoutsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('currency_checkouts') ) {
			Schema::create('currency_checkouts', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('multicurrency_id')->nullable();
				$table->string('currency', 191)->nullable();
				$table->enum('default', array('0','1'))->default('0');
				$table->string('checkout_currency', 191)->nullable();
				$table->string('payment_method', 191)->nullable();
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
		Schema::drop('currency_checkouts');
	}

}
