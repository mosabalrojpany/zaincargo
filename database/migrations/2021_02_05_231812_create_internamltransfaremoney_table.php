<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternamltransfaremoneyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internamltransfaremoney', function (Blueprint $table) {
            $table->id();
            $table->string('from_customer');
            $table->string('to_customer');
            $table->unsignedInteger('from_customer_id');
            $table->unsignedInteger('to_customer_id');
            $table->unsignedInteger('from_branch');
            $table->unsignedInteger('to_branch');
            $table->decimal('price');
            $table->string('curancy_type');
            $table->unsignedInteger('state');
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
        Schema::dropIfExists('internamltransfaremoney');
    }
}
