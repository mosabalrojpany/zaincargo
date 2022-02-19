<?php

namespace App\Notifications\Shipments\Comments;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UpdateComment extends Notification
{
    use Queueable;

    /**
     * The Shipment Comment instance.
     *
     * @var \App\Models\ShipmentComment
     */
    private $comment;

    /**
     * The main id to identify the parent (main node) ID for this notification.
     * This variable to optimize performance in search on all notifications that belongs to specif
     *
     * @var integer
     */
    public $main_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
        $this->main_id = $comment->shipment_id;
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
            'id' => $this->comment->id,
            'title' => "تم تعديل تعليق على الشحنة رقم <b>({$this->comment->shipment_id})</b> <bdi><b>{$this->comment->getShortComment()}</b></bdi>",
        ];
    }

}
