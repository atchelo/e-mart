<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShippingWeightsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('shipping_weights') ) {
			Schema::create('shipping_weights', function(Blueprint $table)
			{
				$table->integer('id')->unsigned()->primary();
				$table->integer('vender_id')->nullable();
				$table->string('weight_from_0', 191)->nullable();
				$table->string('weight_to_0', 191)->nullable();
				$table->string('weight_price_0', 191)->nullable();
				$table->string('per_oq_0', 191)->nullable();
				$table->string('weight_from_1', 191)->nullable();
				$table->string('weight_to_1', 191)->nullable();
				$table->string('weight_price_1', 191)->nullable();
				$table->string('per_oq_1', 191)->nullable();
				$table->string('weight_from_2', 191)->nullable();
				$table->string('weight_to_2', 191)->nullable();
				$table->string('weight_price_2', 191)->nullable();
				$table->string('per_oq_2', 191)->nullable();
				$table->string('weight_from_3', 191)->nullable();
				$table->string('weight_to_3', 191)->nullable();
				$table->string('weight_price_3', 191)->nullable();
				$table->string('per_oq_3', 191)->nullable();
				$table->string('weight_from_4', 191)->nullable();
				$table->string('weight_price_4', 191)->nullable();
				$table->string('per_oq_4', 191)->nullable();
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
		Schema::drop('shipping_weights');
	}

}
