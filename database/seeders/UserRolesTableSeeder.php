<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([

            'name' => 'مدير',
            'extra' => 'مدير لدية جميع الصلاحيات',

            'purchase_orders_show' => true,
            'purchase_orders_add' => true,
            'purchase_orders_edit' => true,
            'purchase_orders_delete' => true,

            'purchase_order_comments_show' => true,
            'purchase_order_comments_add' => true,
            'purchase_order_comments_edit' => true,
            'purchase_order_comments_delete' => true,

            'money_transfers_show' => true,
            'money_transfers_add' => true,
            'money_transfers_edit' => true,
            'money_transfers_delete' => true,

            'trips_show' => true,
            'trips_add' => true,
            'trips_edit' => true,
            'trips_delete' => true,

            'shipping_invoices_show' => true,
            'shipping_invoices_add' => true,
            'shipping_invoices_edit' => true,
            'shipping_invoices_delete' => true,

            'shipment_comments_show' => true,
            'shipment_comments_add' => true,
            'shipment_comments_edit' => true,
            'shipment_comments_delete' => true,

            /* Start Customers */
            'customers_show' => true,
            'customers_add' => true,
            'customers_edit' => true,
            'customers_delete' => true,

            'clients_logins' => true,
            /* End Customers */

            /* Start Messages */
            'messages_show' => true,
            'messages_edit' => true,
            'messages_delete' => true,
            /* End Messages */

            /* Start Posts */
            'posts_show' => true,
            'posts_add' => true,
            'posts_edit' => true,
            'posts_delete' => true,

            'tags' => true,
            /* End Posts */

            /* Start Shipping settings */
            'addresses_show' => true,
            'addresses_add' => true,
            'addresses_edit' => true,

            'shipping_companies' => true,
            'receiving_places' => true,
            'item_types' => true,
            /* End Shipping settings */

            /* Start Users */
            'users' => true,
            'user_roles' => true,
            'users_logins' => true,
            /* Start Users */

            /* Start Settings */
            'branches' => true,
            'settings' => true,
            /* End Settings */

            /* Start Other */
            'faq' => true,
            'currency_types' => true,
            'countries' => true,
            'cities' => true,

            /* Backups */
            'backups_show' => true,
            'backups_add' => true,
            'backups_download' => true,
            'backups_delete' => true,
        ]);
    }
}
