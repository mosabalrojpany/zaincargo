<?php

namespace App\Models;

use App\Traits\Models\FetchActive;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use FetchActive;

    //
    protected $table = 'cities';
    public $timestamps = false;

    public function Country()
    {
        return $this->belongsTo(Country::class);
    }
}
