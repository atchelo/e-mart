<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHelpDesksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( !Schema::hasTable('help_desks') ) {
			Schema::create('help_desks', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('ticket_no', 191);
				$table->string('issue_title', 191);
				$table->string('user_id', 191);
				$table->text('issue', 65535);
				$table->string('status', 191);
				$table->string('image', 191)->nullable();
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
		Schema::drop('help_desks');
	}

}
