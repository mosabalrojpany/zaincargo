<?php

namespace App\Models;

use App\Models\Branch;
use App\Traits\Models\FetchActive;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, FetchActive;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'branches_id', 'password','merchant_state','affiliate_code','register_from_affiliate',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_access' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'id');
    }

    public function hasAnyRole($permissions)
    {
        foreach ($permissions as $p) {
            if ($this->hasRole($p)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($permission)
    {
        return $this->role->$permission == true;
    }

    public function branchess()
    {
        return $this->belongsTo(Branch::class, 'branches_id', 'id');
    }
    public function register_from()
    {
        return $this->belongsTo(User::class, 'register_from_affiliate', 'affiliate_code');
    }

    /**
     * Get city of branch that user linked to it
     */
    public function getBranchCity()
    {
        if ($this->branchess) {
            return $this->branchess->city;
        }
        return '--';
    }

}
