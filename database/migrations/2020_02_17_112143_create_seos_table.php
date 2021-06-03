<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSeosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('seos') ) {
			Schema::create('seos', function(Blueprint $table)
			{
				$table->integer('id')->unsigned()->primary();
				$table->string('project_name', 191)->nullable();
				$table->text('metadata_des', 65535)->nullable();
				$table->text('metadata_key', 65535)->nullable();
				$table->text('google_analysis', 65535)->nullable();
				$table->text('fb_pixel', 65535)->nullable();
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
		Schema::drop('seos');
	}

}
