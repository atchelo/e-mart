<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDashboardSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('dashboard_settings') ) {
			Schema::create('dashboard_settings', function(Blueprint $table)
			{
				$table->increments('id');
				$table->boolean('lat_ord')->nullable();
				$table->boolean('rct_str')->nullable();
				$table->boolean('rct_pro')->nullable();
				$table->boolean('rct_cust')->nullable();
				$table->string('max_item_ord', 191)->nullable();
				$table->string('max_item_str', 191)->nullable();
				$table->string('max_item_pro', 191)->nullable();
				$table->string('max_item_cust', 191)->nullable();
				$table->boolean('fb_wid')->nullable();
				$table->boolean('tw_wid')->nullable();
				$table->string('fb_page_id', 191)->nullable();
				$table->string('fb_page_token', 191)->nullable();
				$table->string('tw_username', 191)->nullable();
				$table->string('inst_username', 191)->nullable();
				$table->boolean('insta_wid')->nullable();
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
		Schema::drop('dashboard_settings');
	}

}
