<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressPrice extends Model
{
    public $timestamps = false;
    protected $casts = [
        'from' => 'float',
        'to' => 'float',
        'price' => 'float',
    ];
}
