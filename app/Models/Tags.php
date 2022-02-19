<?php

namespace App\Models;

use App\Traits\Models\FetchActive;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use FetchActive;

    //
    public $timestamps = false;

    protected $hidden = ['pivot'];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
