<?php

namespace App\Notifications\PurchaseOrders\Comments;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class UpdateComment extends Notification
{
    use Queueable;

    /**
     * The Purchase Order Comment instance.
     *
     * @var \App\Models\PurchaseOrderComment
     */
    private $comment;

    /**
     * The main id to identify the parent (main node) ID for this notification.
     * This variable to optimize performance in search on all notifications that belongs to specific paranet
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
        $this->main_id = $comment->order_id;
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
            'title' => "تم تعديل تعليق على طلب الشراء رقم <b>({$this->comment->order_id})</b> <bdi><b>{$this->comment->getShortComment()}</b></bdi>",
        ];
    }

}
