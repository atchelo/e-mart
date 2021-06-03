<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('coupans')) {

            Schema::table('coupans', function (Blueprint $table) {

                if (!Schema::hasColumn('coupans', 'description')) {

                    $table->longText('description')->nullable();

                }

            });

        }

        if (Schema::hasTable('carts')) {

            Schema::table('carts', function (Blueprint $table) {

                if (!Schema::hasColumn('carts', 'coupan_id')) {

                    $table->integer('coupan_id')->nullable()->unsigned();

                }

            });

        }

        if (Schema::hasTable('addresses')) {

            Schema::table('addresses', function (Blueprint $table) {

                if (!Schema::hasColumn('addresses', 'type')) {

                    $table->string('type')->nullable();

                }

            });

        }

        if (Schema::hasTable('billing_addresses')) {

            Schema::table('billing_addresses', function (Blueprint $table) {

                if (!Schema::hasColumn('billing_addresses', 'type')) {

                    $table->string('type')->nullable();

                }

            });

        }

        if (Schema::hasTable('configs')) {

            Schema::table('configs', function (Blueprint $table) {

                if (!Schema::hasColumn('configs', 'sms_channel')) {

                    $table->integer('sms_channel')->default(0);

                }

            });

        }

        if (Schema::hasTable('invoice_downloads')) {

            Schema::table('invoice_downloads', function (Blueprint $table) {

                if (!Schema::hasColumn('invoice_downloads', 'tracking_id')) {

                    $table->char('tracking_id',36)->nullable();

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
