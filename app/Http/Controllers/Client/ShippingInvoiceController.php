<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\ShippingInvoice;
use App\Http\Requests\InsuranceuRequest;
use Illuminate\Http\Request;

class ShippingInvoiceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ShippingInvoice::with('trip:id,trip_number,state')
            ->select('id', 'tracking_number', 'shipment_code', 'trip_id', 'received_at', 'arrived_at')
            ->where('customer_id', authClient()->user()->id)->orderBy('id', 'DESC');

        if ($request->search) {

            $this->validate($request, [
                'id' => 'nullable|integer|min:1',
                'tracking_number' => 'nullable|string|max:64',
                'shipment_code' => 'nullable|string|max:32',
                'show' => 'nullable|integer|min:10|max:500',
            ]);

            if ($request->id) {
                $query->where('id', $request->id);
            }
            if ($request->tracking_number) {
                $query->where('tracking_number', 'Like', "%$request->tracking_number%");
            }
            if ($request->shipment_code) {
                $query->where('shipment_code', 'Like', "%$request->shipment_code%");
            }
            if ($request->state) {
                $query->whereState($request->state);
            }
        }

        $request['show'] = (int) $request->show ? $request->show : 25;
        $invoices = $query->paginate($request->show);
        $invoices->appends($request->query());

        return view('Client.shipping_invoices.index', [
            'invoices' => $invoices,
        ]);
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
        $invoice = ShippingInvoice::where('customer_id', authClient()->user()->id)
            ->with([
                'items',
                'comments' => function ($query) {
                    $query->whereNull('customer_id')->orWhere('customer_id', authClient()->user()->id);
                },
            ])->findOrfail($id);

        Notification::currentClient()->shipments()->updateAsReadByMainId($invoice->id);

        return view('Client.shipping_invoices.show', [
            'invoice' => $invoice,
        ]);
    }

    public function Insuranceupdate(InsuranceuRequest $request)
    {
        $Insurance = $request->validated();
        $invoice = ShippingInvoice::find($request->id);
        $ins = $Insurance['Insurance'] * 1.5 / 100;
        $Insurance['total_cost'] = $invoice['total_cost']+$ins;
        $invoice->update($Insurance);
    }
}
