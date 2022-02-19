<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title');
            $table->text('content');
            $table->string('img');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users'); 
            $table->boolean('active'); 
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
