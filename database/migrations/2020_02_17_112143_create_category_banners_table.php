<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryBannersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('category_banners') ) {
			Schema::create('category_banners', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('category_id')->unsigned()->index('category_banners_category_id_foreign');
				$table->integer('child')->unsigned()->index('category_banners_child_foreign');
				$table->integer('product_id')->unsigned()->index('category_banners_product_id_foreign');
				$table->string('heading', 191)->nullable();
				$table->string('buttonlink', 191)->nullable();
				$table->string('buttonname', 191)->nullable();
				$table->string('Image', 191)->nullable();
				$table->text('des', 65535)->nullable();
				$table->enum('status', array('0','1'));
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
		Schema::drop('category_banners');
	}

}
