<?php

namespace App\Models;

use App\Traits\Models\FetchActive;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use FetchActive;

    //
    public $timestamps = false;
}
