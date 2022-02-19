<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique()->nullable();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('address');
            $table->string('img')->nullable();
            $table->string('verification_file');
            $table->string('password');
            $table->integer('receive_in')->unsigned();
            $table->foreign('receive_in')->references('id')->on('receiving_places');
            $table->tinyInteger('state')->default(1); // 1 : new  , 2: disable , 3: active
            $table->text('extra')->nullable();
            $table->rememberToken();
            $table->timestamp('last_access')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('activated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
