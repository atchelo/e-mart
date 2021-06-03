<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminReturnProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('admin_return_products') ) {
			Schema::create('admin_return_products', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 191)->nullable();
				$table->integer('created_by')->unsigned()->nullable();
				$table->string('return_acp', 191)->nullable();
				$table->string('amount', 191);
				$table->string('days', 191);
				$table->text('des', 65535);
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
		Schema::drop('admin_return_products');
	}

}
