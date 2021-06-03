<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCurrencyListTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('currency_list') ) {
			Schema::create('currency_list', function(Blueprint $table)
			{
				$table->integer('id', true);
				$table->string('country', 191)->nullable();
				$table->string('currency_list', 191)->nullable();
				$table->string('code', 191)->nullable();
				$table->string('symbol', 191)->nullable();
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
		Schema::drop('currency_list');
	}

}
