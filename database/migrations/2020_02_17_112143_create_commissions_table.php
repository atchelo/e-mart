<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('commissions') ) {
			Schema::create('commissions', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('category_id')->unsigned();
				$table->string('rate', 191)->nullable();
				$table->enum('type', array('p','f'));
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
		Schema::drop('commissions');
	}

}
