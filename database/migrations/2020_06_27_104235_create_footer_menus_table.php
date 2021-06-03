<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFooterMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('footer_menus')){

            Schema::create('footer_menus', function (Blueprint $table) {

                $table->id();
                $table->string('title');
                $table->string('link_by');
                $table->string('position')->nullable();
                $table->string('widget_postion');
                $table->integer('page_id')->unsigned()->nullable();
                $table->string('url')->nullable();
                $table->integer('status')->unsigned()->default(1);
                
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
        Schema::dropIfExists('footer_menus');
    }
}