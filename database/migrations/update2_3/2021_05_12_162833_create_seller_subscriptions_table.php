<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('seller_subscriptions')){
            Schema::create('seller_subscriptions', function (Blueprint $table) {
                $table->id();
                $table->integer('plan_id')->unsigned();
                $table->index('plan_id');
                $table->integer('user_id')->unsigned();
                $table->string('txn_id');
                $table->string('method');
                $table->timestamp('start_date');
                $table->timestamp('end_date');
                $table->double('original_amount');
                $table->double('paid_amount');
                $table->string('paid_currency');
                $table->integer('status')->unsigned()->default(1);
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
        Schema::dropIfExists('seller_subscriptions');
    }
}
