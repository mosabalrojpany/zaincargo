<?php

namespace App\Models;

use App\Models\Branch;
use App\Models\CustomerWallet;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    protected $fillable =['merchant_state',];
    protected $dates = ['created_at', 'activated_at', 'last_access'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeActivated($query)
    {
        return $query->where('state', 3);
    }

    public function getState()
    {
        return trans("customerStatus.customer_status.$this->state");
    }

    public function getStateColor()
    {
        if ($this->state == 1) {
            return 'new';
        } else if ($this->state == 2) {
            return 'disable';
        } else if ($this->state == 3) {
            return 'active';
        }
    }

    public function recivePlace()
    {
        return $this->belongsTo(ReceivingPlace::class, 'receive_in', 'id');
    }

    public function lastLogins()
    {
        return $this->hasMany(ClientLogin::class, 'customer_id')->latest('id')->limit(10);
    }

    public function getVerificationFile()
    {
        return url('storage/customers/verifications', $this->verification_file);
    }

    public function getImage()
    {
        if ($this->img) {
            return url('storage/images/customers', $this->img);
        } else {
            return url('images/no-image-user.svg');
        }
    }

    public function getImageAvatar()
    {
        if ($this->img) {
            return url('storage/images/customers/avatar', $this->img);
        } else {
            return url('images/no-image-user.svg');
        }
    }

    public function wallet()
    {
        return $this->hasOne(CustomerWallet::class, 'customer_id', 'id');
    }

    public function branches()
    {
        return $this->belongsTo(Branch::class, 'receive_in', 'id');
    }
}
