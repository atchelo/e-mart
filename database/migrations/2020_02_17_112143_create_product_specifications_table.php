<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductSpecificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('product_specifications') ) {
			Schema::create('product_specifications', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('pro_id')->unsigned();
				$table->string('prokeys', 191)->nullable();
				$table->text('provalues', 65535)->nullable();
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
		Schema::drop('product_specifications');
	}

}
