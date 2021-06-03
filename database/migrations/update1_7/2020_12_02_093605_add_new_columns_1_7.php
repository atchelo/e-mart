<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumns17 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('orders')) {

            Schema::table('orders', function (Blueprint $table) {

                if (!Schema::hasColumn('orders', 'purchase_proof')) {

                    $table->longText('purchase_proof')->nullable();

                }

                if (!Schema::hasColumn('orders', 'manual_payment')) {
                    $table->integer('manual_payment')->unsigned()->default(0);
                }

            });

        }

        if (Schema::hasTable('bank_details')) {

            Schema::table('bank_details', function (Blueprint $table) {
            
                if (!Schema::hasColumn('bank_details', 'swift_code')) {

                    $table->string('swift_code')->nullable();

                }
            });
        }

        if (Schema::hasTable('configs')) {

            Schema::table('configs', function (Blueprint $table) {

                if (!Schema::hasColumn('configs', 'msg91_enable')) {

                    $table->integer('msg91_enable')->unsigned()->default(0);

                }
            });
        }

        if (Schema::hasTable('users')) {

            Schema::table('users', function (Blueprint $table) {

                if (!Schema::hasColumn('users', 'phonecode')) {

                    $table->string('phonecode')->nullable();

                }
            });
        }

        if (Schema::hasTable('stores')) {

            Schema::table('stores', function (Blueprint $table) {

                if (!Schema::hasColumn('stores', 'uuid')) {

                    $table->char('uuid',36)->nullable();

                }

                if (!Schema::hasColumn('stores', 'description')) {

                    $table->longText('description')->nullable();

                }

                if (!Schema::hasColumn('stores', 'cover_photo')) {

                    $table->string('cover_photo')->nullable();

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
