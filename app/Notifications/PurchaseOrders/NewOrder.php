<?php

namespace App\Notifications\PurchaseOrders;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrder extends Notification
{
    use Queueable;

    /**
     * The Purchase Order instance.
     *
     * @var \App\Models\PurchaseOrder
     */
    private $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
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
            'id' => $this->order->id,
            'title' => "تم إضافة طلب شراء لحسابك برقم <b>({$this->order->id})</b>",
        ];
    }

}
