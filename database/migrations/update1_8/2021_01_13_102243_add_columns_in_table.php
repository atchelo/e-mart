<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('wishlists')) {

            Schema::table('wishlists', function (Blueprint $table) {

                if (!Schema::hasColumn('wishlists', 'collection_id')) {

                    $table->integer('collection_id')->unsigned()->nullable();

                }

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
        //No code
    }
}
