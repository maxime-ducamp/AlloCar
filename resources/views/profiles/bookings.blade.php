@extends('base')

@section('content')

    <main class="mx-auto mt-10 px-4 md:mt-16">
        <h2 class="text-blue text-center">Mes Réservations</h2>

        <div class="mt-10 leading-normal md:w-1/2 md:mx-auto">
            @forelse($user->bookings as $booking)
                @if(!$booking->pending and $booking->approved)
                    <div class="p-5 shadow-md bg-green-lightest md:text-center">

                        <p>
                            <a href="{{ route('profiles.index', ['user' => $booking->journey->driver]) }}" class="link">
                                {{ $booking->journey->driver->name }}
                            </a>
                            a <span class="text-green-dark">accepté</span> votre demande de participer à l'un de ses trajets
                        </p>

                        <div class="flex justify-between items-center md:justify-center">
                            <a href="{{ route('journeys.show', ['journey' => $booking->journey]) }}" class="link">Voir
                                le
                                trajet</a>
                        </div>
                    </div>
                @elseif(!$booking->pending and !$booking->approved)
                    <div class="p-5 shadow-md bg-red-lightest mt-4 md:text-center">
                        <p>
                            <a href="{{ route('profiles.index', ['user' => $booking->journey->driver]) }}" class="link">
                                {{ $booking->journey->driver->name }}
                            </a>
                            a <span class="text-red-light">refusé</span> votre demande de participer à l'un de ses trajets
                        </p>
                        <div class="flex items-center justify-between md:justify-center">
                            <a href="{{ route('journeys.show', ['journey' => $booking->journey]) }}" class="link">Voir
                                le
                                trajet</a>
                        </div>
                    </div>
                @else
                    <div class="p-5 shadow-md mt-4 md:text-center">
                        <p>
                            <a href="{{ route('profiles.index', ['user' => $booking->journey->driver]) }}" class="link">
                                {{ $booking->journey->driver->name }}
                            </a>
                            n'a pas encore répondu à votre demande de participer à son trajet
                        </p>

                        <p class="mt-5">Départ: {{ $booking->journey->departure }},</p>
                        <p class="mb-5">Arrivée {{ $booking->journey->arrival }}</p>
                        <div class="flex items-center justify-between md:justify-center">
                            <a href="{{ route('journeys.show', ['journey' => $booking->journey]) }}" class="link">Voir
                                le
                                trajet</a>
                        </div>
                    </div>
                @endif
            @empty
                <p class="text-center text-grey-darker">Vous n'avez aucune réservation</p>
            @endforelse
        </div>
    </main>

@endsection
