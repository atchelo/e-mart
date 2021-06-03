<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelatedproductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('relatedproducts') ) {
			Schema::create('relatedproducts', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('product_id')->unsigned()->nullable();
				$table->text('related_pro', 65535)->nullable();
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
		Schema::drop('relatedproducts');
	}

}
