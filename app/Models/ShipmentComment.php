<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentComment extends Model
{
    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d g:ia',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shipment()
    {
        return $this->belongsTo(ShippingInvoice::class, 'shipment_id', 'id');
    }

    public function getShortComment($length = 40)
    {
        if (mb_strlen($this->comment) > $length) {
            return mb_substr($this->comment, 0, $length) . '...';
        }
        return $this->comment;
    }

    public function getCommenter()
    {
        if ($this->customer_id) {
            return $this->customer->code . '-' . $this->customer->name;
        }
        return $this->user->name;
    }

    public function getCommenterForCustomerSide()
    {
        if ($this->customer_id) {
            return 'أنت';
        }
        return config('app.name');
    }

    public function getImageForCustomerSide()
    {
        if ($this->customer_id) {
            return authClient()->user()->getImageAvatar();
        }
        return url('images/no-image-user.svg');
    }

    public function getImage()
    {
        if ($this->customer_id) {
            return $this->customer->getImageAvatar();
        }
        return url('images/no-image-user.svg');
    }

    public function getState()
    {
        return trans("shipmentComments.status.$this->unread");
    }

    /**
     * Check if user can edit content of comment
     */
    public function userCanEditComment()
    {
        return $this->user_id != null;
    }

    /**
     * Check if customer can edit content of comment
     */
    public function customerCanEditComment()
    {
        return $this->customer_id === authClient()->user()->id;
    }

    public function created_at()
    {
        return $this->created_at->format('Y-m-d g:ia');
    }
}
