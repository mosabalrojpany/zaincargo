<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use DB;
use Illuminate\Http\Request;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = PurchaseOrder::where('customer_id', authClient()->user()->id)->latest('id');

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
        $orders = $query->paginate($request->show);
        $orders->appends($request->query());

        return view('Client.purchase_orders.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Client.purchase_orders.create');
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

            $order = new PurchaseOrder();
            $order->customer_id = authClient()->user()->id;
            $order->state = 1;
            $order->save();

            $items = $request->items;
            $n_items = count($items['desc']);

            $queryItems = array();

            for ($i = 0; $i < $n_items; $i++) {
                $queryItems[] = $this->setItemRowData($order->id, $items, $i);
            }

            PurchaseOrderItem::insert($queryItems);

            $request->id = $order->id; /* To use id in redirection */
        });

        return response()->json([
            'redirectTo' => url('client/purchase-orders', $request->id),
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
        $order = PurchaseOrder::where('customer_id', authClient()->user()->id)->with(['items'])->findOrfail($id);

        Notification::currentClient()->purchaseOrders()->updateAsReadByMainId($order->id);

        return view('Client.purchase_orders.show', [
            'order' => $order,
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
        $order = PurchaseOrder::where('customer_id', authClient()->user()->id)->where('state', 1)->with(['items'])->findOrfail($id);

        return view('Client.purchase_orders.edit', [
            'order' => $order,
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
        $this->validateData();

        DB::transaction(function () use ($request) {

            $order = PurchaseOrder::where('customer_id', authClient()->user()->id)->where('state', 1)->findOrfail($request->id);

            $items = $request->items;
            $added_items = array_keys($items['row_state'], 'added');
            $updated_items = array_keys($items['row_state'], 'updated');

            /*  Start add new items  */
            if ($added_items) {
                $queryAdd = array();
                foreach ($added_items as $index) {
                    $queryAdd[] = $this->setItemRowData($order->id, $items, $index);
                }
                PurchaseOrderItem::insert($queryAdd);
            }
            /*  End add new items  */

            /*  Start update items     */
            foreach ($updated_items as $index) {
                PurchaseOrderItem::where('id', $items['id'][$index])->where('order_id', $order->id)
                    ->update($this->setItemRowData($order->id, $items, $index));
            }
            /*  End update items   */

            if ($request->deleted_items) {
                PurchaseOrderItem::where('order_id', $order->id)->whereIn('id', $request->deleted_items)->delete();
            }

        });

        return response()->json([
            'redirectTo' => url('client/purchase-orders', $request->id),
        ], 200);
    }

    /* Start Helper functions */

    /**
     * Validate Data
     */
    private function validateData()
    {
        $itemsRowsCount = count(request('items.row_state'));

        $this->validate(request(), [
            'items' => 'required|array',

            /*  validate all arrays have same size(length) to make sure data correct  */
            'items.row_state' => 'required|array|min:1',
            'items.link' => 'required|array|size:' . $itemsRowsCount,
            'items.count' => 'required|array|size:' . $itemsRowsCount,
            'items.color' => 'required|array|size:' . $itemsRowsCount,
            'items.desc' => 'required|array|size:' . $itemsRowsCount,

            'items.link.*' => 'required|url',
            'items.count.*' => 'required|integer|min:1',
            'items.color.*' => 'required|string|min:3|max:24',
            'items.desc.*' => 'required|string|min:3|max:150',
        ]);
    }

    /**
     *  Set Items of row data and return the row as array
     *
     * @param int $orderId of Order
     * @param array $items array of items data
     * @param int $index  index of array that I have to set
     *
     * @return array row of items
     */
    private function setItemRowData($orderId, $items, $index)
    {
        return [
            'order_id' => $orderId,
            'link' => $items['link'][$index],
            'color' => $items['color'][$index],
            'count' => $items['count'][$index],
            'desc' => $items['desc'][$index],
        ];
    }

}
