<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

//use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $connection = 'redis';

    protected User $user;

    protected string $title, $text;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     * @param string $title
     * @param string $text
     */
    public function __construct(User $user, string $title, string $text)
    {
        $this->user = $user;
        $this->title = $title;
        $this->text = $text;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via(): array
    {
        return [
//            'mail',
            'database'
        ];
    }

//    /**
//     * Get the mail representation of the notification.
//     *
//     * @param  mixed  $notifiable
//     * @return MailMessage
//     */
//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', url('/'))
//                    ->line('Thank you for using our application!');
//    }

//    /**
//     * Get the array representation of the notification.
//     *
//     * @param  mixed  $notifiable
//     * @return array
//     */
//    public function toArray($notifiable)
//    {
//        return [
//            //
//        ];
//    }

    /**
     * @return array
     */
    public function toDatabase(): array
    {
        return [
            'user_id' => $this->user->id,
            'title' => $this->title,
            'text' => $this->text

        ];
    }
}
