<?php

namespace App\Notifications\Wallet;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class Deopnoti extends Notification
{
    use Queueable;
    
    /**
     * Create a new notification instance.
     *@var \App\Models\Cashdeposity
     * @return void
     */
    private $deponotifa;

    public function __construct($deponotifa)
    {
        //
        $this->deponotifa = $deponotifa;
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
            'id' => $this->deponotifa->id,
            'title' => "تم ايداع مبلغ مالي قيمته  <b>({$this->deponotifa->price}.{$this->deponotifa->currencytype->name})</b> برقم ايداع <bdi><b>{$this->deponotifa->id}</b></bdi> في فرع <b>({$this->deponotifa->branchess->city})</b> ",
        ];

    }

}
