<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('comments') ) {
			Schema::create('comments', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 191);
				$table->string('email', 191);
				$table->text('comment', 65535);
				$table->integer('approved')->unsigned();
				$table->integer('pro_id')->unsigned();
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
		Schema::drop('comments');
	}

}
