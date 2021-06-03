<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpecialOffersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('special_offers') ) {
			Schema::create('special_offers', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('pro_id')->unsigned();
				$table->timestamps();
				$table->enum('status', array('0','1'))->nullable()->default('0');
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
		Schema::drop('special_offers');
	}

}
