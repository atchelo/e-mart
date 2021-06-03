<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsedCoupansTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('used_coupans') ) {
			Schema::create('used_coupans', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('coupan_id')->unsigned()->nullable();
				$table->integer('user_id')->unsigned()->nullable();
				$table->integer('used_coupan')->unsigned()->nullable();
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
		Schema::drop('used_coupans');
	}

}
