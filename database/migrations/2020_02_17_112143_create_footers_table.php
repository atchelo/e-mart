<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFootersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('footers') ) {
			Schema::create('footers', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('shiping', 191)->nullable();
				$table->string('mobile', 191)->nullable();
				$table->string('return', 191)->nullable();
				$table->string('money', 191)->nullable();
				$table->string('icon_section1', 100)->nullable();
				$table->string('icon_section2', 100)->nullable();
				$table->string('icon_section3', 100)->nullable();
				$table->string('icon_section4', 100)->nullable();
				$table->string('footer2', 191)->nullable();
				$table->string('footer3', 191)->nullable();
				$table->string('footer4', 191)->nullable();
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
		Schema::drop('footers');
	}

}
