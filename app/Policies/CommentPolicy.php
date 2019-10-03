<?php

namespace App\Policies;

use App\Comment;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
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
        if ($user->hasRole('moderator') or $user->hasRole('admin') or $user->hasRole('super_admin')) {
            return true;
        }
    }

    public function update(User $user, Comment $comment)
    {
        return auth()->user()->id === $comment->user->id;
    }

    public function destroy(User $user, Comment $comment)
    {
        return auth()->user()->id === $comment->user->id;
    }

}
