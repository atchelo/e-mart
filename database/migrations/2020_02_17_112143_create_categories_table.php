<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('categories') ) {
			Schema::create('categories', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('title', 191)->nullable();
				$table->string('icon', 191)->nullable();
				$table->string('image', 191)->nullable();
				$table->text('description', 65535)->nullable();
				$table->integer('position')->unsigned()->nullable();
				$table->enum('status', array('0','1'));
				$table->enum('featured', array('0','1'));
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
		Schema::drop('categories');
	}

}
