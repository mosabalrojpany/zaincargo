<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\PurchaseOrder;
use App\Models\CleintMerchanttransaction;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\PurchaseOrderItem;
use Response;
use Illuminate\Support\Facades\DB;

class MerchantprchaseController extends Controller
{
    public function index(Request $request)
    {
        if (authClient()->user()->merchant_state == 1) {
            $query = PurchaseOrder::select()->orderBy('id')->where('merchant_id', authClient()->user()->id)->where('state', '>=', 5);
            if ($request->state == 1) {
                $order = $query->where('id', $request->id);
                if ($order) {
                    $this->changestate($request->id);
                } else {
                    return Response::json(['error1' => 'لا يوجد طلب شراء بهدا الرقم'], 500);
                }
            }
            if ($request->state == 2) {
                $order = $query->where('id', $request->id);
                if ($order) {
                    $this->removefrommerchant($request->id, $request->merchant_note);
                } else {
                    return Response::json(['error1' => 'القيمة المراد سحبها تتجاوز القيمة الموجودا فالحساب'], 500);
                }
            }
            if ($request->search == 1) {
                if ($request->state) {
                    $query->where('state', $request->state);
                }
                if ($request->id) {
                    $query->where('id', $request->id);
                }
                if ($request->merchant_state) {
                    $query->where('merchant_state', $request->merchant_state);
                }
                if ($request->ordered_at_from) {
                    $query->whereDate('ordered_at', '>=', $request->ordered_at_from);
                }
                if ($request->ordered_at_to) {
                    $query->whereDate('ordered_at', '<=', $request->ordered_at_to);
                }
            }
            $orders = $query->paginate(25);
            return view('Client.merchant_pirchase_order.index', compact('orders'));
        } else {
            abort(404);
        }
    }

    public function show($id)
    {
        if (authClient()->user()->merchant_state == 1) {
            checkIfIdCorrect($id);
            $order = PurchaseOrder::with(['items'])->findOrfail($id);
            if ($order->merchant_id == authClient()->user()->id) {
                return view('Client.merchant_pirchase_order.show', compact('order'));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }
    private function changestate($order)
    {
        $upda['state'] = 7;
        $upda['ordered_at'] = date('Y-m-d H:i:s');
        DB::table('purchase_orders')->where('id', $order)->update($upda);
        $state = 1;
        $this->cleintmechaerttransaction($order, $state, null);
    }

    private function removefrommerchant($order, $note)
    {
        $upda['merchant_id'] = null;
        $upda['merchant_note'] = $note . "-" . 'التاجر' . "-" . authClient()->user()->name . "-" . authClient()->user()->code;
        DB::table('purchase_orders')->where('id', $order)->update($upda);
        $state = 2;
        $this->cleintmechaerttransaction($order, $state, $upda['merchant_note']);
    }

    private function cleintmechaerttransaction($order, $state, $note)
    {
        $trnsaction['merchant_id'] = authClient()->user()->id;
        $trnsaction['merchant_code'] = authClient()->user()->code;
        $trnsaction['merchant_name'] = authClient()->user()->name;
        $trnsaction['order_id'] = $order;
        if ($state === 1) {
            $trnsaction['note'] = "التاجر قم بتغيير حالة هده الفاتورة الى تم الشراء";
        } elseif ($state === 2) {
            $trnsaction['note'] = "التاجر قام برفض الفاتورة";
            $trnsaction['merchant_note'] = $note . "-" . 'التاجر' . "-" . authClient()->user()->name . " -  " . authClient()->user()->code;
        }
        CleintMerchanttransaction::create($trnsaction);
    }
}
