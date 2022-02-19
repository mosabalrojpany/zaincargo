<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashdepositTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cashdeposit', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('wallet_id')->unsigned();
            $table->foreign('wallet_id')->references('id')->on('customer_wallet')->onDelete('cascade');
            $table->integer('type');
            $table->decimal('price', 8, 2);
            $table->integer('curance_type_id')->unsigned();
            $table->foreign('curance_type_id')->references('id')->on('currency_types');
            $table->text('note')->nullable();
            $table->integer('branches_id')->unsigned();
            $table->foreign('branches_id')->references('id')->on('branches')->onDelete('cascade');
            $table->string('employe_name');
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
        Schema::dropIfExists('cashdeposit');
    }
}
