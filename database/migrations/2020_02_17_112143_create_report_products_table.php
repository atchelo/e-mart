<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateReportProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('report_products') ) {
			Schema::create('report_products', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('pro_id')->unsigned();
				$table->string('title', 191);
				$table->string('email', 191);
				$table->text('des', 65535);
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
		Schema::drop('report_products');
	}

}
