@extends('base')

@section('content')
    <main class="mx-auto my-10 px-4">
        <h2 class="text-blue text-center">Trouver un trajet</h2>

        <form action="{{ route('journeys.search.show') }}" method="post" id="form-journey" class="mt-10 md:w-1/2 md:mx-auto">
            @csrf
            <fieldset>
                <div>
                    <input type="text" class="form-input" name="departure" placeholder="Départ"
                           id="departureInput" />
                    <span id="departureError" class="text-red"></span>
                    <div id="departureAxiosResults" class="axios-search-suggestion-container"></div>
                </div>
                <div class="mt-4">
                    <input type="text" class="form-input" name="arrival" placeholder="Arrivée" id="arrivalInput"/>
                    <span id="arrivalError" class="text-red"></span>
                    <div id="arrivalAxiosResults" class="axios-search-suggestion-container"></div>
                </div>
            </fieldset>

            <div class="flex justify-end mt-6">
                <input type="submit" class="form-submit" value="Rechercher" />
            </div>
        </form>
    </main>
@endsection

@section('bottom_scripts')
    @include('includes.api-calls.get-towns')
@endsection
