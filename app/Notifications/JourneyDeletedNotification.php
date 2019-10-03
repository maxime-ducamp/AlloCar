<?php

namespace App\Notifications;

use App\Journey;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class JourneyDeletedNotification extends Notification
{
    use Queueable;

    private $journey;

    /**
     * Create a new notification instance.
     *
     * @return void
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
            ->subject("Un trajet pour lequel vous aviez réservé a été annulé")
            ->greeting('Bonjour ' . $notifiable->name . ' ,')
            ->line($this->journey->driver->name . " a annulé un trajet pour lequel vous aviez réservé")
            ->line("Ce trajet était au départ de: " . $this->journey->departure . " et était prévu pour le " . ucfirst(\Jenssegers\Date\Date::parse($this->journey->departure_datetime)->format('l j F')))
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
            'journey_departure' => $this->journey->departure,
            'journey_arrival' => $this->journey->arrival,
            'journey_departure_datetime' => $this->journey->departure_datetime,
            'driver_name' => $this->journey->driver->name,
            'driver_avatar' => $this->journey->driver->avatar_path,
            'driver_id' => $this->journey->driver->id,
        ];
    }
}
