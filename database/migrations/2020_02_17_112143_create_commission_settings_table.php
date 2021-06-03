<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommissionSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('commission_settings') ) {
			Schema::create('commission_settings', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('rate', 191)->nullable();
				$table->enum('type', array('c','flat'));
				$table->enum('p_type', array('p','f',''));
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
		Schema::drop('commission_settings');
	}

}
