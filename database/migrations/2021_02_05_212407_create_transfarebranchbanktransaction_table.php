<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfarebranchbanktransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfarebranchbanktransaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employe_id');
            $table->string('employe_name');
            $table->unsignedInteger('branche_id');
            $table->decimal('price',8,2);
            $table->string('note');
            $table->string('curancy_type');
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
        Schema::dropIfExists('transfarebranchbanktransaction');
    }
}
