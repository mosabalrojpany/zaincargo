<?php

namespace App\Mail\Prusheseorder;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mechart extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     * Set invoice data
     * @param App\Models\PurchaseOrder  $PurchaseOrder
     * @return void
     */
    public function __construct($PurchaseOrder)
    {
        $this->PurchaseOrder = $PurchaseOrder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'احالة طلب شراء جديد لك';

        return $this->view('emails.Purchaseorder.purchaseorder')
            ->subject($subject)
            ->with([
                'subject' => $subject,
                'customer' => $this->PurchaseOrder->customer2,
                'PurchaseOrder' => $this->PurchaseOrder,
            ]);
    }
}
