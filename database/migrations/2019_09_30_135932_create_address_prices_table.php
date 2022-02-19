<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('from', 10, 3);
            $table->decimal('to', 10, 3);
            $table->decimal('price', 10, 3);
            $table->string('description'); // description
            $table->integer('address_id')->unsigned();
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->unique(['from', 'to', 'address_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address_prices');
    }
}
