<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Journey;
use Symfony\Component\HttpFoundation\Request;

class BookingsController extends Controller
{
    public function store(Journey $journey)
    {
        if (auth()->user() !== $journey->driver) {
            auth()->user()->bookings()->firstOrCreate(['journey_id' => $journey->id]);
        }

        return redirect()->route('journeys.show', compact('journey'))
            ->with('flash', [
                'status' => 'success',
                'message' => 'Votre demande a été envoyée'
            ]);
    }

    public function approve(Request $request, Journey $journey, Booking $booking)
    {
        if ($request->notification_id) {
            $notification = auth()->user()->notifications()->find($request->notification_id);
            if ($notification) {
                $notification->markAsRead();
            }
        }

        if ($journey->approveBooking($booking)) {
            return back()->with('flash', [
                'status' => 'success',
                'message' => 'Réservation acceptée',
            ]);
        }

        return back()->with('flash', [
            'status' => 'error',
            'message' => 'Une erreur est survenue lors de la création de votre réservation.'
        ]);

    }

    public function deny(Request $request, Journey $journey, Booking $booking)
    {
        if ($request->notification_id) {
            $notification = auth()->user()->notifications()->find($request->notification_id);
            if ($notification) {
                $notification->markAsRead();
            }
        }

        $journey->denyBooking($booking);

        return back();
    }
}
