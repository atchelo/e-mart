<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('blogs') ) {
			Schema::create('blogs', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('heading', 191);
				$table->text('slug', 65535);
				$table->string('image', 191);
				$table->text('des', 65535);
				$table->string('user', 191);
				$table->text('about', 65535)->nullable();
				$table->string('post', 191)->nullable();
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
		Schema::drop('blogs');
	}

}
