<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientLogin extends Model
{
    public $timestamps = false;

    protected $dates = ['log_in', 'log_out'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
