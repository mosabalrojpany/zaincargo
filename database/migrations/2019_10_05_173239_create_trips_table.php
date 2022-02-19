<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->string('trip_number')->unique();
            $table->string('tracking_number')->unique();
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('shipping_companies');
            $table->integer('address_id')->unsigned();
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->tinyInteger('state');
            $table->string('state_desc')->nullable();
            $table->string('weight');
            $table->decimal('cost', 10, 3);
            $table->string('extra')->nullable();
            $table->date('exit_at');
            $table->date('arrived_at')->nullable();
            $table->date('estimated_arrive_at')->nullable();
            $table->timestamp('created_at')->userCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
