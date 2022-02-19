<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('link');
            $table->string('color')->nullable();
            $table->string('desc');
            $table->integer('count');
            $table->decimal('price', 10, 3)->nullable();
            $table->decimal('tax', 10, 3)->nullable();
            $table->decimal('shipping', 10, 3)->nullable();
            $table->tinyInteger('state')->nullable();
            $table->string('note')->nullable();
            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_order_items');
    }
}
