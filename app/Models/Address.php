<?php

namespace App\Models;

use App\Traits\Models\FetchActive;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use FetchActive;

    //
    public $timestamps = false;

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function prices()
    {
        return $this->hasMany(AddressPrice::class);
    }

    public function getTypeIcon()
    {
        return url('images/svg', ($this->type == 1 ? 'plane-air-shipping.svg' : 'boat-sea-shipping.svg'));
    }

    public function getType()
    {
        return trans("shippingAddress.types.$this->type");
    }

}
