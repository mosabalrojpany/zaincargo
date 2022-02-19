<?php

namespace App\Notifications\InternalTransfareMoney;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransfareMoneyCancel extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $transfaremoneycancelnotfi;
    public function __construct($transfaremoneycancelnotfi)
    {
         //
         $this->transfaremoneycancelnotfi = $transfaremoneycancelnotfi;
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
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->transfaremoneycancelnotfi->id,
            'title' => "تم رفض الحوالة رقم <b>({$this->transfaremoneycancelnotfi->id}</b> السبب<b>({$this->transfaremoneycancelnotfi->note})</b>",
        ];

    }
}
