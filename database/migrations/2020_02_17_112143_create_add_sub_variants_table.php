<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddSubVariantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('add_sub_variants') ) {
			Schema::create('add_sub_variants', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('main_attr_id', 191);
				$table->string('main_attr_value', 191)->nullable();
				$table->float('price', 10, 0)->nullable();
				$table->integer('stock')->unsigned()->nullable();
				$table->integer('pro_id')->unsigned();
				$table->float('weight', 10, 0)->default(0);
				$table->integer('w_unit')->nullable();
				$table->integer('min_order_qty')->unsigned();
				$table->integer('max_order_qty')->unsigned()->nullable();
				$table->integer('def')->nullable();
				$table->timestamps();
				$table->softDeletes();
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
		Schema::drop('add_sub_variants');
	}

}
