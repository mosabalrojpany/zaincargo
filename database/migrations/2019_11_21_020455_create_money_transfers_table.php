<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_transfers', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->integer('country_id')->unsigned();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');

            $table->string('recipient', 32);
            $table->string('phone', 24);
            $table->string('phone2', 24)->nullable();
            $table->string('account_number', 32)->nullable();
            $table->string('account_number2', 32)->nullable();
            $table->string('account_number3', 32)->nullable();
            $table->string('file')->nullable();
            $table->tinyInteger('recipient_type'); /* company or person */
            $table->tinyInteger('receiving_method'); /* cach or bank */

            $table->decimal('amount', 10, 3);
            $table->decimal('fee', 10, 3)->nullable();
            $table->decimal('total', 10, 3)->nullable();
            $table->boolean('fee_on_recipient');
            $table->integer('currency_type_id')->unsigned();
            $table->foreign('currency_type_id')->references('id')->on('currency_types');

            $table->tinyInteger('state');
            $table->text('extra')->nullable();
            $table->text('note')->nullable();
            $table->date('converted_at')->nullable();
            $table->date('received_at')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->integer('added_by')->unsigned()->nullable();
            $table->foreign('added_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('money_transfers');
    }
}
