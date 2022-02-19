<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Jobs\Notifications\Shipments\SendArrivedNotification;
use App\Jobs\Notifications\Shipments\SendOnTheWayNotification;
use App\Models\Address;
use App\Models\CurrencyType;
use App\Models\ShippingCompany;
use App\Models\ShippingInvoice;
use App\Models\Trip;
use App\Rules\TripInvoices;
use Illuminate\Http\Request;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Trip::with('company:id,name');

        if ($request->search) {
            $this->validate($request, [
                'trip_number' => 'nullable|string|max:32',
                'tracking_number' => 'nullable|string|max:32',
                'state' => 'nullable|integer|min:1',
                'address' => 'nullable|integer|min:1',
                'company' => 'nullable|integer|min:1',
            ]);
            if ($request->state) {
                $query->where('state', $request->state);
            }
            if ($request->trip_number) {
                $query->where('trip_number', 'Like', "%$request->trip_number%");
            }
            if ($request->tracking_number) {
                $query->where('tracking_number', 'Like', "%$request->tracking_number%");
            }
            if ($request->address) {
                $query->where('address_id', $request->address);
            }
            if ($request->company) {
                $query->where('company_id', $request->company);
            }
        }

        $trips = $query->paginate(25);
        $trips->appends($request->query());

        $addresses = Address::select('id', 'name')->get();
        $companies = ShippingCompany::select('id', 'name')->get();

        return view('CP.trips.index', [
            'trips' => $trips,
            'addresses' => $addresses,
            'companies' => $companies,
            'status' => $this->getStatus(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = ShippingCompany::select('id', 'name')->active()->orderBy('name')->get();
        $addresses = Address::select('id', 'name')->active()->orderBy('name')->get();
        $currencies = CurrencyType::select('id', 'name', 'value')->active()->orderBy('name')->get();

        return view('CP.trips.create', [
            'companies' => $companies,
            'addresses' => $addresses,
            'currencies' => $currencies,
            'status' => $this->getStatus(),
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
        $trip = new Trip();
        $this->setData($trip);
        ShippingInvoice::where('address_id', $trip->address_id)->whereNull('trip_id')->whereNull('received_at')->whereIn('id', $request->invoices)
            ->update(['trip_id' => $trip->id]);

        return response()->json([
            'redirectTo' => url('cp/trips', $trip->id),
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        checkIfIdCorrect($id);
        $trip = Trip::with([
            'invoices' => function ($query) {
                $query->orderBy('receive_in')->orderBy('received_at')->orderBy('id');
            },
            'invoices.customer:id,code',
            'invoices.receivingPlace:id,name',
            'invoices.currency:id,name,sign',
            'invoices.paidCurrency:id,name,sign',
        ])->findOrfail($id);

        foreach ($trip->invoices as $invoice) {
            $invoice->trip = $trip; /* link trip to invoices to get state instead of load it from database */
        }

        $trip->total_cost = $trip->invoices->sum(function ($shipment) {return $shipment['cost'] * $shipment['exchange_rate'];});
        $trip->total_additional_cost = $trip->invoices->sum(function ($shipment) {return $shipment['additional_cost'] * $shipment['exchange_rate'];});
        $trip->total_paid = $trip->invoices->sum(function ($shipment) {return $shipment['paid_up'] * $shipment['paid_exchange_rate'];});

        $receive_in = $trip->invoices->unique('receive_in')->pluck('receive_in'); /* get all receive_in places in this trip */
        $shipments = $trip->invoices->groupBy('receive_in'); /* get shipments grouped by receive_in places */

        $cost = $shipments->map(function ($row) { /* get total cost by main currency for every receive_in place */
            return $row->sum(function ($shipment) {
                return $shipment['total_cost'] * $shipment['exchange_rate'];
            });
        });

        $paid = $shipments->map(function ($row) { /* get total paid up by main currency for every receive_in place */
            return $row->sum(function ($shipment) {
                return $shipment['paid_up'] * $shipment['paid_exchange_rate'];
            });
        });

        $total_cost_by_currencies = $trip->invoices->where('currency_type_id', '!=', null)->groupBy('currency_type_id')->map(function ($row) {
            return [
                'count' => $row->count(),
                'amount' => $row->sum('total_cost'),
                'currency' => $row[0]->currency->name,
            ];
        });

        $total_paid_by_currencies = $trip->invoices->where('payment_currency_type_id', '!=', null)->groupBy('payment_currency_type_id')->map(function ($row) {
            return [
                'count' => $row->count(),
                'amount' => $row->sum('paid_up'),
                'currency' => $row[0]->paidCurrency->name,
            ];
        });

        $paid_by_currencies = $shipments->map(function ($row) { /* get total paid grouped by currency for every receive_in places  */
            return $row->where('payment_currency_type_id', '!=', null)->groupBy('payment_currency_type_id')->map(function ($row) {
                return [
                    'count' => $row->count(),
                    'amount' => $row->sum('paid_up'),
                    'currency' => $row[0]->paidCurrency->name,
                ];
            });
        });

        $cost_by_currencies = $shipments->map(function ($row) { /* get total cost grouped by currency for every receive_in places  */
            return $row->where('currency_type_id', '!=', null)->groupBy('currency_type_id')->map(function ($row) {
                return [
                    'count' => $row->count(),
                    'amount' => $row->sum('total_cost'),
                    'currency' => $row[0]->currency->name,
                ];
            });
        });

        $data = new \stdclass;
        $data->shipments = $shipments;
        $data->paid = $paid;
        $data->cost = $cost;
        $data->total_cost_by_currencies = $total_cost_by_currencies;
        $data->total_paid_by_currencies = $total_paid_by_currencies;
        $data->paid_by_currencies = $paid_by_currencies;
        $data->cost_by_currencies = $cost_by_currencies;
        $data->receive_in = $receive_in;

        return view('CP.trips.show', [
            'trip' => $trip,
            'data' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        checkIfIdCorrect($id);
        $trip = Trip::findOrfail($id)->withInvoices();
        $invoices = ShippingInvoice::getInvoicesForTrips($trip->address_id)->whereNull('received_at')->get();
        $companies = ShippingCompany::select('id', 'name')->activeOrId($trip->company_id)->orderBy('name')->get();
        $addresses = Address::select('id', 'name')->activeOrId($trip->address_id)->orderBy('name')->get();
        $currencies = CurrencyType::select('id', 'name', 'value')->activeOrId($trip->currency_type_id)->orderBy('name')->get();

        return view('CP.trips.edit', [
            'trip' => $trip,
            'invoices' => $invoices,
            'companies' => $companies,
            'addresses' => $addresses,
            'currencies' => $currencies,
            'status' => $this->getStatus(),
        ]);
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
        $trip = Trip::findOrfail($request->id);
        $this->setData($trip);

        ShippingInvoice::where('trip_id', $trip->id)->whereNotIn('id', $request->invoices)->update(['trip_id' => null]); /* reset all invoices */
        ShippingInvoice::where('address_id', $trip->address_id)->whereNull('trip_id')->whereNull('received_at')->whereIn('id', $request->invoices)
            ->update(['trip_id' => $trip->id]);

        if ($trip->wasChanged('state')) {
            if ($trip->isReceived()) {
                SendArrivedNotification::dispatch($trip);
            } else if ($trip->isOnTheWay()) {
                SendOnTheWayNotification::dispatch($trip);
            }
        }

        return response()->json([
            'redirectTo' => url('cp/trips', $trip->id),
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer|min:1',
        ]);
        $trip = Trip::findOrfail($request->id);
        ShippingInvoice::where('trip_id', $trip->id)->update(['trip_id' => null]);
        $trip->delete();
    }

    private function validateData($update = false)
    {
        $this->validate(request(), [
            'trip_number' => 'required|string|min:1|max:32|unique:trips' . ($update ? ',trip_number,' . request('id') : ''),
            'tracking_number' => 'required|string|min:3,max:32|unique:trips' . ($update ? ',tracking_number,' . request('id') : ''),
            'company' => 'required|integer|min:1|exists:shipping_companies,id',
            'address' => 'required|integer|min:1|exists:addresses,id',
            'currency' => 'required|integer|min:1|exists:currency_types,id',
            'exchange_rate' => 'required|numeric|min:0.000001',
            'state' => 'required|integer|min:1|max:3',
            'state_desc' => 'nullable|string|max:150',
            'cost' => 'required|numeric|min:0',
            'weight' => 'required|string|min:3|max:32',
            'extra' => 'nullable|string|max:150',
            'exit_at' => 'required|date|max:' . date('Y-m-d'),
            'estimated_arrive_at' => 'nullable|date|after_or_equal:exit_at',
            'arrived_at' => (request('state') == 3 ? 'required' : 'nullable') . '|date|after_or_equal:exit_at',
            'invoices' => ['required', 'array', 'min:1', new TripInvoices(request('address'), $update ? request('id') : null)],
            'invoices.*' => 'required|integer|min:1',
        ], [],
            [
                'exit_at' => 'تاريخ الخروج',
                'estimated_arrive_at' => 'تاريخ الوصول المتوقع',
                'arrived_at' => 'تاريخ الوصول الفعلي',
                'invoices' => 'الفواتير',
            ]);
    }

    private function setData($trip)
    {
        $request = request();
        $trip->trip_number = $request->trip_number;
        $trip->tracking_number = $request->tracking_number;
        $trip->company_id = $request->company;
        $trip->address_id = $request->address;
        $trip->currency_type_id = $request->currency;
        $trip->state = $request->state;
        $trip->state_desc = $request->state_desc;
        $trip->weight = $request->weight;
        $trip->exchange_rate = $request->exchange_rate;
        $trip->cost = $request->cost;
        $trip->extra = $request->extra;
        $trip->exit_at = $request->exit_at;
        $trip->estimated_arrive_at = $request->estimated_arrive_at;
        if ($request->state == 3) { /* if state is received(arrived) then set arrived date */
            $trip->arrived_at = $request->arrived_at;
        } else {
            $trip->arrived_at = null;
        }
        $trip->save();
    }

    /* get all status of trips (key and value) */
    private function getStatus()
    {
        return trans('tripStatus.trip_status');
    }
}
