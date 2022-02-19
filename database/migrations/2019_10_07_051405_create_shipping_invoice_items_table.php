<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_invoice_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('img');
            $table->integer('invoice_id')->unsigned();
            $table->foreign('invoice_id')->references('id')->on('shipping_invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_invoice_items');
    }
}
