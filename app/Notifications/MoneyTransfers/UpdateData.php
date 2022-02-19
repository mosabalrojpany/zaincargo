<?php

namespace App\Notifications\MoneyTransfers;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UpdateData extends Notification
{
    use Queueable;

    /**
     * The Money Transfer instance.
     *
     * @var \App\Models\MoneyTransfer
     */
    private $transfer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transfer)
    {
        $this->transfer = $transfer;
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
            'id' => $this->transfer->id,
            'title' => "تم تحديت معلومات حوالة مالية برقم <b>({$this->transfer->id})</b>",
        ];
    }

}
