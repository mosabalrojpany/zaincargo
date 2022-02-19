<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\CurrencyType;
use App\Models\MoneyTransfer;
use App\Models\Notification;
use Illuminate\Http\Request;

class MoneyTransferController extends Controller
{

    private $filesPath;

    public function __construct()
    {
        $this->filesPath = storage_path('app/money-transfers/files/');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = MoneyTransfer::with('currency:id,sign')->where('customer_id', authClient()->user()->id)->latest('id');

        if ($request->search) {

            $this->validate($request, [
                'id' => 'nullable|integer|min:1',
                'state' => 'nullable|integer',
                'show' => 'nullable|integer|min:10|max:500',
            ]);

            if ($request->id) {
                $query->where('id', $request->id);
            }
            if ($request->state) {
                $query->where('state', $request->state);
            }
        }

        $request['show'] = (int) $request->show ? $request->show : 25;
        $transfers = $query->paginate($request->show);
        $transfers->appends($request->query());

        return view('Client.money_transfers.index', [
            'transfers' => $transfers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::select('id', 'name')->active()->get();
        $cities = City::select('id', 'name', 'country_id')->active()->get();
        $currencies = CurrencyType::select('id', 'name', 'sign')->active()->get();

        return view('Client.money_transfers.create-edit', [
            'countries' => $countries,
            'cities' => $cities,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $this->validateData();
        $transfer = new MoneyTransfer();
        $transfer->state = 1;
        $transfer->customer_id = authClient()->user()->id;
        $this->setData($transfer);
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
        $transfer = MoneyTransfer::where('customer_id', authClient()->user()->id)->findOrfail($id);

        Notification::currentClient()->moneyTransfers()->updateAsReadByMainId($transfer->id);

        return view('Client.money_transfers.show', ['transfer' => $transfer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        checkIfIdCorrect($id);

        $transfer = MoneyTransfer::where('customer_id', authClient()->user()->id)
            ->where('state', 1)->findOrfail($id);

        $countries = Country::select('id', 'name')->active()->get();
        $cities = City::select('id', 'name', 'country_id')->active()->get();
        $currencies = CurrencyType::select('id', 'name', 'sign')->active()->get();

        return view('Client.money_transfers.create-edit', [
            'transfer' => $transfer,
            'countries' => $countries,
            'cities' => $cities,
            'currencies' => $currencies,
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
            'id' => 'required|integer',
        ]);
        $this->validateData();

        $transfer = MoneyTransfer::where('customer_id', authClient()->user()->id)
            ->where('state', 1)->findOrfail($request->id);

        $this->setData($transfer);
    }

    private function validateData()
    {
        $validation = [
            'country' => 'required|integer|exists:countries,id',
            'city' => 'required|integer|exists:cities,id,country_id,' . request('country'),
            'currency' => 'required|integer|exists:currency_types,id',

            'recipient' => 'required|string|min:9|max:32',
            'phone' => ['required', 'string', 'regex:/^([0-9\-\+]\s*){3,14}$/'],
            'phone2' => ['nullable', 'string', 'regex:/^([0-9\-\+]\s*){3,14}$/'],

            'recipient_type' => 'required|integer|between:1,2',
            'receiving_method' => 'required|integer|between:1,2',
            /* required when receiving_method = 2  */
            /* 'account_number' => 'required|string|min:3|max:32',
            'account_number2' => 'required|string|min:3|max:32',
            'account_number3' => 'required|string|min:3|max:32', */
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,xls,csv|max:1024',

            'amount' => 'required|numeric|min:1',
            'fee_on_recipient' => 'required|boolean',
        ];

        if (request('receiving_method') == 2) {
            $validation['account_number'] = 'required|string|min:3|max:32';
            $validation['account_number2'] = 'nullable|string|min:3|max:32';
            $validation['account_number3'] = 'nullable|string|min:3|max:32';
        }

        $this->validate(request(), $validation);
    }

    private function setData($transfer)
    {
        $request = request();

        $transfer->country_id = $request->country;
        $transfer->city_id = $request->city;
        $transfer->currency_type_id = $request->currency;

        $transfer->recipient = $request->recipient;
        $transfer->phone = $request->phone;
        $transfer->phone2 = $request->phone2;

        $transfer->recipient_type = $request->recipient_type;
        $transfer->receiving_method = $request->receiving_method;

        if (request('receiving_method') == 2) {
            $transfer->account_number = $request->account_number;
            $transfer->account_number2 = $request->account_number2;
            $transfer->account_number3 = $request->account_number3;
        } else {
            $transfer->account_number = null;
            $transfer->account_number2 = null;
            $transfer->account_number3 = null;
        }

        $transfer->amount = $request->amount;
        $transfer->fee_on_recipient = $request->fee_on_recipient;

        if ($request->hasFile('file')) {

            $file = $request->file('file');
            $file_name = generateFileName('', $file->getClientOriginalExtension());
            $file->move($this->filesPath, $file_name);

            if ($transfer->file) { // Delete old file
                File::delete($this->filesPath . $transfer->file);
            }

            $transfer->file = $file_name;
        }

        $transfer->save();

        return response()->json([
            'redirectTo' => url("/client/money-transfers/$transfer->id"),
        ], 200)->send();
    }
}
