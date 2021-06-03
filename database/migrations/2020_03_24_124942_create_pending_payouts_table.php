<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingPayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('pending_payouts') ) {

            Schema::create('pending_payouts', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('orderid')->unsigned();
                $table->integer('sellerid')->unsigned();
                $table->integer('paidby')->unsigned();
                $table->string('paid_in', 191);
                $table->float('subtotal', 10, 0);
                $table->float('tax', 10, 0);
                $table->float('shipping', 10, 0);
                $table->float('orderamount', 10, 0);
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
        Schema::dropIfExists('pending_payouts');
    }
}
