<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMacherttransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('macherttrans', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('merchant_id');
            $table->string('merchant_code');
            $table->unsignedInteger('merchant_name');
            $table->unsignedInteger('order_id');
            $table->string('note');
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
        Schema::dropIfExists('macherttrans');
    }
}
