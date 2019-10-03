<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Http\Requests\UpdateJourneyRequest;
use App\Journey;
use App\Notifications\JourneyCompletedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\CreateJourneyRequest;
use Illuminate\Support\Facades\Session;
use Jenssegers\Date\Date;

class JourneysController extends Controller
{
    /**
     * This is this application's base entry point
     */
    public function index()
    {
        return view('journeys.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Journey::class);

        return view('journeys.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateJourneyRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateJourneyRequest $request)
    {

        $data = $request->validated();


        $params = $this->createDatesFromRequest($data);


        if ($params['departure_datetime'] < $params['arrival_datetime']) {

            $journey = auth()->user()->journeys()->create($params);

            if ($journey) {
                return redirect()->route('journeys.show', compact('journey'))
                    ->with('flash', [
                        'status' => 'success',
                        'message' => 'Trajet créé avec succès !'
                    ]);
            } else {
                return redirect()->route('journeys.create')
                    ->with('flash', [
                        'status' => 'error',
                        'message' => 'Une erreur est survenue pendant la création du trajet'
                    ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Journey $journey
     * @return \Illuminate\Http\Response
     */
    public function show(Journey $journey)
    {
        $comments = $journey->comments()->paginate(10);

        return view('journeys.show', compact(['journey', 'comments']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Journey $journey
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Journey $journey)
    {
        $this->authorize('update', $journey);

        return view('journeys.edit', compact('journey'));
    }

    /**
     * Update the specified resource in storage.
     * @param UpdateJourneyRequest $request
     * @param Journey $journey
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateJourneyRequest $request, Journey $journey)
    {
        $this->authorize('update', $journey);

        $data = $request->validated();

        if ($journey->update($data)) {
            return redirect()->route('journeys.show', compact('journey'))
                ->with('flash', [
                    'status' => 'success',
                    'message' => 'Trajet modifié avec succès !'
                ]);
        } else {
            return redirect()->route('journeys.edit', compact('journey'))
                ->with('flash', [
                    'status' => 'error',
                    'message' => 'Une erreur est survenue lors de la modification du trajet'
                ]);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Journey $journey
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(Journey $journey)
    {
        $this->authorize('delete', $journey);

        if ($journey->delete()) {
            return redirect()->route('index')
                ->with('flash', [
                    'status' => 'success',
                    'message' => 'Trajet correctement supprimé'
                ]);
        } else {
            return redirect()->route('journeys.show', compact('journey'))
                ->with('flash', [
                    'status' => 'error',
                    'message' => 'Une erreur est survenue lors de la suppression du trajet'
                ]);
        }


    }

    /**
     * @param Journey $journey
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function complete(Journey $journey)
    {
        $this->authorize('update', $journey);

        $journey->markAsCompleted();

        foreach($journey->bookings as $booking) {
            $booking->user->notify(new JourneyCompletedNotification($booking));
        }

        return back();
    }

    private function createDatesFromRequest(array $data)
    {
        $split = explode('-', $data['departure_date']);

        $departure_datetime = Carbon::create($split[0], $split[1], $split[2], $data['departure_hour'], $data['departure_minutes']);
        unset($data['departure_date'], $data['departure_hour'], $data['departure_minutes']);
        $data['departure_datetime'] =  Carbon::parse($departure_datetime)->format('Y-m-d H:i:s');

        $split = explode('-', $data['arrival_date']);

        $arrival_datetime = Carbon::create($split[0], $split[1], $split[2], $data['arrival_hour'], $data['arrival_minutes']);
        unset($data['arrival_date'], $data['arrival_hour'], $data['arrival_minutes']);
        $data['arrival_datetime'] = Carbon::parse($arrival_datetime)->format('Y-m-d H:i:s');

        return $data;
    }
}
