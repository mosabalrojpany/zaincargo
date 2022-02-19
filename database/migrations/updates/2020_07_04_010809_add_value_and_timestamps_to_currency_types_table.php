<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValueAndTimestampsToCurrencyTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('currency_types', function (Blueprint $table) {
            $table->decimal('value', 12, 6);
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
        Schema::table('currency_types', function (Blueprint $table) {
            $table->dropColumn('value');
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
}
