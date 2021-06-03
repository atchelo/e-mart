<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumns22 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('products')) {

            Schema::table('products', function (Blueprint $table) {

                if (!Schema::hasColumn('products', 'gift_pkg_charge')) {

                    $table->double('gift_pkg_charge')->default(0);

                }

            });

        }

        if (Schema::hasTable('users')) {

            Schema::table('users', function (Blueprint $table) {

                if (!Schema::hasColumn('users', 'google2fa_secret')) {

                    $table->string('google2fa_secret')->nullable();

                }

                if (!Schema::hasColumn('users', 'google2fa_enable')) {

                    $table->integer('google2fa_enable')->default(0)->unsigned();

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
        //
    }
}
