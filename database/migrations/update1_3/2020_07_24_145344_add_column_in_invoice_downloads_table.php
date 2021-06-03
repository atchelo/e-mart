<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInInvoiceDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoice_downloads', function (Blueprint $table) {

            if (!Schema::hasColumn('invoice_downloads', 'igst')){
                $table->double('igst', 8, 2)->nullable();
            }

            if (!Schema::hasColumn('invoice_downloads', 'sgst')){
                $table->double('sgst', 8, 2)->nullable();
            }

            if (!Schema::hasColumn('invoice_downloads', 'cgst')){
                $table->double('cgst', 8, 2)->nullable();
            }

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoice_downloads', function (Blueprint $table) {
            //
        });
    }
}
