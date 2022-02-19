<?php

namespace App\Models;

use App\Models\BranchesBank;
use App\Models\Customer;
use App\Models\User;
use App\Traits\Models\FetchActive;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{

    use FetchActive;

    protected $table = 'branches';
    public $timestamps = false;

    protected $fillable = ['id', 'city', 'email', 'phone', 'phone2', 'address', 'longitude', 'latitude', 'active','branch_id','state'];

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'branches_id');
    }

    public function customer()
    {
        return $this->hasMany(Customer::class, 'id', 'branches_id');
    }
    public function bank()
    {
        return $this->hasOne(BranchesBank::class, 'id', 'branche_id');
    }

    public function scopestate()
    {
        return $this->where('active','>',0);
    }
}
