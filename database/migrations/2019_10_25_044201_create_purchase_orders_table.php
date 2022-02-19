<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->decimal('tax', 10, 3)->nullable();
            $table->decimal('shipping', 10, 3)->nullable();
            $table->decimal('fee', 10, 3)->nullable();
            $table->decimal('exchange_rate', 10, 3)->nullable();
            $table->decimal('total_cost', 10, 3)->nullable();
            $table->tinyInteger('state');
            $table->text('extra')->nullable();
            $table->text('note')->nullable();
            $table->date('ordered_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->integer('added_by')->unsigned()->nullable();
            $table->foreign('added_by')->references('id')->on('users');
            $table->integer('merchant_id')->unsigned()->nullable();
            $table->integer('merchant_state')->unsigned()->nullable();
            $table->string('merchant_note');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('marchent_invoice_id')->references('id')->on('marchentinvoice');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
}
