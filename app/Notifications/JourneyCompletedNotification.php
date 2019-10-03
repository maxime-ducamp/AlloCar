<?php

namespace App\Notifications;

use App\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class JourneyCompletedNotification extends Notification
{
    use Queueable;

    private $booking;

    /**
     * Create a new notification instance.
     *
     * @param Booking $booking
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
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
            ->subject("Vous venez de compléter un trajet !")
            ->greeting('Bonjour ' . $notifiable->name . ' ,')
            ->line("Un trajet auquel vous avez participé vient de se compléter. Vous pouvez dès à présent et si vous 
            le souhaitez donner une note au conducteur en cliquant sur le lien ci-dessous")
            ->action('Voir le trajet', url('https://uponatime.tech/trajets/' . $this->booking->journey->id .'/noter'))
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
            //
        ];
    }
}
