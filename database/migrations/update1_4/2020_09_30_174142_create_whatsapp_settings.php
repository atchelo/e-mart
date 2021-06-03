<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatsappSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if(!Schema::hasTable('whatsapp_settings')){
            Schema::create('whatsapp_settings', function (Blueprint $table) {
                $table->id();
                $table->string('phone_no');
                $table->string('position');
                $table->string('size');
                $table->string('headerTitle');
                $table->string('popupMessage');
                $table->string('headerColor')->default('#128C7E');
                $table->string('status')->default('1');
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
        Schema::dropIfExists('whatsapp_settings');
    }
}
