<?php

namespace App\Notifications\Customers;

use App\Mail\Customers\UpdatePassword as UpdatePasswordMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdatePassword extends Notification implements ShouldQueue
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
        return (new UpdatePasswordMail($this->customer))->to($this->customer->email);
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
            'title' => 'تم تحديث كلمة المرور الخاصة بك',
        ];
    }

}
