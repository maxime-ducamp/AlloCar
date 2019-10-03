<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Request;

class UserPolicy
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

    public function manage(User $auth, User $user)
    {
        if (auth()->check() && auth()->user()->id === $user->id) {
            return true;
        }
        return false;
    }

    public function destroy(User $auth, User $user)
    {
        return auth()->check() && auth()->user()->id == $user->id;
    }

    public function adminManage(User $auth, User $user)
    {
        return $auth->hasRole('super_admin') or $auth->hasRole('admin');
    }

    public function superAdminManage(User $auth, User $user)
    {
        return $auth->hasRole('super_admin');
    }
}
