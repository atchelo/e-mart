<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductAttributesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('product_attributes') ) {
			Schema::create('product_attributes', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('attr_name', 191);
				$table->string('cats_id', 191)->nullable();
				$table->integer('unit_id')->unsigned()->nullable();
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
		Schema::drop('product_attributes');
	}

}
