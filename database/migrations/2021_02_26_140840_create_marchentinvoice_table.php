<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarchentinvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marchentinvoice', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('marchent_id');
            $table->unsignedInteger('employe_id');
            $table->string('employe_name');
            $table->decimal('price_dener');
            $table->decimal('price_dolar');
            $table->decimal('number_of_invoice');
            $table->decimal('price');
            $table->boolean('state');
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
        Schema::dropIfExists('marchentinvoice');
    }
}
