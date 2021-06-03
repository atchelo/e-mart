<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePWASettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_w_a_settings', function (Blueprint $table) {

            $table->id();
            $table->string('icon_48');
            $table->string('icon_72');
            $table->string('icon_96');
            $table->string('icon_128');
            $table->string('icon_144');
            $table->string('icon_192');
            $table->string('icon_256');
            $table->string('icon_512');

            $table->string('splash_640');
            $table->string('splash_750');

            $table->string('splash_828');
            $table->string('splash_1125');
            $table->string('splash_1242');

            $table->string('splash_1536');
            $table->string('splash_1668');
            $table->string('splash_2338');
            $table->string('splash_2048');

            $table->string('shorticon_1');
            $table->string('shorticon_2');
            $table->string('shorticon_3');



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_w_a_settings');
    }
}
