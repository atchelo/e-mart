<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCartsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('carts') ) {
			Schema::create('carts', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('qty')->unsigned()->nullable();
				$table->integer('user_id')->unsigned()->nullable()->index('carts_user_id_foreign');
				$table->integer('pro_id')->unsigned()->nullable()->index('carts_pro_id_foreign');
				$table->integer('variant_id')->nullable();
				$table->float('disamount', 10, 0)->nullable()->default(0);
				$table->string('distype', 100)->nullable();
				$table->float('semi_total', 10, 0)->nullable();
				$table->float('price_total', 10, 0)->nullable();
				$table->float('ori_price', 10, 0)->nullable();
				$table->float('ori_offer_price', 10, 0)->nullable();
				$table->float('tax_amount', 10, 0)->nullable();
				$table->enum('tax_type', array('p','f'))->nullable();
				$table->string('ship_type', 100)->nullable();
				$table->integer('vender_id')->nullable();
				$table->float('shipping', 10, 0)->nullable();
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
		Schema::drop('carts');
	}

}
