<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerWallet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_wallet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('money_dolar_t', 8, 2);
            $table->decimal('money_denar_t', 8, 2);
            $table->decimal('money_dolar_b', 8, 2);
            $table->decimal('money_denar_b', 8, 2);
            $table->decimal('money_dolar_m', 8, 2);
            $table->decimal('money_denar_m', 8, 2);
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->boolean('state')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_wallet');
    }
}
