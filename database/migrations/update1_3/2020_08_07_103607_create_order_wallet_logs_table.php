<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderWalletLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('order_wallet_logs')){
            Schema::create('order_wallet_logs', function (Blueprint $table) {
                $table->increments('id');
                $table->string('wallet_txn_id');
                $table->longText('note')->nullable();
                $table->string('type');
                $table->double('amount')->default(0.00);;
                $table->double('balance')->default(0.00);
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
        Schema::dropIfExists('order_wallet_logs');
    }
}
