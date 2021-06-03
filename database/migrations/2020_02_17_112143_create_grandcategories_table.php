<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGrandcategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('grandcategories') ) {
			Schema::create('grandcategories', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('title', 191)->nullable();
				$table->string('image', 191)->nullable();
				$table->text('description', 65535)->nullable();
				$table->integer('parent_id')->unsigned()->index('grandcategories_parent_id_foreign');
				$table->integer('subcat_id')->unsigned()->index('grandcategories_subcat_id_foreign');
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
		Schema::drop('grandcategories');
	}

}
