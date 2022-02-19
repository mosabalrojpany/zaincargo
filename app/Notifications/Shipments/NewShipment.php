<?php

namespace App\Notifications\Shipments;

use App\Mail\Shipments\Receive;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewShipment extends Notification implements ShouldQueue
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
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new Receive($this->shipment))->to($this->shipment->customer->email);
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
            'title' => "تم استلام شحنة جديدة لك بالرقم <b>({$this->shipment->id})</b>",
        ];
    }

}
