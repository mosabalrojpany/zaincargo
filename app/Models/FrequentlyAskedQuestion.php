<?php

namespace App\Models;

use App\Traits\Models\FetchActive;
use Illuminate\Database\Eloquent\Model;

class FrequentlyAskedQuestion extends Model
{

    use FetchActive;

    public $timestamps = false;
}
