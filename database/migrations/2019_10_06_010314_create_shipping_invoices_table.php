<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_invoices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tracking_number')->unique();
            $table->string('shipment_code');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->integer('trip_id')->unsigned()->nullable();
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('set null');
            $table->integer('address_id')->unsigned();
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->integer('receive_in')->unsigned();
            $table->foreign('receive_in')->references('id')->on('receiving_places');

            $table->decimal('length', 10, 1); // Centimeter
            $table->decimal('width', 10, 1); // Centimeter
            $table->decimal('height', 10, 1); // Centimeter
            $table->decimal('volumetric_weight', 10, 3); // Kilogram
            $table->decimal('cubic_meter', 10, 2); // Meter^3
            $table->decimal('weight', 10, 3); // Kilogram

            $table->decimal('cost', 10, 3);
            $table->decimal('additional_cost', 10, 3);
            $table->decimal('Insurance', 10, 3);//التامين
            $table->decimal('total_cost', 10, 3);

            $table->text('extra')->nullable();
            $table->text('note')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->date('received_at')->nullable();
            $table->date('arrived_at')->nullable();
            $table->integer('added_by')->unsigned();
            $table->foreign('added_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_invoices');
    }
}
