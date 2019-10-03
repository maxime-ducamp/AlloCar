<?php

namespace App\Notifications;

use App\Journey;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingApprovedNotification extends Notification
{
    use Queueable;

    private $journey;

    /**
     * Create a new notification instance.
     *
     * @param $journey
     */
    public function __construct(Journey $journey)
    {
        $this->journey = $journey;
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Votre participation à un trajet a été acceptée !")
            ->greeting('Bonjour ' . $notifiable->name . ' ,')
            ->line($this->journey->driver->name . " a accepté votre demande de participer à son trajet !")
            ->line("Vous pouvez retrouver ce trajet en cliquant sur le lien ci-dessous")
            ->action('Voir le trajet', url('https://uponatime.tech/trajets/' . $this->journey->id))
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
            'driver_name' => $this->journey->driver->name,
            'driver_avatar' => $this->journey->driver->avatar_path,
            'journey_id' => $this->journey->id,
            'notification_status' => 'accepté',
            'display_class' => 'text-green-dark',
        ];
    }
}
