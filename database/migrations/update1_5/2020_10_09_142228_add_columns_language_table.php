<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsLanguageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('locales')){
            Schema::table('locales', function (Blueprint $table) {
                if (!Schema::hasColumn('locales', 'rtl_available')){
                    $table->integer('rtl_available')->default(0)->unsigned();
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
        Schema::table('locales', function (Blueprint $table) {
            $table->dropColumn('rtl_available');
        });
    }
}
