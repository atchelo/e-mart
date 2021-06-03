<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategorySlidersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('category_sliders') ) {
			Schema::create('category_sliders', function(Blueprint $table)
			{
				$table->increments('id');
				$table->text('category_ids', 65535)->nullable();
				$table->integer('pro_limit')->unsigned()->nullable();
				$table->integer('status')->unsigned()->nullable();
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
		Schema::drop('category_sliders');
	}

}
