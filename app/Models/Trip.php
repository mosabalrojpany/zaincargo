<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    public $timestamps = false;

    protected $casts = [
        'cost' => 'float',
        'exchange_rate' => 'float',
        'exit_at' => 'date:Y-m-d',
        'estimated_arrive_at' => 'date:Y-m-d',
        'arrived_at' => 'date:Y-m-d',
        'created_at' => 'datetime:Y-m-d g:ia',
    ];

    public function getState()
    {
        return trans("tripStatus.trip_status.$this->state");
    }

    public function isOnTheWay()
    {
        return $this->state == 2;
    }

    public function isReceived()
    {
        return $this->state == 3;
    }

    public function company()
    {
        return $this->belongsTo(ShippingCompany::class, 'company_id', 'id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function invoices()
    {
        return $this->hasMany(ShippingInvoice::class, 'trip_id', 'id');
    }

    public function currency()
    {
        return $this->belongsTo(CurrencyType::class, 'currency_type_id', 'id');
    }

    /**
     * Get short info for invoices that linked to current Trip
     */
    public function withInvoices()
    {
        if (!isset($this->shortInvoices)) {
            $this->shortInvoices = ShippingInvoice::getInvoicesForTrips($this->address_id, $this->id)->get();
        }
        return $this;
    }

    public function exit_at()
    {
        return $this->exit_at->format('Y-m-d');
    }

    public function estimated_arrive_at()
    {
        return $this->estimated_arrive_at ? $this->estimated_arrive_at->format('Y-m-d') : '';
    }

    public function arrived_at()
    {
        return $this->arrived_at ? $this->arrived_at->format('Y-m-d') : '';
    }

    public function created_at()
    {
        return $this->created_at->format('Y-m-d g:ia');
    }

    public function cost()
    {
        return $this->cost . " <bdi>{$this->currency->sign}</bdi>";
    }

    /**
     * Check if currency of cost of trip same main currency
     */
    public function isCurrencyEqualsMain()
    {
        return app_settings()->currency_type_id == $this->currency_type_id;
    }
}
