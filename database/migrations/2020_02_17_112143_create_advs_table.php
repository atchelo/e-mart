<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdvsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('advs') ) {
			Schema::create('advs', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('layout', 100);
				$table->string('position', 191);
				$table->integer('status')->unsigned();
				$table->string('image1', 191)->nullable();
				$table->string('image2', 191)->nullable();
				$table->string('image3', 191)->nullable();
				$table->text('url1', 65535)->nullable();
				$table->text('url2', 65535)->nullable();
				$table->text('url3', 65535)->nullable();
				$table->integer('pro_id1')->unsigned()->nullable();
				$table->integer('pro_id2')->unsigned()->nullable();
				$table->integer('pro_id3')->unsigned()->nullable();
				$table->integer('cat_id1')->unsigned()->nullable();
				$table->integer('cat_id2')->unsigned()->nullable();
				$table->integer('cat_id3')->unsigned()->nullable();
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
		Schema::drop('advs');
	}

}
