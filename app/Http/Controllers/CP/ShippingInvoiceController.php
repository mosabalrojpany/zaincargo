<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\CurrencyType;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\ReceivingPlace;
use App\Models\ShippingInvoice;
use App\Models\ShippingInvoiceItem;
use App\Notifications\Shipments\NewShipment;
use App\Notifications\Shipments\UpdateData;
use App\Notifications\Shipments\UpdateStatus;
use DB;
use File;
use Illuminate\Http\Request;
use Image;

class ShippingInvoiceController extends Controller
{
    private $imgPath;
    private $imgAvatarPath;

    public function __construct()
    {
        $this->imgPath = public_path('/storage/images/shipping-invoices-items/');
        $this->imgAvatarPath = $this->imgPath . 'avatar/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ShippingInvoice::with(['customer:id,code,name', 'trip:id,trip_number,state', 'currency', 'paidCurrency']);

        if ($request->search) {

            $this->validate($request, [
                'id' => 'nullable|integer|min:1',
                'code' => 'nullable|integer|min:0',
                'tracking_number' => 'nullable|string|max:64',
                'shipment_code' => 'nullable|string|max:32',
                'address' => 'nullable|integer|min:1',
                'receive_in' => 'nullable|integer|min:1',
                'state' => 'nullable|integer',
                'received_at_from' => 'nullable|date|before_or_equal:today',
                'received_at_to' => 'nullable|date|before_or_equal:today|after_or_equal:received_at_from',
            ]);
            if ($request->id) {
                $query->where('id', $request->id);
            }
            if ($request->address) {
                $query->where('address_id', $request->address);
            }
            if ($request->receive_in) {
                $query->where('receive_in', $request->receive_in);
            }
            if ($request->tracking_number) {
                $query->where('tracking_number', 'Like', "%$request->tracking_number%");
            }
            if ($request->received_at_from) {
                $query->whereDate('received_at', '>=', $request->received_at_from);
            }
            if ($request->received_at_to) {
                $query->whereDate('received_at', '<=', $request->received_at_to);
            }
            if ($request->shipment_code) {
                $query->where('shipment_code', 'Like', "%$request->shipment_code%");
            }
            if ($request->code) {
                $query->orderBy('received_at');
                $query->whereHas('customer', function ($q) use ($request) {
                    $q->where('code', get_customer_code_starts_with() . $request->code);
                });
            }
            if ($request->state) {
                $query->whereState($request->state);
            }
        }
        $invoices = $query->latest('id')->paginate(30);
        $invoices->appends($request->query());

        return view('CP.shipping_invoices.index', [
            'invoices' => $invoices,
            'addresses' => Address::select('id', 'name')->get(),
            'receiving_places' => ReceivingPlace::select('id', 'name')->orderBy('name')->get(),
            'currencies' => CurrencyType::active()->select('id', 'name', 'value')->get(),
        ]);
    }

    /**
     * Return Invoices (without items, just important columns of invoice) by address.
     * @param int $address
     * @return \Illuminate\Http\Response
     */
    public function getInvoicesByAddress($address)
    {
        checkIfIdCorrect($address);
        $invoices = ShippingInvoice::getInvoicesForTrips($address)->whereNull('received_at')->get();

        return $invoices;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $addresses = Address::select('id', 'name')->active()->orderBy('name')->get();
        $receivingPlaces = ReceivingPlace::select('id', 'name')->active()->orderBy('name')->get();
        $currencies = CurrencyType::active()->select('id', 'name', 'sign', 'value')->get();

        return view('CP.shipping_invoices.create-edit', [
            'addresses' => $addresses,
            'receivingPlaces' => $receivingPlaces,
            'currencies' => $currencies,
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

            $invoice = new ShippingInvoice();
            $invoice->added_by = auth()->user()->id;
            $this->setInvoiceHeaderData($invoice);

            /*  Start add new items  */
            $this->setItemsImages($invoice->id);
            /*  End add new items  */

            $invoice->customer->notify(new NewShipment($invoice));

            $request->id = $invoice->id; /* To use id in redirection */

        });

        return response()->json([
            'redirectTo' => url('cp/shipping-invoices', $request->id),
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
        $invoice = ShippingInvoice::with('items')->findOrfail($id);
        $currencies = CurrencyType::active()->select('id', 'name', 'value')->get();

        if (hasRole('shipment_comments_show')) {
            $invoice->load(['comments', 'comments.customer', 'comments.user']);
        }

        return view('CP.shipping_invoices.show', [
            'invoice' => $invoice,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Preview invoice before print.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    function print($id, Request $request) {

        checkIfIdCorrect($id);

        $this->validate($request, [
            'currency' => 'nullable|integer|min:1',
            'exchange_rate' => 'required_with:currency|numeric|min:0.000001',
            'paid_up' => 'required_with:currency|numeric|min:0',
        ]);

        $invoice = ShippingInvoice::findOrfail($id);

        if ($invoice->isReadyToReceive()) {
            $invoice->payment_currency_type_id = $request->currency;
            $invoice->paid_exchange_rate = $request->exchange_rate;
            $invoice->paid_up = $request->paid_up;
            $invoice->received_at = new \DateTime();
            $invoice->save();
            $invoice->customer->notify(new UpdateStatus($invoice));
        }

        return view('CP.shipping_invoices.print', [
            'invoice' => $invoice,
        ]);
    }

    function printlabel($id, Request $request) {

        checkIfIdCorrect($id);
        $invoice = ShippingInvoice::findOrfail($id);
        return view('CP.shipping_invoices.label_print', [
            'invoice' => $invoice,
        ]);
    }

    /**
     * Preview multiple invoice before print.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function printMultipleInvoices(Request $request)
    {
        $count = count($request->shipments['id']);

        $this->validate($request, [
            'shipments' => 'required|array|min:1',
            'shipments.id' => 'required|array|min:1',
            'shipments.state' => 'required|array|size:' . $count,
            'shipments.currency' => 'required|array|size:' . $count,
            'shipments.exchange_rate' => 'required|array|size:' . $count,
            'shipments.paid_up' => 'required|array|size:' . $count,

            'shipments.id.*' => 'required|integer|min:1',
            'shipments.state.*' => 'required|string',
            'shipments.currency.*' => 'required|integer|min:1',
            'shipments.exchange_rate.*' => 'required|numeric|min:0.000001',
            'shipments.paid_up.*' => 'required|numeric|min:0',
        ]);

        $invoices = ShippingInvoice::with('currency:id,name,sign')->whereIn('id', $request->shipments['id'])->orderBy('id')->get();

        foreach ($invoices as $invoice) {

            $i = array_search($invoice->id, $request->shipments['id']);

            if ($request->shipments['state'][$i] == 'update' && $invoice->isReadyToReceive()) {
                $invoice->received_at = now();
                $invoice->payment_currency_type_id = $request->shipments['currency'][$i];
                $invoice->paid_exchange_rate = $request->shipments['exchange_rate'][$i];
                $invoice->paid_up = $request->shipments['paid_up'][$i];
                $invoice->save();
                $invoice->customer->notify(new UpdateStatus($invoice));
            }
        }

        $invoices->load('paidCurrency:id,name,sign');

        $total_paid_by_currencies = $invoices->where('payment_currency_type_id', '!=', null)->groupBy('payment_currency_type_id')->map(function ($row) {
            return [
                'count' => $row->count(),
                'amount' => $row->sum('paid_up'),
                'currency' => $row[0]->paidCurrency->name,
            ];
        });

        return view('CP.shipping_invoices.print-multiple', [
            'invoices' => $invoices,
            'total_paid_by_currencies' => $total_paid_by_currencies,
        ]);
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
        $invoice = ShippingInvoice::with('items')->findOrfail($id);

        $addresses = Address::select('id', 'name')->activeOrId($invoice->address_id)->orderBy('name')->get();
        $receivingPlaces = ReceivingPlace::select('id', 'name')->activeOrId($invoice->receive_in)->orderBy('name')->get();
        $currencies = CurrencyType::active()->select('id', 'name', 'sign', 'value')->get();

        return view('CP.shipping_invoices.create-edit', [
            'invoice' => $invoice,
            'addresses' => $addresses,
            'receivingPlaces' => $receivingPlaces,
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
            'id' => 'required|integer|min:1',
            'deleted_items.*' => 'required|integer',
        ]);
        $this->validateData(true);

        DB::transaction(function () use ($request) {

            $invoice = ShippingInvoice::findOrfail($request->id);
            $old_state = $invoice->getState();
            $this->setInvoiceHeaderData($invoice);

            /*  Start add new items  */
            $this->setItemsImages($invoice->id);
            /*  End add new items  */

            if ($request->deleted_items) {

                $deletedImgs = ShippingInvoiceItem::select('img')->where('invoice_id', $invoice->id)->whereIn('id', $request->deleted_items)->pluck('img')->toArray();
                ShippingInvoiceItem::where('invoice_id', $invoice->id)->whereIn('id', $request->deleted_items)->delete();
                $this->deleteImages($deletedImgs);

            }

            if ($invoice->wasChanged()) {

                if ($invoice->wasChanged('customer_id')) {

                    Notification::shipments()->deleteByMainId($invoice->id);
                    $invoice->comments()->delete();
                    $invoice->customer->notify(new NewShipment($invoice));

                } else {

                    if ($old_state != $invoice->getState()) {
                        $invoice->customer->notify(new UpdateStatus($invoice));
                    }

                    $invoice->customer->notify(new UpdateData($invoice));

                }

            }

        });

        return response()->json([
            'redirectTo' => url('cp/shipping-invoices', $request->id),
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
            'id' => 'required|integer',
        ]);
        $invoice = ShippingInvoice::findOrfail($request->id);
        $imgs = ShippingInvoiceItem::where('invoice_id', $invoice->id)->pluck('img')->toArray();
        $invoice->comments()->delete();
        $invoice->delete();

        $this->deleteImages($imgs);
        Notification::shipments()->deleteByMainId($invoice->id);
    }

    /* Start Helper functions */

    /**
     * Validate Data
     */
    private function validateData($update = false)
    {
        $request = request();
        /* Add starts of code becuase I get code of customer as integer */
        $request['code'] = get_customer_code_starts_with() . (int) $request['code'];

        $this->validate(request(), [
            'tracking_number' => 'required|string|min:3,max:64|unique:shipping_invoices' . ($update ? ',tracking_number,' . request('id') : ''),
            'shipment_code' => 'required|string|min:3,max:32',
            'code' => 'required|string|min:2|max:12|exists:customers,code',
            'address' => 'required|integer|exists:addresses,id',
            'receving_place' => 'required|integer|exists:receiving_places,id',
            'currency' => 'required|integer|exists:currency_types,id',
            'payment_curreny' => 'required_with:received_at|integer|exists:currency_types,id',

            'length' => 'required|numeric|min:0.1',
            'width' => 'required|numeric|min:0.1',
            'height' => 'required|numeric|min:0.1',
            'weight' => 'required|numeric|min:0.001',
            'cost' => 'required|numeric|min:0',
            'additional_cost' => 'required|numeric|min:0',
            'exchange_rate' => 'required|numeric|min:0',
            'paid_exchange_rate' => 'required_with:received_at|numeric|min:0',
            'paid_up' => 'required_with:received_at|numeric|min:0',

            'extra' => 'nullable|string|max:150',
            'note' => 'nullable|string|max:150',
            'arrived_at' => 'required|date|before_or_equal:' . date('Y-m-d'),
            'received_at' => 'nullable|date|after_or_equal:arrived_at|before_or_equal:' . date('Y-m-d'),

            'imgs' => 'nullable|array|min:1',
            'imgs.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);
    }

    /**
     * Set invoice data
     * @param App\Models\ShippingInvoice  $invoice
     */
    private function setInvoiceHeaderData(ShippingInvoice $invoice)
    {
        $request = request();
        $invoice->tracking_number = $request->tracking_number;
        $invoice->shipment_code = $request->shipment_code;
        $invoice->customer_id = Customer::select('id')->where('code', $request->code)->firstOrFail()->id;
        $invoice->address_id = $request->address;
        $invoice->receive_in = $request->receving_place;

        $invoice->length = $request->length;
        $invoice->width = $request->width;
        $invoice->height = $request->height;

        $cubic_centimeter = $invoice->length * $invoice->width * $invoice->height;
        $invoice->volumetric_weight = $cubic_centimeter / 5000;
        $invoice->cubic_meter = $cubic_centimeter / 1000000; // CBM
        $invoice->weight = $request->weight;

        $invoice->cost = $request->cost;
        $invoice->additional_cost = $request->additional_cost;
        $invoice->Insurance = $request->Insurance;
        $invoice->currency_type_id = $request->currency;
        $invoice->exchange_rate = $request->exchange_rate;
        $invoice->total_cost = $invoice->cost + $invoice->additional_cost;

        $invoice->extra = $request->extra;
        $invoice->note = $request->note;
        $invoice->arrived_at = $request->arrived_at;

        if ($invoice->trip_id && $invoice->trip->state == 3 && $request->received_at) {
            $invoice->received_at = $request->received_at;
            $invoice->payment_currency_type_id = $request->payment_curreny;
            $invoice->paid_exchange_rate = $request->paid_exchange_rate;
            $invoice->paid_up = $request->paid_up;
        } else {
            $invoice->received_at = null;
            $invoice->payment_currency_type_id = null;
            $invoice->paid_exchange_rate = null;
            $invoice->paid_up = null;
        }
        $invoice->save();
    }

    /**
     *  Set images to invoice items
     *
     * @param int $invoiceId id of invoice
     */
    private function setItemsImages($invoiceId)
    {
        $imgs = request()->file('imgs');
        if (empty($imgs)) {
            return false;
        }
        $n_imgs = count($imgs);
        $queryItems = [];

        for ($i = 0; $i < $n_imgs; $i++) {
            $queryItems[] = [
                'invoice_id' => $invoiceId,
                'img' => $this->saveImage(request()->file("imgs.$i")),
            ];
        }

        ShippingInvoiceItem::insert($queryItems);
    }

    /**
     * Save Image make avatar copy
     *
     * @param $image
     * @return string name of image
     */
    private function saveImage($image): string
    {
        $img_name = generateFileName('img_', $image->getClientOriginalExtension());

        Image::make($image)->resize(165, 140)->save($this->imgAvatarPath . $img_name);
        $image->move($this->imgPath, $img_name);

        return $img_name;
    }

    /**
     * Delete Images for items
     * @param array $images  names of images that I will delete them
     */
    private function deleteImages($images)
    {
        if (!empty($images)) {
            foreach ($images as $img) {
                File::delete($this->imgAvatarPath . $img);
                File::delete($this->imgPath . $img);
            }
        }
    }

    /* End Helper functions */

}
