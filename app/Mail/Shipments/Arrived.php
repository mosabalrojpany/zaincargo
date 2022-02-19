<?php

namespace App\Mail\Shipments;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Arrived extends Mailable
{
    use Queueable, SerializesModels;

    protected $shipment;

    /**
     * Create a new message instance.
     *
     * @param App\Models\ShippingInvoice $shipment
     *
     * @return void
     */
    public function __construct($shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'تنبية لديك شحنة وصلت';

        return $this->view('emails.shipment.arrived')
            ->subject($subject)
            ->with([
                'subject' => $subject,
                'customer' => $this->shipment->customer,
                'shipment' => $this->shipment,
            ]);
    }
}
