<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfarebranchbankTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfarebranchbank', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('branche_id');
            $table->decimal('cost_dener',8,3);
            $table->decimal('cost_dolar',8,3);
            $table->decimal('erning_denar',8,3);
            $table->decimal('erning_dolar',8,3);
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
        Schema::dropIfExists('transfarebranchbank');
    }
}
