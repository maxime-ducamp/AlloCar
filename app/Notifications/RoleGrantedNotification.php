<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RoleGrantedNotification extends Notification
{
    use Queueable;

    /**
     * @var User
     */
    protected $super_admin;

    /**
     * @var string
     */
    protected $role;

    /**
     * Create a new notification instance.
     *
     * @param User $super_admin
     * @param string $role
     */
    public function __construct(User $super_admin, string $role)
    {
        $this->super_admin = $super_admin;

        switch($role) {
            case 'moderator':
                $this->role = 'Modérateur';
                break;
            case 'admin':
                $this->role = 'Administrateur';
                break;
            case 'super_admin':
                $this->role = 'Super Administrateur';
                break;
        }
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
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'super_admin' => $this->super_admin,
            'action' => 'add',
            'role' => $this->role,
            'user' => $notifiable,
        ];
    }
}
