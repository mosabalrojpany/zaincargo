<?php

namespace App\Notifications\Customers;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UpdateData extends Notification
{
    use Queueable;

    /**
     * The Customer instance.
     *
     * @var \App\Models\Customer
     */
    private $customer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
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
            'id' => $this->customer->id,
            'title' => 'تم تحديث المعلومات الخاصة بك',
        ];
    }

}
