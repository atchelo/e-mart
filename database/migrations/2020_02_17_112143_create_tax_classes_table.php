<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTaxClassesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('tax_classes') ) {
			Schema::create('tax_classes', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('title', 191)->nullable();
				$table->string('des', 191)->nullable();
				$table->text('taxRate_id', 65535)->nullable();
				$table->string('priority', 191)->nullable();
				$table->string('based_on', 191)->nullable();
				$table->timestamps();
				$table->enum('status', array('0','1'))->default('0');
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
		Schema::drop('tax_classes');
	}

}
