<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Notifications\JourneyDeletedNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('manage', $user);

        $data = $request->validated();

        if ($request->file('user_avatar')) {

            $previous_avatar = $user->avatar_path;

            if ($previous_avatar !== 'user_uploads/avatars/default-avatar.png') {
                Storage::delete('/public/' . $previous_avatar);
            }

            $avatar_path = $request->file('user_avatar')->store('user_uploads/avatars', 'public');

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'avatar_path' => $avatar_path
            ]);
        } else {
            $user->update($request->only(['name', 'email']));
        }

        $notifications = auth()->check() ? auth()->user()->unreadNotifications()->get() : null;

        auth()->setUser($user->fresh());

        return redirect()->route('profiles.index', ['user' => auth()->user()])
            ->with('flash', [
                'status' => 'success',
                'message' => 'Profil correctement mis à jour'
            ]);
    }

    public function showDeleteAccountForm(User $user)
    {
        $this->authorize('manage', $user);

        return view('profiles.delete-account-form');
    }

    public function destroy(Request $request, User $user)
    {
        $this->authorize('destroy', $user);


        $verified = $this->checkCredentials($request, $user);

        if ($verified ) {
            $previous_avatar = $user->avatar_path;

            if ($previous_avatar !== 'user_uploads/avatars/default-avatar.png') {
                Storage::delete('/public/' . $previous_avatar);
            }

            foreach($user->journeys as $journey) {
                foreach($journey->bookings as $booking) {
                    $booking->user->notify(new JourneyDeletedNotification($booking->journey));
                }
            }

            $user->delete();

            return redirect()->route('index')
                ->with('flash', [
                    'status' => 'success',
                    'message' => 'Compte utilisateur supprimé'
                ]);
        } else {
            return redirect()->route('index');

        }
    }

    private function checkCredentials(Request $request, User $user)
    {
        $test = $request->validate([
'g-recaptcha-response' => 'required|captcha'
]);

        $email = $request->email === auth()->user()->email;
        $password = Hash::check($request->password, auth()->user()->password);

        if ($email and $password and $test) {
            return true;
        }

        return false;
    }
}
