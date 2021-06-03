<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBankDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('bank_details') ) {
			Schema::create('bank_details', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('bankname', 191)->nullable();
				$table->string('branchname', 191)->nullable();
				$table->string('ifsc', 191)->nullable();
				$table->string('account', 191)->nullable();
				$table->string('acountname', 191)->nullable();
				$table->enum('status', array('0','1'))->nullable();
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
		Schema::drop('bank_details');
	}

}
