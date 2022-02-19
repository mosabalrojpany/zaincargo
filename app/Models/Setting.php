<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $primaryKey = null;

    public $timestamps = false;

    protected $guarded = [];

    public function currency()
    {
        return $this->belongsTo(CurrencyType::class, 'currency_type_id', 'id');
    }

}
