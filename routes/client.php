<?php

/*
|--------------------------------------------------------------------------
| Web Client Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/*  Start Guesst routes */
Route::middleware(['guest.client'])->group(function () {

    Route::post('/login', 'LoginController@login');

    Route::get('/register', 'RegisterController@create');
    Route::post('/register','RegisterController@store');

});
/*  End Guesst routes */

/*  Start Guesst routes */
Route::middleware(['client', 'lastAccessClient'])->group(function () {

    Route::get('/logout', 'LoginController@logout');
    Route::post('/logout', 'LoginController@logout');

    Route::get('/index', 'CustomerController@index');
    Route::post('/profile/update', 'CustomerController@update');

    Route::get('/shipping-invoices', 'ShippingInvoiceController@index');
    Route::get('/shipping-invoices/{id}', 'ShippingInvoiceController@show');
    Route::post('/shipping-invoices/Insurance', 'ShippingInvoiceController@Insuranceupdate')->name('shipping.Insurance');


    /* Start Shipping Invoices Comments */
    Route::post('/shipment-comments', 'ShipmentCommentController@store');
    Route::post('/shipment-comments/edit', 'ShipmentCommentController@update');
    /* End Shipping Invoices Comments */


    Route::get('addresses', 'AddressController@index');

    Route::get('notifications', 'NotificationController@index');
    Route::post('notifications/mark-all-as-read', 'NotificationController@markAllAsRead');





});
