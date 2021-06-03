<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('pages') ) {
			Schema::create('pages', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 191)->nullable();
				$table->text('des', 65535)->nullable();
				$table->text('slug', 65535)->nullable();
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
		Schema::drop('pages');
	}

}
