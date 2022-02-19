<?php

namespace App\Notifications\Shipments;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UpdateData extends Notification
{
    use Queueable;

    /**
     * The Shipping Invoice (Shipment) instance.
     *
     * @var \App\Models\ShippingInvoice
     */
    private $shipment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->shipment->id,
            'title' => "تم تحديث معلومات شحنة بالرقم <b>({$this->shipment->id})</b>",
        ];
    }

}
