<?php

namespace App\Http\Controllers;

use App\Journey;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class JourneySearchController extends Controller
{
    public function index()
    {
        return view('search.index');
    }

    public function show(Request $request)
    {
        $request->validate([
            'departure' => 'nullable|string|max:30',
            'arrival' => 'nullable|string|max:30'
        ]);

        $departure = $request->departure ? $request->departure : null;
        $arrival = $request->arrival ? $request->arrival : null;

        $journeys = Journey::query()
            ->where(function ($query) use ($departure) {
                if ($departure !== null) {
                    $query->where('departure', 'like', "%{$departure}%");
                }
            })
            ->where(function ($query) use ($arrival) {
                if ($arrival !== null) {
                    $query->where('arrival', 'like', "%{$arrival}%");
                }
            })
            ->where('seats', '>', 0)
            ->orderBy('departure_datetime', "asc")
            ->get();

        return view('search.show', compact('journeys'));
    }
}
