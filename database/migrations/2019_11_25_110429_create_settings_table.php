<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('email');
            $table->string('phone');
            $table->string('phone2')->nullable();
            $table->string('address');
            $table->string('city');
            $table->decimal('longitude', 12, 9);
            $table->decimal('latitude', 12, 9);
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->text('desc');
            $table->text('keywords');
            $table->boolean('active')->default(true);
            $table->string('maintenance_msg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
