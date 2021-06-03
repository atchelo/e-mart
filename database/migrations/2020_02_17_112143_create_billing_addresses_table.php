<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBillingAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('billing_addresses') ) {
			Schema::create('billing_addresses', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('total', 191)->nullable();
				$table->string('firstname', 191)->nullable();
				$table->string('address', 191)->nullable();
				$table->string('city', 191)->nullable();
				$table->string('state', 191)->nullable();
				$table->string('mobile', 191)->nullable();
				$table->integer('country_id')->nullable();
				$table->string('email', 191)->nullable();
				$table->integer('user_id')->unsigned()->nullable()->index('billing_addresses_user_id_foreign');
				$table->timestamps();
				$table->string('pincode', 191)->nullable();
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
		Schema::drop('billing_addresses');
	}

}
