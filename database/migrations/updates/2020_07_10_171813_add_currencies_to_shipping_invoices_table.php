<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrenciesToShippingInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_invoices', function (Blueprint $table) {
            $table->integer('currency_type_id')->unsigned();
            $table->foreign('currency_type_id')->references('id')->on('currency_types')->onDelete('cascade');
            $table->decimal('exchange_rate', 12, 6)->nullable();
            $table->decimal('paid_up', 10, 3)->nullable();
            $table->decimal('paid_exchange_rate', 12, 6)->nullable();
            $table->integer('payment_currency_type_id')->unsigned()->nullable();
            $table->foreign('payment_currency_type_id')->references('id')->on('currency_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_invoices', function (Blueprint $table) {
            $table->dropColumn('currency_type_id');
            $table->dropColumn('exchange_rate');
            $table->dropColumn('paid_up');
            $table->dropColumn('paid_exchange_rate');
            $table->dropColumn('payment_currency_type_id');
            //
        });
    }
}
