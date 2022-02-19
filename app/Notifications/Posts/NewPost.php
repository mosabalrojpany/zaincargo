<?php

namespace App\Notifications\Posts;

use Illuminate\Bus\Queueable;
/* use Illuminate\Contracts\Queue\ShouldQueue; */
use Illuminate\Notifications\Notification;

class NewPost extends Notification/* implements ShouldQueue */
{
    use Queueable;

    private $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
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
            'id' => $this->post->id,
            'title' => " تم إضافة إعلان جديد بعنوان <bdi><b>{$this->post->getShortTitle()}</b></bdi>",
        ];
    }

}
