<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserCreatedNotification extends Notification
{
    use Queueable;

    private $user;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Merci pour votre confiance, " . $this->user->name)
            ->greeting('Bienvenue ' . $this->user->name)
            ->line("Vous venez de vous inscrire sur AlloCar et nous vous encourageons à lire notre FAQ pour toute question concernant l'utilisation de l'application.")
            ->line("Vous y trouverez également des informations sur comment modifier vos données personnelles (ex: modifier votre avatar...)")
            ->action('FAQ', url('https://uponatime.tech/foire-aux-questions'))
            ->salutation('Merci de nous faire confiance et restez prudent(e) sur la route ! ;)');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'notified_id' => $this->user->id,
            'notified_name' => $this->user->name,
        ];
    }
}
