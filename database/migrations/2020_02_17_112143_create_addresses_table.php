<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('addresses') ) {
			Schema::create('addresses', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 191)->nullable();
				$table->text('address', 65535)->nullable();
				$table->bigInteger('phone');
				$table->string('email', 191)->nullable();
				$table->bigInteger('pin_code')->nullable();
				$table->integer('city_id')->unsigned();
				$table->integer('state_id')->unsigned();
				$table->integer('country_id')->unsigned();
				$table->boolean('defaddress')->nullable();
				$table->integer('user_id')->unsigned();
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
		Schema::drop('addresses');
	}

}
