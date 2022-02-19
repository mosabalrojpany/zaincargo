<?php

namespace App\Notifications\ShippingAddresses;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewAddress extends Notification
{
    use Queueable;

    /**
     * The Shipping Address instance.
     *
     * @var \App\Models\ShippingAddress
     */
    private $address;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($address)
    {
        $this->address = $address;
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
            'id' => $this->address->id,
            'title' => "تم إضافة عنوان شحن جديد باسم <bdi><b>{$this->address->name}</b></bdi>",
        ];
    }

}
