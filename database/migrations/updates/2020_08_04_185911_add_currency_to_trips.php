<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyToTrips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->integer('currency_type_id')->unsigned()->nullable();
            $table->foreign('currency_type_id')->references('id')->on('currency_types')->onDelete('cascade');
            $table->decimal('exchange_rate', 12, 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn('currency_type_id');
            $table->dropColumn('exchange_rate');
        });
    }
}
