<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesBank extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches_bank', function (Blueprint $table) {
            $table->id();
            $table->integer('branche_id')->unsigned();
            $table->foreign('branche_id')->references('id')->on('branches')->onDelete('cascade');
            $table->decimal('Customer_balance_denar', 8, 2);
            $table->decimal('Customer_balance_dolar', 8, 2);
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
        Schema::dropIfExists('branches_bank');
    }
}
