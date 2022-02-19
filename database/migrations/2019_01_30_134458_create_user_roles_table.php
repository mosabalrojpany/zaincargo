<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name')->unique();
            $table->string('extra')->nullable();

            $table->boolean('purchase_orders_show');
            $table->boolean('purchase_orders_add');
            $table->boolean('purchase_orders_edit');
            $table->boolean('purchase_orders_delete');

            $table->boolean('money_transfers_show');
            $table->boolean('money_transfers_add');
            $table->boolean('money_transfers_edit');
            $table->boolean('money_transfers_delete');

            $table->boolean('trips_show');
            $table->boolean('trips_add');
            $table->boolean('trips_edit');
            $table->boolean('trips_delete');

            $table->boolean('shipping_invoices_show');
            $table->boolean('shipping_invoices_add');
            $table->boolean('shipping_invoices_edit');
            $table->boolean('shipping_invoices_delete');

            /* Start Customers */
            $table->boolean('customers_show');
            $table->boolean('customers_add');
            $table->boolean('customers_edit');
            $table->boolean('customers_delete');

            $table->boolean('clients_logins');
            /* End Customers */

            /* Start Messages */
            $table->boolean('messages_show');
            $table->boolean('messages_edit');
            $table->boolean('messages_delete');
            /* End Messages */

            /* Start Posts */
            $table->boolean('posts_show');
            $table->boolean('posts_add');
            $table->boolean('posts_edit');
            $table->boolean('posts_delete');

            $table->boolean('tags');
            /* End Posts */

            /* Start Shipping settings */
            $table->boolean('addresses_show');
            $table->boolean('addresses_add');
            $table->boolean('addresses_edit');

            $table->boolean('shipping_companies');
            $table->boolean('receiving_places');
            $table->boolean('item_types');
            /* End Shipping settings */

            /* Start Users */
            $table->boolean('users');
            $table->boolean('user_roles');
            $table->boolean('users_logins');
            /* Start Users */

            /* Start Settings */
            $table->boolean('branches');
            $table->boolean('settings');
            /* End Settings */

            /* Start Other */
            $table->boolean('faq');
            $table->boolean('currency_types');
            $table->boolean('countries');
            $table->boolean('cities');
            /* Start Other */
            /* Start Other */
            $table->boolean('merchant');
            $table->boolean('merchant_from_customer');
            $table->boolean('merchanttrnsactionadmin');
            $table->boolean('merchanttransaction');
            /* Start Other */
            /* Start Other */
            $table->boolean('internal_transfaremoney_bank_show');
            $table->boolean('internal_transfaremoney_bank_depo');
            $table->boolean('internal_transfaremoney_bank_wather');
            $table->boolean('internal_transfaremoney_bank_watherearning');
            /* Start Other */
            /* Start Other */
            $table->boolean('transfaremoney_show');
            $table->boolean('transfaremoney_doneordel');
            $table->boolean('transfaremoneybank_transaction');
            /* Start Other */
            /* Start Other */
            $table->boolean('marchent_invoice_index');
            $table->boolean('marchent_invoice_show');
            $table->boolean('marchent_invoice_add');
            $table->boolean('marchent_invoice_print');
            /* Start Other */

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
