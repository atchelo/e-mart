<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductValuesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('product_values') ) {
			Schema::create('product_values', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('values', 191)->nullable();
				$table->string('atrr_id', 191);
				$table->string('unit_value', 191)->nullable();
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
		Schema::drop('product_values');
	}

}
