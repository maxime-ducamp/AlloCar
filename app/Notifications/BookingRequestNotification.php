<?php

namespace App\Notifications;

use App\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class BookingRequestNotification extends Notification
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
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
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
            ->subject("Un utilisateur a demandé à participer à l'un de vos trajets")
            ->greeting('Bonjour ' . $this->booking->journey->driver->name)
            ->line($this->booking->user->name . ' a demandé à participer à l\'un de vos trajets')
            ->line("Vous pouvez dès à présent consulter vos notifications pour décider d'accepter ou non sa requête")
            ->action('Voir votre profil', url('https://uponatime.tech/utilisateurs/' . $this->booking->journey->driver->name))
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
            'sender_id' => $this->booking->user->id,
            'sender_name' => $this->booking->user->name,
            'sender_avatar' => $this->booking->user->avatar_path,
            'journey_id' => $this->booking->journey->id,
            'booking_id' => $this->booking->id,
        ];
    }
}
