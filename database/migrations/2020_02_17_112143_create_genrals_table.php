<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGenralsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('genrals') ) {
			Schema::create('genrals', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('project_name', 191)->nullable();
				$table->text('email', 65535)->nullable();
				$table->string('title', 191)->nullable();
				$table->string('currency_code', 191)->nullable();
				$table->string('currency_symbol', 191)->nullable();
				$table->string('pincode', 191)->nullable();
				$table->string('copyright', 191)->nullable();
				$table->string('logo', 191)->nullable();
				$table->string('fevicon', 191)->nullable();
				$table->text('address', 65535)->nullable();
				$table->string('mobile', 191)->nullable();
				$table->integer('login')->unsigned();
				$table->enum('right_click', array('0','1'));
				$table->enum('inspect', array('0','1'));
				$table->enum('guest_login', array('0','1'));
				$table->enum('status', array('0','1'));
				$table->integer('vendor_enable');
				$table->timestamps();
				$table->float('cart_amount', 10, 0)->nullable();
				$table->float('handlingcharge', 10, 0)->default(0);
				$table->string('chargeterm', 100)->default('fo');
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
		Schema::drop('genrals');
	}

}
