<?php

namespace App\Models;

use App\Traits\Models\FetchActive;
use Illuminate\Database\Eloquent\Model;

class ShippingCompany extends Model
{
    use FetchActive;

    //
    public $timestamps = false;
}
