<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingInvoice extends Model
{
    public $timestamps = false;
        protected $fillable =['id',
    'Insurance'
    ];
    protected $casts = [
        'length' => 'float',
        'width' => 'float',
        'height' => 'float',
        'volumetric_weight' => 'float',
        'cubic_meter' => 'float',
        'weight' => 'float',
        'cost' => 'float',
        'additional_cost' => 'float',
        'Insurance' => 'float',//التأمين
        'total_cost' => 'float',
        'exchange_rate' => 'float',
        'paid_up' => 'float',
        'paid_exchange_rate' => 'float',
        'created_at' => 'datetime:Y-m-d g:ia',
        'received_at' => 'date:Y-m-d',
        'arrived_at' => 'date:Y-m-d',
    ];

    //اداكانت خالية فارج قيمة لا يوجد تامين
    public function Insuranceogitem()
    {
        $ins = 1.5/100;
        return $this->Insurance == null ? 'لا يوجد تامين':$this->Insurance*$ins;
    }
    public function items()
    {
        return $this->hasMany(ShippingInvoiceItem::class, 'invoice_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(ShipmentComment::class, 'shipment_id', 'id')->orderBy('id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    public function currency()
    {
        return $this->belongsTo(CurrencyType::class, 'currency_type_id', 'id');
    }

    public function paidCurrency()
    {
        return $this->belongsTo(CurrencyType::class, 'payment_currency_type_id', 'id');
    }

    /**
     * Scope a query to include invoices with customers for trips.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $address
     * @param  mixed  $trip
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetInvoicesForTrips($query, $address, $trip = null)
    {
        $query->join('customers', 'customers.id', 'shipping_invoices.customer_id')
            ->select('customers.code as customer_code', 'shipping_invoices.id', 'shipping_invoices.customer_id', 'shipping_invoices.tracking_number', 'shipping_invoices.shipment_code', 'shipping_invoices.arrived_at', 'shipping_invoices.created_at', 'shipping_invoices.weight', 'shipping_invoices.volumetric_weight', 'shipping_invoices.cubic_meter', 'shipping_invoices.cost', 'shipping_invoices.additional_cost', 'shipping_invoices.total_cost')
            ->where('trip_id', $trip)->where('address_id', $address);

    }

    /**
     * Scope a query to filter shipments depends on state.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $state
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereState($query, $state)
    {
        if ($state == 5) { // Received (Customer took his shipment)
            return $query->whereNotNull('received_at');
        }

        $query->whereNull('received_at');

        if ($state == 1) { // Received abroad (Still in the external stock)
            return $query->whereNull('trip_id');
        }

        // shipment linked to trip but not received , so it depends on trip and state should be between 2 and 4
        return $query->whereHas('trip', function ($q) use ($state) {
            $q->where('state', $state - 1);
        });
    }

    public function receivingPlace()
    {
        return $this->belongsTo(ReceivingPlace::class, 'receive_in', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by', 'id');
    }

    public function getState()
    {
        if ($this->received_at) {
            return __('shipmentStatus.shipment_status.5');
        }
        if ($this->trip_id) {
            return $this->trip->getState();
        }
        return __('shipmentStatus.shipment_status.1');
    }

    /* description for state */
    public function getStateDesc()
    {
        if ($this->received_at) {
            return 'في المخزن ولم تشحن للأن';
        }
        if ($this->trip_id) {
            return $this->trip->state_desc;
        }
        return 'تم تسليم الشحنة';
    }

    public function trip_number()
    {
        return $this->trip ? $this->trip->trip_number : '------';
    }

    public function estimated_arrive_at()
    {
        return $this->trip && $this->trip->estimated_arrive_at ? $this->trip->estimated_arrive_at() : '------';
    }

    public function trip_tracking_number()
    {
        return $this->trip ? $this->trip->tracking_number : '------';
    }

    public function received_at()
    {
        return $this->received_at ? $this->received_at->format('Y-m-d') : 'لم يتم تسليمها';
    }

    public function arrived_at()
    {
        return $this->arrived_at->format('Y-m-d');
    }

    public function created_at()
    {
        return $this->created_at->format('Y-m-d g:ia');
    }

    public function total_cost()
    {
        return $this->total_cost . " <bdi>{$this->currency->sign}</bdi>";
    }

    public function paid()
    {
        if ($this->paid_up) {
            return $this->paid_up . " <bdi>{$this->paidCurrency->sign}</bdi>";
        }
        return '---';
    }

    /**
     * Check if currency of total cost of shipment same main currency
     */
    public function isCurrencyEqualsMain()
    {
        return app_settings()->currency_type_id == $this->currency_type_id;
    }

    /**
     * Check if currency of paid_up of shipment same main currency
     */
    public function isPaidCurrencyEqualsMain()
    {
        return app_settings()->currency_type_id == $this->payment_currency_type_id;
    }

    /**
     * Check if shipment is ready to receive
     */
    public function isReadyToReceive()
    {
        return !$this->received_at && $this->trip_id && $this->trip->state == 3;
    }

    /**
     * Check if shipment is received(completed - customer took shipment) or not
     */
    public function isReceived()
    {
        return !!$this->received_at;
    }
}
