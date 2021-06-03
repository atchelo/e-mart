<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TermsSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('terms_settings'))
        {
            Schema::create('terms_settings', function (Blueprint $table) {
                $table->increments('id');
                $table->string('key');
                $table->string('title');
                $table->longText('description');
                $table->timestamps();
            });

            \DB::table('terms_settings')->insert([
                'id' => 1,
                'key' => 'user-register-term',
                'title' => 'User Agreement',
                'description' => 'Some agreement text here...'
            ]);

            \DB::table('terms_settings')->insert([
                'id' => 2,
                'key' => 'seller-register-term',
                'title' => 'Seller Agreement',
                'description' => 'Some agreement text here...'
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
