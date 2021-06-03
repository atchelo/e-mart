<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserReviewsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('user_reviews') ) {
			Schema::create('user_reviews', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('pro_id')->unsigned();
				$table->string('remark', 191)->nullable();
				$table->integer('user')->nullable();
				$table->string('summary', 191)->nullable();
				$table->string('review', 191)->nullable();
				$table->integer('qty')->unsigned()->nullable();
				$table->integer('price')->unsigned()->nullable();
				$table->integer('value')->unsigned()->nullable();
				$table->enum('status', array('0','1'));
				$table->string('2', 191)->nullable();
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
		Schema::drop('user_reviews');
	}

}
