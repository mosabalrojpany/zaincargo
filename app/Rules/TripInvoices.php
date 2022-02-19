<?php

namespace App\Rules;

use App\Models\ShippingInvoice;
use Illuminate\Contracts\Validation\Rule;

class TripInvoices implements Rule
{

    protected $address;
    protected $trip;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($address, $trip = null)
    {
        $this->address = $address;
        $this->trip = $trip;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $query = ShippingInvoice::where('address_id', $this->address);

        if ($this->trip) {
            $query->where(function ($q) {
                $q->whereNull('trip_id')->orWhere('trip_id', $this->trip);
            });
        } else {
            $query->whereNull('trip_id');
        }

        $query->whereIn('id', $value);

        return $query->count('*') === count($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'يجب أن تكون جميع الفواتير مسجله في نفس عنوان شحن الرحلة.';
    }
}
