<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = UserRole::orderBy('name')->get();

        return view('CP.user_roles', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateData();

        $roles = new UserRole();
        $this->setData($roles);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|min:1',
        ]);
        $this->validateData(true);

        $roles = UserRole::findOrfail($request->id);
        $this->setData($roles);
    }

    private function validateData($update = false)
    {
        $this->validate(request(), [
            'name' => 'required|min:3|max:32|unique:user_roles' . ($update ? ',name,' . request('id') : ''),
            'extra' => 'nullable|max:150',

            'permissions' => 'required|array|min:1',
            'permissions.*' => 'required|boolean',
        ]);
    }

    private function setData($role)
    {
        $request = request();

        $role->name = $request->name;
        $role->extra = $request->extra;

        /* Start purchase orders */
        $role->purchase_orders_show = $request->input('permissions.purchase_orders_show', false);
        $role->purchase_orders_add = $request->input('permissions.purchase_orders_add', false);
        $role->purchase_orders_edit = $request->input('permissions.purchase_orders_edit', false);
        $role->purchase_orders_delete = $request->input('permissions.purchase_orders_delete', false);

        /* Start purchase orders comments */
        $role->purchase_order_comments_show = $request->input('permissions.purchase_order_comments_show', false);
        $role->purchase_order_comments_add = $request->input('permissions.purchase_order_comments_add', false);
        $role->purchase_order_comments_edit = $request->input('permissions.purchase_order_comments_edit', false);
        $role->purchase_order_comments_delete = $request->input('permissions.purchase_order_comments_delete', false);
        /* End purchase orders comments */

        /* End purchase orders */

        $role->money_transfers_show = $request->input('permissions.money_transfers_show', false);
        $role->money_transfers_add = $request->input('permissions.money_transfers_add', false);
        $role->money_transfers_edit = $request->input('permissions.money_transfers_edit', false);
        $role->money_transfers_delete = $request->input('permissions.money_transfers_delete', false);

        $role->trips_show = $request->input('permissions.trips_show', false);
        $role->trips_add = $request->input('permissions.trips_add', false);
        $role->trips_edit = $request->input('permissions.trips_edit', false);
        $role->trips_delete = $request->input('permissions.trips_delete', false);

        $role->shipping_invoices_show = $request->input('permissions.shipping_invoices_show', false);
        $role->shipping_invoices_add = $request->input('permissions.shipping_invoices_add', false);
        $role->shipping_invoices_edit = $request->input('permissions.shipping_invoices_edit', false);
        $role->shipping_invoices_delete = $request->input('permissions.shipping_invoices_delete', false);

        $role->shipment_comments_show = $request->input('permissions.shipment_comments_show', false);
        $role->shipment_comments_add = $request->input('permissions.shipment_comments_add', false);
        $role->shipment_comments_edit = $request->input('permissions.shipment_comments_edit', false);
        $role->shipment_comments_delete = $request->input('permissions.shipment_comments_delete', false);

        /* Start Customers */
        $role->customers_show = $request->input('permissions.customers_show', false);
        $role->customers_add = $request->input('permissions.customers_add', false);
        $role->customers_edit = $request->input('permissions.customers_edit', false);
        $role->customers_delete = $request->input('permissions.customers_delete', false);

        $role->clients_logins = $request->input('permissions.clients_logins', false);
        /* End Customers */

        /* Start Messages */
        $role->messages_show = $request->input('permissions.messages_show', false);
        $role->messages_edit = $request->input('permissions.messages_edit', false);
        $role->messages_delete = $request->input('permissions.messages_delete', false);
        /* End Messages */

        /* Start Posts */
        $role->posts_show = $request->input('permissions.posts_show', false);
        $role->posts_add = $request->input('permissions.posts_add', false);
        $role->posts_edit = $request->input('permissions.posts_edit', false);
        $role->posts_delete = $request->input('permissions.posts_delete', false);

        $role->tags = $request->input('permissions.tags', false);
        /* End Posts */

        /* Start Shipping settings */
        $role->addresses_show = $request->input('permissions.addresses_show', false);
        $role->addresses_add = $request->input('permissions.addresses_add', false);
        $role->addresses_edit = $request->input('permissions.addresses_edit', false);

        $role->shipping_companies = $request->input('permissions.shipping_companies', false);
        $role->receiving_places = $request->input('permissions.receiving_places', false);
        $role->item_types = $request->input('permissions.item_types', false);
        /* End Shipping settings */

        /* Start Users */
        $role->users = $request->input('permissions.users', false);
        $role->user_roles = $request->input('permissions.user_roles', false);
        $role->users_logins = $request->input('permissions.users_logins', false);
        /* End Users */

        /* Start Settings */
        $role->branches = $request->input('permissions.branches', false);
        $role->settings = $request->input('permissions.settings', false);
        /* End Settings */

        /* Start Other */
        $role->faq = $request->input('permissions.faq', false);
        $role->currency_types = $request->input('permissions.currency_types', false);
        $role->countries = $request->input('permissions.countries', false);
        $role->cities = $request->input('permissions.cities', false);
        /* End Other */

        /* Start wallet */
        $role->user_wallet_index = $request->input('permissions.user_wallet_index', false);
        $role->user_wallet_show = $request->input('permissions.user_wallet_show', false);
        $role->user_wallet_add = $request->input('permissions.user_wallet_add', false);
        $role->user_wallet_statement = $request->input('permissions.user_wallet_statement', false);
        /* End wallet */

        /* Start wallet */
        $role->user_wallet_depoprint = $request->input('permissions.user_wallet_depoprint', false);
        $role->user_wallet_edit = $request->input('permissions.user_wallet_edit', false);
        $role->user_wallet_delete = $request->input('permissions.user_wallet_delete', false);
        $role->user_wallet_editdelet = $request->input('permissions.user_wallet_editdelet', false);
        /* End wallet */

        /* Start wallet */
        $role->user_wallet_alldepo = $request->input('permissions.user_wallet_alldepo', false);
        $role->user_wallet_allwather = $request->input('permissions.user_wallet_allwather', false);
        /* End wallet */

        /* Start backups */
        $role->backups_show = $request->input('permissions.backups_show', false);
        $role->backups_add = $request->input('permissions.backups_add', false);
        $role->backups_download = $request->input('permissions.backups_download', false);
        $role->backups_delete = $request->input('permissions.backups_delete', false);
        /* End backups */

        // احالة طلبات الشراء للتجار
        $role->merchant = $request->input('permissions.merchant', false);
        $role->merchant_from_customer = $request->input('permissions.merchant_from_customer', false);
        $role->merchanttransaction = $request->input('permissions.merchanttransaction', false);
        $role->merchanttrnsactionadmin = $request->input('permissions.merchanttrnsactionadmin', false);
         // احالة طلبات الشراء للتجار
        // بنك الفروع للحوالات الداخلية
        $role->internal_transfaremoney_bank_show = $request->input('permissions.internal_transfaremoney_bank_show', false);
        $role->internal_transfaremoney_bank_depo = $request->input('permissions.internal_transfaremoney_bank_depo', false);
        $role->internal_transfaremoney_bank_wather = $request->input('permissions.internal_transfaremoney_bank_wather', false);
        $role->internal_transfaremoney_bank_watherearning = $request->input('permissions.internal_transfaremoney_bank_watherearning', false);
         //بنك الفروع للحوالات الداخلية
        // الحوالات المالية الداخلية
        $role->transfaremoney_show = $request->input('permissions.transfaremoney_show', false);
        $role->transfaremoney_doneordel = $request->input('permissions.transfaremoney_doneordel', false);
         //الحوالات المالية الداخلية
        // حركة خزينة الحوالات الداخلية
        $role->transfaremoneybank_transaction = $request->input('permissions.transfaremoneybank_transaction', false);
        //حركة خزينة الحوالات الداخلية
        // تخليص فواتير الشراء للتجار
        $role->marchent_invoice_index = $request->input('permissions.marchent_invoice_index', false);
        $role->marchent_invoice_show = $request->input('permissions.marchent_invoice_show', false);
        $role->marchent_invoice_print = $request->input('permissions.marchent_invoice_print', false);
        $role->marchent_invoice_add = $request->input('permissions.marchent_invoice_add', false);
        //تخليص فواتير الشراء للتجار
        $role->save();
    }
}
