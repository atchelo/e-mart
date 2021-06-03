<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('seller_plans')){
            Schema::create('seller_plans', function (Blueprint $table) {
                $table->id();
                $table->char('unique_id',36);
                $table->string('name');
                $table->double('price');
                $table->longText('detail');
                $table->integer('validity')->unsigned();
                $table->string('period');
                $table->integer('product_create')->unsigned();
                $table->integer('csv_product')->unsigned()->default(0);
                $table->integer('status')->unsigned()->default(0);
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
        Schema::dropIfExists('seller_plans');
    }
}
