<?php

namespace App\Notifications;

use App\PrivateMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PrivateMessageReceivedNotification extends Notification
{
    use Queueable;

    private $private_message;

    /**
     * Create a new notification instance.
     *
     * @param PrivateMessage $private_message
     */
    public function __construct(PrivateMessage $private_message)
    {
        $this->private_message = $private_message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
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
            ->subject("Vous avez reçu un message privé !")
            ->greeting('Bonjour ' . $notifiable->name . ' ,')
            ->line($this->private_message->sender->name . " vous a envoyé un message privé !")
            ->line("Vous pouvez retrouver ce message en vous rendant sur votre profil")
            ->action('Votre Profil', url('https://uponatime.tech/utilisateurs/' . $notifiable->name))
            ->salutation('Merci de nous faire confiance et restez prudent(e) sur la route ! ;)');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'notifiable_name' => $notifiable->name,
            'sender_name' => $this->private_message->sender->name,
            'notifiable_id' => $notifiable->id,
            'subject' => $this->private_message->subject,
            'body' => $this->private_message->body,
        ];
    }
}
