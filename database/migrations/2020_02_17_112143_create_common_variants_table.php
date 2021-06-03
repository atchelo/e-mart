<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommonVariantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('common_variants') ) {
			Schema::create('common_variants', function(Blueprint $table)
			{
				$table->increments('id');
				$table->integer('cm_attr_id')->unsigned();
				$table->integer('cm_attr_val')->unsigned();
				$table->integer('pro_id')->unsigned();
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
		Schema::drop('common_variants');
	}

}
