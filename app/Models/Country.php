<?php

namespace App\Models;

use App\Traits\Models\FetchActive;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use FetchActive;

    //
    protected $table = 'countries';
    public $timestamps = false;

    public function Cities()
    {
        return $this->hasMany(City::class);
    }
    public function getLogo()
    {
        return url('storage/images/countries', $this->logo);
    }
    public function getAvatarLogo()
    {
        return url('storage/images/countries/avatar', $this->logo);
    }
}
