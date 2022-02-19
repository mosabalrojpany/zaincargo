<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWallettransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallettransaction', function (Blueprint $table) {
            $table->id();
            $table->string('employe_name');
            $table->unsignedInteger('employe_id');
            $table->foreign('employe_id')->references('id')->on('users');
            $table->string('before');
            $table->string('after');
            $table->string('whatdo');
            $table->integer('prob_id')->unsigned();
            $table->text('note')->nullable();
            $table->boolean('type')->default(true);
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
        Schema::dropIfExists('wallettransaction');
    }
}
