<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsUpdate23 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {

            Schema::table('users', function (Blueprint $table) {

                if (!Schema::hasColumn('users', 'refer_code')) {

                    $table->string('refer_code')->nullable();

                }

                if (!Schema::hasColumn('users', 'refered_from')) {

                    $table->string('refered_from')->nullable();

                }

                if (!Schema::hasColumn('users', 'subs_id')) {

                    $table->integer('subs_id')->unsigned()->nullable();

                }

            });

        }

        if (Schema::hasTable('stores')) {

            Schema::table('stores', function (Blueprint $table) {

                if (!Schema::hasColumn('stores', 'document')) {

                    $table->longText('document')->nullable();

                }

            });

        }

        if (Schema::hasTable('carts')) {

            Schema::table('carts', function (Blueprint $table) {

                if (!Schema::hasColumn('carts', 'gift_pkg_charge')) {

                    $table->double('gift_pkg_charge')->default(0);

                }

            });

        }

        if (Schema::hasTable('orders')) {

            Schema::table('orders', function (Blueprint $table) {

                if (!Schema::hasColumn('orders', 'gift_charge')) {

                    $table->double('gift_charge')->default(0);

                }

            });

        }

        if (Schema::hasTable('invoice_downloads')) {

            Schema::table('invoice_downloads', function (Blueprint $table) {

                if (!Schema::hasColumn('invoice_downloads', 'gift_charge')) {

                    $table->double('gift_charge')->default(0);

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
