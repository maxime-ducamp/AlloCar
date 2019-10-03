<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function destroy(User $user, DatabaseNotification $notification)
    {
        if (auth()->check() && auth()->user()->id === $notification->notifiable_id) {
            return true;
        }
        return false;
    }
}
