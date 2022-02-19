<?php

if (!function_exists('generateFileName')) {
    function generateFileName($prefix = '', $extension = '')
    {
        return $prefix . microtime(true) . rand(1000, 999999999) . uniqid() . ($extension ? '.' . $extension : '');
    }
}

if (!function_exists('checkIfIdCorrect')) {
    function checkIfIdCorrect($id)
    {
        if (filter_var($id, FILTER_VALIDATE_INT, ["options" => ["min_range" => 1]]) === false) {
            abort(404);
        }
    }
}

if (!function_exists('authClient')) {
    function authClient()
    {
        return auth()->guard('client');
    }
}
if (!function_exists('get_client_property_if_logged_in')) {
    function get_client_property_if_logged_in($property)
    {
        return authClient()->check() ? authClient()->user()->$property : null;
    }
}

if (!function_exists('hasRole')) {
    function hasRole($permissions)
    {
        if (is_array($permissions)) {
            return auth()->user()->hasAnyRole($permissions);
        } else {
            return auth()->user()->hasRole($permissions);
        }
    }
}

if (!function_exists('getCurrency')) {
    function getCurrency($value, $currency = '$')
    {
        return is_null($value) ? '-' : "$value$currency";
    }
}

if (!function_exists('app_settings')) {
    function app_settings()
    {
        return App\Http\Helper\AppSettings::getInstance()->settings();
    }
}

if (!function_exists('get_customer_code_starts_with')) {
    function get_customer_code_starts_with()
    {
        return config('app.customer_code_starts_with');
    }
}

if (!function_exists('is_page_active')) {
    function is_page_active($page)
    {
        return Request::segment(1) == $page ? 'active' : '';
    }
}

if (!function_exists('get_url_for_notifications')) {

    function get_url_for_notifications($notification)
    {
        /* Remove the beginning and end of the link to get a type */
        $type = ltrim($notification->type, 'App\Notifications\\');
        $type = substr($type, 0, strrpos($type, '\\'));

        switch ($type) {

            case 'PurchaseOrders':
                return url('client/purchase-orders', $notification->data['id']);

            case 'PurchaseOrders\\Comments':
                return url("client/purchase-orders/{$notification->main_id}#{$notification->data['id']}");

            case 'MoneyTransfers':
                return url('client/money-transfers', $notification->data['id']);

            case 'ShippingAddresses':
                return url("client/addresses#{$notification->data['id']}");

            case 'Posts':
                return url('news', $notification->data['id']);

            case 'Customers':
                return url('client/index');

            case 'Shipments':
                return url('client/shipping-invoices', $notification->data['id']);

            case 'Shipments\\Comments':
                return url("client/shipping-invoices/{$notification->main_id}#{$notification->data['id']}");

            case 'Wallet':
            case 'Withdrawal':
                return url('client/wallet');

            case 'InternalTransfareMoney':
                return url('client/internalmoneytransfare');

            default:
                throw new Exception('Type dose not exist');
        }

    }

}

if (!function_exists('get_icon_for_notifications')) {

    function get_icon_for_notifications($notification)
    {
        /* Remove the beginning and end of the link to get a type */
        $type = ltrim($notification->type, 'App\Notifications\\');
        $type = substr($type, 0, strrpos($type, '\\'));

        switch ($type) {

            case 'PurchaseOrders':
            case 'PurchaseOrders\\Comments':
                return 'fa fa-shopping-cart';

            case 'MoneyTransfers':
                return 'fa fa-exchange-alt';

            case 'ShippingAddresses':
                return 'fas fa-map-marked-alt';

            case 'Posts':
                return 'fa fas fa-newspaper';

            case 'Customers':
                return 'fa fa-user';

            case 'Shipments':
            case 'Shipments\\Comments':
                return 'fa fa-cubes';

            case 'Wallet':
            case 'Withdrawal':
                return 'fas fa-wallet';

            default:
                throw new Exception('Type dose not exist');
        }

    }

}

if (!function_exists('file_size_human')) {

    function file_size_human($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
    //اضافة للخزينة الرئيسية
    // $cost -->-->--> (type = 1) for dolar and = 2 for denar and (cost) and (id=1) account
    function addtomainbankcompany($cost)
    {
       $table = 'App\Models\maincompbank';
       $account = $table::firstWhere('code',1);
       if($cost->type == 1)
       {
       $add['total_dolar'] = $account->total + $cost['cost'];
       $account->update($add);
       }
       if($cost['type'] == 2){
        $add['total_dener'] = $account->total + $cost['cost'];
        $account->update($add);
    }

    }
    //سحب من الخزينة الرئيسية
    // $cost -->-->--> type = 1 for dolar and = 2 for denar and cost and id=1 account
    function Minusfrommainbankcompany($cost)
    {
        $table = 'App\Models\maincompbank';
        $account = $table::firstWhere('code',1);
        if($cost->type == 1)
        {
        $add['total_dolar'] = $account->total - $cost['cost'];
        $account->update($add);
        }
        if($cost['type'] == 2){
         $add['total_dener'] = $account->total - $cost['cost'];
         $account->update($add);
     }

     function addtowallet($code,$type,$cost,$branche)
     {
        $table = 'App\Models\CustomerWallet';
     }
     function Minusfromwallet($code,$type,$cost,$branche)
     {
        $table = 'App\Models\CustomerWallet';

     }

    }
}

