<?php

namespace App\Policies;

use App\Journey;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class JourneyPolicy
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

    public function before($user, $ability)
    {
        if ($user->hasRole('admin') or $user->hasRole('super_admin')) {
            return true;
        }
    }

    public function create(User $user)
    {
        if (auth()->user()) {
            return true;
        }
        return false;
    }

    public function update(User $user, Journey $journey)
    {
        return auth()->id() === $journey->driver->id;
    }

    public function delete(User $user, Journey $journey)
    {
        return auth()->id() === $journey->driver->id;
    }
}
