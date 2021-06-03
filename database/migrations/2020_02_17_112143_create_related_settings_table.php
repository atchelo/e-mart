<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelatedSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('related_settings') ) {
			Schema::create('related_settings', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('pro_id')->nullable();
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
		Schema::drop('related_settings');
	}

}
