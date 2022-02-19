<?php

namespace App\Notifications\Shipments;

use App\Mail\Shipments\Arrived as ArrivedMail;
use Illuminate\Bus\Queueable;
#use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Arrived extends Notification#implements ShouldQueue

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
        return (new ArrivedMail($this->shipment))->to($this->shipment->customer->email);
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
            'title' => "الشحنة رقم <b>({$this->shipment->id})</b> وصلت , الرجاء قراءة وصف الحالة في المنظومة",
        ];
    }

}
