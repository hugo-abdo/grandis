<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as BaseNotification;

class Notification extends BaseNotification
{
    use Queueable;

    public $message;
    public $data;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $data = null)
    {
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->data();
    }
    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {

        return new BroadcastMessage(
            array_merge(
                $this->data(),
                ['id' => $this->id]
            )
        );
    }

    public function data()
    {
        return [
            'message' => $this->message,
            'created_at' => Carbon::make(now())->diffForHumans(),
            'user' => auth()->user()->only(['id', 'name', 'profile_photo_url']),
            'data' => $this->data,
        ];
    }
}
