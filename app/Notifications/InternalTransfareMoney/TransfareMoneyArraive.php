<?php

namespace App\Notifications\InternalTransfareMoney;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransfareMoneyArraive extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $transfaremoneynotfi;
    public function __construct($transfaremoneynotfi)
    {
        //
        $this->transfaremoneynotfi = $transfaremoneynotfi;
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
            'id' => $this->transfaremoneynotfi->id,
            'title' => "تم تحويل مبلغ مالي اليك قيمته  <b>({$this->transfaremoneynotfi->price}.{$this->transfaremoneynotfi->currencytype->name})</b> برقم حوالة <bdi><b>{$this->transfaremoneynotfi->id}</b></bdi> في فرع <b>({$this->transfaremoneynotfi->branche2->city})</b> من رقم عضوية <b>({$this->transfaremoneynotfi->from_customer})</b> ",
        ];

    }
}
