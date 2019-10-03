<?php

namespace App\Http\Controllers;

use App\User;
use Proengsoft\JsValidation\Facades\JsValidatorFacade;
use Proengsoft\JsValidation\JsValidationServiceProvider;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        $notifications = auth()->check() ? auth()->user()->unreadNotifications ()->get() : null;

        return view('profiles.index', compact(['user', 'notifications']));
    }


    public function journeys(User $user)
    {
        $journeys = $user->journeys()
            ->where('completed_at', '=', null)
            ->get();

        return view('profiles.journeys', compact(['journeys', 'user']));
    }

    public function bookings(User $user)
    {
        $this->authorize('manage', $user);

        return view('profiles.bookings', compact('user'));
    }
}
