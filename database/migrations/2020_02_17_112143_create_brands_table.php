<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBrandsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('brands') ) {
			Schema::create('brands', function(Blueprint $table)
			{
				$table->increments('id');
				$table->text('category_id', 65535)->nullable();
				$table->string('name', 191)->nullable();
				$table->string('image', 191)->nullable();
				$table->enum('status', array('0','1'))->nullable();
				$table->timestamps();
				$table->string('show_image', 191)->nullable();
				$table->integer('is_requested')->default(0);
				$table->text('brand_proof', 65535)->nullable();
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
		Schema::drop('brands');
	}

}
