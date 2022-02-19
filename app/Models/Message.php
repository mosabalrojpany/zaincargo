<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public $timestamps = false;

    protected $dates = ['created_at'];

    public function getState()
    {
        return trans("messageStatus.status.$this->unread");
    }

    public function created_at()
    {
        return $this->created_at->format('Y-m-d g:ia');
    }
}
