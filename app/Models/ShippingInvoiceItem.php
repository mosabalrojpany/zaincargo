<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingInvoiceItem extends Model
{
    public $timestamps = false;

    public function invoice()
    {
        return $this->belongsTo(ShippingInvoice::class, 'invoice_id', 'id');
    }

    public function getImage()
    {
        return url('storage/images/shipping-invoices-items', $this->img);
    }

    public function getImageAvatar()
    {
        return url('storage/images/shipping-invoices-items/avatar', $this->img);
    }
}
