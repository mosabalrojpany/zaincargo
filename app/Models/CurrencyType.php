<?php

namespace App\Models;

use App\Traits\Models\FetchActive;
use Illuminate\Database\Eloquent\Model;

class CurrencyType extends Model
{
    use FetchActive;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'value' => 'float',
    ];

    public function createdAt()
    {
        return $this->created_at->format('Y-m-d g:ia');
    }

    public function updatedAt()
    {
        return $this->updated_at->format('Y-m-d g:ia');
    }
}
