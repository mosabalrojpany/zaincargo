<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Jobs\Notifications\ShippingAddresses\SendNewAddressNotification;
use App\Jobs\Notifications\ShippingAddresses\SendUpdateDataNotification;
use App\Jobs\Notifications\ShippingAddresses\SendUpdatePricesNotification;
use App\Models\Address;
use App\Models\AddressPrice;
use App\Models\City;
use App\Models\Country;
use DB;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Address::with('country', 'city', 'prices')->latest();

        /*  Start search    */
        if ($request->search) {

            $this->validate(request(), [
                'country' => 'nullable|integer',
                'city' => 'nullable|integer',
                'type' => 'nullable|integer|in:1,2',
                'state' => 'nullable|boolean',
                'fullname' => 'nullable|string|max:32',
                'note' => 'nullable|string|max:32',
                'extra' => 'nullable|string|max:32',
                'from' => 'nullable|date',
                'to' => 'nullable|date|after_or_equal:from',
            ]);

            if ($request->country) {
                $query->where('country_id', $request->country);
            }
            if ($request->city) {
                $query->where('city_id', $request->city);
            }
            if ($request->type) {
                $query->where('type', $request->type);
            }
            if (!is_null($request->state)) {
                $query->where('active', $request->state);
            }
            if ($request->fullname) {
                $query->where('fullname', 'Like', "%$request->fullname%");
            }
            if ($request->note) {
                $query->where('note', 'Like', "%$request->note%");
            }
            if ($request->extra) {
                $query->where('extra', 'Like', "%$request->extra%");
            }
            if ($request->from) {
                $query->whereDate('created_at', '>=', $request->from);
            }
            if ($request->to) {
                $query->whereDate('created_at', '<=', $request->to);
            }
        }
        /*  End search    */

        $addresses = $query->paginate(10);
        $addresses->appends($request->query());

        $countries = Country::select('id', 'name', 'logo')->get();
        $cities = City::select('id', 'name', 'country_id')->get();

        return view('CP.addresses', [
            'addresses' => $addresses,
            'countries' => $countries,
            'cities' => $cities,
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

        DB::transaction(function () use ($request) {

            $address = new Address();
            $this->setData($address, $request);

            if (!empty($request->prices)) {

                $prices = $request->prices;
                $n_prices = count($prices['from']);

                $queryPrices = array();

                for ($i = 0; $i < $n_prices; $i++) {
                    $queryPrices[] = [
                        'address_id' => $address->id,
                        'from' => $prices['from'][$i],
                        'to' => $prices['to'][$i],
                        'price' => $prices['price'][$i],
                        'description' => $prices['desc'][$i],
                    ];
                }

                AddressPrice::insert($queryPrices);
            }

            SendNewAddressNotification::dispatch($address);
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        checkIfIdCorrect($request->id);
        $this->validateData(true);
        DB::transaction(function () use ($request) {

            $address = Address::findOrfail($request->id);
            $this->setData($address, $request);

            if (!empty($request->prices)) {

                $prices = $request->prices;
                $added_prices = array_keys($prices['row_state'], 'added');
                $updated_prices = array_keys($prices['row_state'], 'updated');

                /*  Start add new prices    */
                if ($added_prices) {

                    $queryAdd = array();

                    foreach ($added_prices as $index) {
                        $queryAdd[] = [
                            'address_id' => $address->id,
                            'from' => $prices['from'][$index],
                            'to' => $prices['to'][$index],
                            'price' => $prices['price'][$index],
                            'description' => $prices['desc'][$index],
                        ];
                    }

                    AddressPrice::insert($queryAdd);
                }
                /*  End add new prices  */

                /*  Start update prices     */
                foreach ($updated_prices as $index) {
                    AddressPrice::where('id', $prices['id'][$index])->update([
                        'from' => $prices['from'][$index],
                        'to' => $prices['to'][$index],
                        'price' => $prices['price'][$index],
                        'description' => $prices['desc'][$index],
                    ]);
                }
                /*  End update prices   */
            }

            if ($request->deleted_prices) {
                AddressPrice::whereIn('id', $request->deleted_prices)->delete();
            }

            if ($address->wasChanged()) {
                SendUpdateDataNotification::dispatch($address);
            }

            if ($added_prices || $updated_prices || $request->deleted_prices) {
                SendUpdatePricesNotification::dispatch($address);
            }

        });

    }

    private function validateData(bool $isUpdate = false)
    {
        $this->validate(request(), [
            'name' => 'required|string|min:3|max:32|unique:addresses' . ($isUpdate ? ',name,' . request('id') : ''),
            'fullname' => 'required|string|min:3|max:32',
            'phone' => ['nullable', 'string', 'regex:/^([0-9\-\+]\s*){3,14}$/'],
            'phone2' => ['nullable', 'string', 'regex:/^([0-9\-\+]\s*){3,14}$/'],
            'phone3' => ['nullable', 'string', 'regex:/^([0-9\-\+]\s*){3,14}$/'],
            'address1' => 'nullable|string|min:3|max:64',
            'address2' => 'nullable|string|min:3|max:64',
            'country' => 'required|integer|exists:countries,id',
            'city' => 'required|integer|exists:cities,id,country_id,' . request('country'),
            'state' => 'nullable|string|min:3|max:32',
            'zip' => 'nullable|string|min:3|max:32',
            'active' => 'required|boolean',
            'type' => 'required|integer|between:1,2', // 1: Air freight  , 2: Sea freight
            'note' => 'nullable|string|max:150',
            'extra' => 'nullable|string|max:150',
            'prices.from.*' => 'required|numeric|min:0.001',
            'prices.to.*' => 'required|numeric|min:0.001|gte:prices.from.*',
            'prices.price.*' => 'required|numeric|min:0',
            'prices.desc.*' => 'required|string|min:3|max:32',
        ]);
    }

    private function setData($address, Request $request)
    {
        $address->name = $request->name;
        $address->fullname = $request->fullname;
        $address->phone = $request->phone;
        $address->phone2 = $request->phone2;
        $address->phone3 = $request->phone3;
        $address->address1 = $request->address1;
        $address->address2 = $request->address2;
        $address->country_id = $request->country;
        $address->city_id = $request->city;
        $address->state = $request->state;
        $address->zip = $request->zip;
        $address->active = $request->active;
        $address->type = $request->type;
        $address->note = $request->note;
        $address->extra = $request->extra;
        $address->save();
    }
}
