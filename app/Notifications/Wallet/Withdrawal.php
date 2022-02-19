<?php

namespace App\Notifications\Wallet;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class Withdrawal extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @var \App\Models\Cashdeposity
     * @return void
     */
    private $newWithdrawal;
    public function __construct($newWithdrawal)
    {
        $this->newWithdrawal = $newWithdrawal;
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
            'id' => $this->newWithdrawal->id,
            'title' => "تم سحب مبلغ مالي قيمته  <b>({$this->newWithdrawal->price}.{$this->newWithdrawal->currencytype->name})</b> برقم سحب <bdi><b>{$this->newWithdrawal->id}</b></bdi> من فرع <b>({$this->newWithdrawal->branchess->city})</b> ",
        ];

    }
}
