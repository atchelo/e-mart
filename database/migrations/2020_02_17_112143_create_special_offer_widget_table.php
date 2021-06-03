<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSpecialOfferWidgetTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('special_offer_widget') ) {
			Schema::create('special_offer_widget', function(Blueprint $table)
			{
				$table->integer('id')->unsigned()->primary();
				$table->string('slide_count', 191);
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
		Schema::drop('special_offer_widget');
	}

}
