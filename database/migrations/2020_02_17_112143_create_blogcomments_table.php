<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlogcommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('blogcomments') ) {
			Schema::create('blogcomments', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('post_id')->unsigned();
				$table->string('name', 191);
				$table->string('email', 191);
				$table->text('comment', 65535);
				$table->integer('status')->unsigned()->default(1);
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
		Schema::drop('blogcomments');
	}

}
