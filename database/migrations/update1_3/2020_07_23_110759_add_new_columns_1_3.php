<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumns13 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('genrals') ) {

            Schema::table('genrals', function(Blueprint $table){

                if (!Schema::hasColumn('genrals', 'otp_enable')){
                    $table->integer('otp_enable')->unsigned()->default(0);
                }

                if (!Schema::hasColumn('genrals', 'captcha_enable')){
                    $table->integer('captcha_enable')->unsigned()->default(0);
                }

                if (!Schema::hasColumn('genrals', 'braintree_enable')){
                    $table->integer('braintree_enable')->unsigned()->default(0);
                }

                if (!Schema::hasColumn('genrals', 'wallet_enable')){
                    $table->integer('wallet_enable')->unsigned()->default(0);
                }
            });

        }

        if(Schema::hasTable('users') ) {
            Schema::table('users', function(Blueprint $table){

                if (!Schema::hasColumn('users', 'is_verified')){
                    $table->integer('is_verified')->unsigned()->default(1);
                }

                if (!Schema::hasColumn('users', 'braintree_id')){
                    $table->string('braintree_id')->nullable();
                }

            });
        }

        if(Schema::hasTable('configs') ) {

            Schema::table('configs', function(Blueprint $table){

                if (!Schema::hasColumn('configs', 'braintree_enable')){
                    $table->integer('braintree_enable')->unsigned()->default(0);
                }

                if (!Schema::hasColumn('configs', 'paystack_enable')){
                    $table->integer('paystack_enable')->unsigned()->default(0);
                }

            });
        }

        if(Schema::hasTable('stores') ) {
            Schema::table('stores', function(Blueprint $table){
                if (!Schema::hasColumn('stores', 'vat_no')){
                    $table->string('vat_no')->nullable();
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
        Schema::table('configs', function (Blueprint $table) {
            $table->dropColumn('braintree_enable');
            $table->dropColumn('paystack_enable');
        });

        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('vat_no');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_verified');
            $table->dropColumn('braintree_id');
        });

        Schema::table('genrals', function (Blueprint $table) {
            $table->dropColumn('otp_enable');
            $table->dropColumn('braintree_id');
            $table->dropColumn('wallet_enable');
            $table->dropColumn('braintree_enable');
        });
    }
}
