<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logins extends Model
{
    public $timestamps = false;

    protected $dates = ['log_in', 'log_out'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
