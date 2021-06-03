<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFaqProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('faq_products') ) {
			Schema::create('faq_products', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('pro_id', 191)->nullable();
				$table->text('question', 65535)->nullable();
				$table->text('answer', 65535)->nullable();
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
		Schema::drop('faq_products');
	}

}
