<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Notification;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $addresses = Address::with('country', 'city', 'prices:id,description,address_id')->active()->orderBy('country_id')->get();

        Notification::currentClient()->shippingAddresses()->updateAsRead();

        return view('Client.addresses', [
            'addresses' => $addresses,
        ]);
    }

}
