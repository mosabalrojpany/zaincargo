<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::group(['namespace' => 'Main'], function () {

    Route::get('/', 'IndexController@index');

    Route::view('about', 'main.about');
    Route::view('terms', 'main.terms');

    Route::get('news', 'PostController@index');
    Route::get('news/{id}', 'PostController@show');

    Route::get('/faq', 'FrequentlyAskedQuestionController@index');

    Route::get('contact', 'ContactController@index');
    Route::post('contact', 'ContactController@store');

});

Route::group(['prefix' => 'cp/', 'namespace' => 'CP'], function () {

    /*  Start Guesst routes */
    Route::group(['middleware' => ['guest']], function () {

        Route::get('/login', 'LoginsController@showLogin');
        Route::post('/login', 'LoginsController@login');

    });
    /*  End Guesst routes */

/*  Start control panel */
    Route::group(['middleware' => ['auth', 'lastAccess']], function () {




        /* Start Trips */
        Route::get('/trips', 'TripController@index')->middleware('permission:trips_show');
        Route::get('/trips/create', 'TripController@create')->middleware('permission:trips_add');
        Route::get('/trips/{id}', 'TripController@show')->middleware('permission:trips_show');
        Route::get('/trips/edit/{id}', 'TripController@edit')->middleware('permission:trips_edit');
        Route::post('/trips', 'TripController@store')->middleware('permission:trips_add');
        Route::post('/trips/edit', 'TripController@update')->middleware('permission:trips_edit');
        Route::delete('/trips', 'TripController@destroy')->middleware('permission:trips_delete');
        /* End Trips */

        /* Start Shipping Invoices */
        Route::get('/shipping-invoices/create', 'ShippingInvoiceController@create')->middleware('permission:shipping_invoices_add');
        Route::get('/shipping-invoices/edit/{id}', 'ShippingInvoiceController@edit')->middleware('permission:shipping_invoices_edit');
        Route::post('/shipping-invoices', 'ShippingInvoiceController@store')->middleware('permission:shipping_invoices_add');
        Route::post('/shipping-invoices/edit', 'ShippingInvoiceController@update')->middleware('permission:shipping_invoices_edit');
        Route::delete('/shipping-invoices', 'ShippingInvoiceController@destroy')->middleware('permission:shipping_invoices_delete');
        Route::middleware('permission:shipping_invoices_show')->group(function () {
            Route::get('/shipping-invoices', 'ShippingInvoiceController@index');
            Route::get('/shipping-invoices/{id}', 'ShippingInvoiceController@show');
            Route::get('/shipping-invoices/print/mulitple', 'ShippingInvoiceController@printMultipleInvoices');
            Route::get('/shipping-invoices/print/{id}', 'ShippingInvoiceController@print');
            Route::get('/shipping-invoices/printlabel/{id}', 'ShippingInvoiceController@printlabel');
        });
        Route::get('/shipping-invoices/short/{address}', 'ShippingInvoiceController@getInvoicesByAddress')->middleware('permission:trips_add,trips_edit');
        /* End Shipping Invoices */

        /* Start Shipping Invoices Comments */
        Route::get('/shipment-comments', 'ShipmentCommentController@index')->middleware('permission:shipment_comments_show');
        Route::post('/shipment-comments', 'ShipmentCommentController@store')->middleware('permission:shipment_comments_add');
        Route::get('/shipment-comments/update/state/{id}', 'ShipmentCommentController@updateState')->middleware('permission:shipment_comments_edit');
        Route::post('/shipment-comments/edit', 'ShipmentCommentController@update')->middleware('permission:shipment_comments_edit');
        Route::delete('/shipment-comments', 'ShipmentCommentController@destroy')->middleware('permission:shipment_comments_delete');
        /* End Shipping Invoices Comments */

        /*  Start Messages */
        Route::get('/messages', 'MessageController@index')->middleware('permission:messages_show');
        Route::delete('/messages', 'MessageController@destroy')->middleware('permission:messages_delete');
        Route::get('/messages/update/state/{id}', 'MessageController@update')->middleware('permission:messages_edit');
        /*  End Messages */

        /*  Start Customers */
        Route::get('/customers', 'CustomerController@index')->middleware('permission:customers_show');
        Route::get('/customers/{id}', 'CustomerController@show')->middleware('permission:customers_show');
        Route::post('/customers', 'CustomerController@store')->middleware('permission:customers_add');
        Route::post('/customers/edit', 'CustomerController@update')->middleware('permission:customers_edit');
        Route::post('/customers/edit/password', 'CustomerController@updatePassword')->middleware('permission:customers_edit');
        Route::delete('/customers', 'CustomerController@destroy')->middleware('permission:customers_delete');

        Route::get('/clients-logins', 'ClientLoginController@index')->middleware('permission:clients_logins');

        /*  End Customers */



        /*  Start Posts */
        Route::get('/posts', 'PostController@index')->middleware('permission:posts_show');
        Route::get('/posts/create', 'PostController@create')->middleware('permission:posts_add');
        Route::get('/posts/{id}', 'PostController@show')->middleware('permission:posts_show');
        Route::get('/posts/edit/{id}', 'PostController@edit')->middleware('permission:posts_edit');
        Route::post('/posts', 'PostController@store')->middleware('permission:posts_add');
        Route::post('/posts/edit', 'PostController@update')->middleware('permission:posts_edit');

        Route::middleware('permission:tags')->group(function () {
            Route::get('/tags', 'TagsController@index');
            Route::post('/tags', 'TagsController@store');
            Route::post('/tags/edit', 'TagsController@update');
        });
        /*  End Posts */

        /* Start Shipping settings */
        Route::get('/addresses', 'AddressController@index')->middleware('permission:addresses_show');
        Route::post('/addresses', 'AddressController@store')->middleware('permission:addresses_add');
        Route::post('/addresses/edit', 'AddressController@update')->middleware('permission:addresses_edit');

        Route::middleware('permission:shipping_companies')->group(function () {
            Route::get('/shipping-companies', 'ShippingCompanyController@index');
            Route::post('/shipping-companies', 'ShippingCompanyController@store');
            Route::post('/shipping-companies/edit', 'ShippingCompanyController@update');
        });

        Route::middleware('permission:receiving_places')->group(function () {
            Route::get('/receiving-places', 'ReceivingPlaceController@index');
            Route::post('/receiving-places', 'ReceivingPlaceController@store');
            Route::post('/receiving-places/edit', 'ReceivingPlaceController@update');
        });

        Route::middleware('permission:item_types')->group(function () {
            Route::get('/item-types', 'ItemTypeController@index');
            Route::post('/item-types', 'ItemTypeController@store');
            Route::post('/item-types/edit', 'ItemTypeController@update');
        });
        /*  End Shipping settings */

        /* Start Users */
        Route::middleware('permission:users')->group(function () {
            Route::get('/users', 'UsersController@index');
            Route::post('/users', 'UsersController@store');
            Route::post('/users/edit', 'UsersController@update');
        });

        Route::post('/user/current/edit/password', 'UsersController@updatePassword');

        Route::middleware('permission:user_roles')->group(function () {
            Route::get('/user-roles', 'UserRoleController@index');
            Route::post('/user-roles', 'UserRoleController@store');
            Route::post('/user-roles/edit', 'UserRoleController@update');
        });

        Route::get('/logins', 'LoginsController@index')->middleware('permission:users_logins');
        /* End Users */


        Route::middleware('permission:branches')->group(function () {
            Route::get('/branches', 'BranchController@index');
            Route::post('/branches', 'BranchController@store');
            Route::post('/branches/edit', 'BranchController@update');
            Route::post('/branches/update/location', 'BranchController@updateLocation');
        });



        /* Start Settings */
        Route::middleware('permission:settings')->group(function () {
            Route::get('/settings', 'SettingController@show');
            Route::post('/settings', 'SettingController@update');
        });
        /* End Settings */

        /* Start Other */
        Route::middleware('permission:faq')->group(function () {
            Route::get('/faqs', 'FrequentlyAskedQuestionController@index');
            Route::get('/faqs/create', 'FrequentlyAskedQuestionController@create');
            Route::get('/faqs/edit/{id}', 'FrequentlyAskedQuestionController@edit');
            Route::post('/faqs', 'FrequentlyAskedQuestionController@store');
            Route::post('/faqs/edit', 'FrequentlyAskedQuestionController@update');
        });

        Route::middleware('permission:currency_types')->group(function () {
            Route::get('/currency-types', 'CurrencyTypeController@index');
            Route::post('/currency-types', 'CurrencyTypeController@store');
            Route::post('/currency-types/edit', 'CurrencyTypeController@update');
        });

        Route::middleware('permission:countries')->group(function () {
            Route::get('/countries', 'CountryController@index');
            Route::post('/countries', 'CountryController@store');
            Route::post('/countries/edit', 'CountryController@update');
        });

        Route::middleware('permission:cities')->group(function () {
            Route::get('/cities', 'CityController@index');
            Route::post('/cities', 'CityController@store');
            Route::post('/cities/edit', 'CityController@update');
        });
        /* End Other */


        Route::middleware('permission:faq,post_add,post_edit')->group(function () {
            /* any permission that use ckeditor  */
            Route::get('/laravel-filemanager', '\UniSharp\LaravelFilemanager\Controllers\LfmController@show');
            Route::post('/laravel-filemanager/upload', '\UniSharp\LaravelFilemanager\Controllers\UploadController@upload');
        });

        Route::get('/backups', 'BackUpController@index')->middleware('permission:backups_show');
        Route::post('/backups', 'BackUpController@store')->middleware('permission:backups_add');
        Route::get('/backups/{name}', 'BackUpController@download')->middleware('permission:backups_download');
        Route::delete('/backups', 'BackUpController@destroy')->middleware('permission:backups_delete');

        Route::redirect('/', 'cp/index');
        Route::get('/index', 'IndexController@indexCP');
        Route::post('/logout', 'LoginsController@logout')->name('logout');

    });
/*  End control panel */

});

Route::get('/storage/{folderOrFile}/{subFolderOrFile?}/{filename?}', function ($folderOrFile, $subFolderOrFile, $filename) {

    $path = storage_path("app/$folderOrFile") . (($subFolderOrFile) ? '/' . $subFolderOrFile : '') . (($filename) ? '/' . $filename : '');

    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);

    /*  Download file direct
    return response()->download($path,$filename);
     */

    /*  Show file on browser if it can show (like images , pdf ...)  */
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;

});
