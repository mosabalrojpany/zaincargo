<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrenciesDiscountAndPaymentDayToPurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->decimal('discount', 10, 3)->nullable();
            $table->integer('currency_type_id')->unsigned()->nullable();
            $table->foreign('currency_type_id')->references('id')->on('currency_types')->onDelete('cascade');
            $table->decimal('paid_up', 10, 3)->nullable();
            $table->decimal('paid_exchange_rate', 12, 6)->nullable();
            $table->integer('payment_currency_type_id')->unsigned()->nullable();
            $table->foreign('payment_currency_type_id')->references('id')->on('currency_types')->onDelete('cascade');
            $table->date('paid_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->dropColumn([
                'discount',
                'currency_type_id',
                'paid_up',
                'paid_exchange_rate',
                'payment_currency_type_id',
                'paid_at',
            ]);
        });
    }
}
