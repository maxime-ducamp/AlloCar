<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function destroy(Request $request, User $user)
    {

        if ($request->notification_id) {

            if ($request->notification_id) {
                $notification = $user->notifications()->find($request->notification_id);

                $this->authorize('destroy', $notification);

                if ($notification) {
                    $notification->markAsRead();
                    return redirect()->route('profiles.index', compact('user'));
                }
            }
        }
    }
}
