<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('products')){

            Schema::table('products', function (Blueprint $table) {

                if (!Schema::hasColumn('products', 'video_preview')){
                    $table->longText('video_preview')->nullable();
                }

                if (!Schema::hasColumn('products', 'video_thumbnail')){
                    $table->string('video_thumbnail')->nullable();
                }
                
            });
            
        }

        if(Schema::hasTable('genrals')){

            Schema::table('genrals', function (Blueprint $table) {

                if (!Schema::hasColumn('genrals', 'email_verify_enable')){
                    $table->integer('email_verify_enable')->unsigned()->default(0);
                }
                
            });
            
        }

        if(Schema::hasTable('configs')){

            Schema::table('configs', function (Blueprint $table) {

                if (!Schema::hasColumn('configs', 'iyzico_enable')){
                    $table->integer('iyzico_enable')->unsigned()->default(0);
                }

                if (!Schema::hasColumn('configs', 'sslcommerze_enable')){
                    $table->integer('sslcommerze_enable')->unsigned()->default(0);
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
        // No Code
    }
}
