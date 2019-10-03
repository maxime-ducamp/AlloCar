@extends('base')

@section('content')
    <main class="mx-auto mt-10 mb-16 px-4 md:mt-16">

        <h1 class="text-blue text-center mb-10 text-2xl md:text-4xl">Proposer un trajet</h1>

        <form action="{{ route('journeys.store') }}" method="post" id="form-journey" class="md:w-1/2 md:mx-auto md:mt-10">
            @csrf
            <fieldset> <!-- Start General Information Fieldset -->
                <legend class="text-blue text-2xl pb-6 text-center">Informations générales</legend>
                <div>
                    <input type="text" class="form-input" name="departure" required placeholder="Départ *"
                           id="departureInput" />
                    <div id="departureAxiosResults" class="axios-search-suggestion-container"></div>
                </div>
                <div class="mt-4">
                    <input type="text" class="form-input" name="arrival" required placeholder="Arrivée *" id="arrivalInput"/>
                    <div id="arrivalAxiosResults" class="axios-search-suggestion-container"></div>
                </div>
                <div class="mt-4">
                    <label for="seatsInput" class="text-blue">Places: *</label>
                    <select class="form-select" id="seatsInput" name="seats">
                        @for($i = 1; $i <= 8; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </fieldset> <!-- End General Information Fieldset -->

            <fieldset> <!-- Start Dates & Hours Fieldset -->
                <legend class="text-blue text-2xl py-6 mt-6 text-center">Dates & Horaires</legend>

                <div> <!-- Departure Date & Hours -->
                    <p class="p-4 bg-red-light text-white hidden my-10" id="dates-error"></p>
                    <div>
                        <label for="departureDateInput" class="text-blue">Départ: *</label>
                        <input type="date" name="departure_date" id="departureDateInput" class="form-input mt-2" required>
                    </div>
                    <div class="flex justify-between mt-4">
                        <div>
                            <label for="departure_hour" class="text-blue">Heures: </label>
                            <select name="departure_hour" id="departure_hour" class="form-select">
                                @for($i = 1; $i <= 24; $i++)
                                    @if($i < 10)
                                        <option value="0{{ $i }}">0{{ $i }}</option>
                                    @elseif($i === 12)
                                        <option value="{{ $i }}" selected>{{ $i }}</option>
                                    @else
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="departure_minutes" class="text-blue">Minutes: </label>
                            <select name="departure_minutes" id="departure_minutes" class="form-select">
                                @for($i = 0; $i <= 59; $i++)
                                    @if($i < 10)
                                        <option value="0{{ $i }}">0{{ $i }}</option>
                                    @elseif($i === 30)
                                        <option value="{{ $i }}" selected>{{ $i }}</option>
                                    @else
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>
                </div> <!-- End Departure Date & Hours -->

                <div class="mt-6"> <!-- Arrival Date & Hours -->
                    <div>
                        <label for="arrivalDateInput" class="text-blue">Arrivée: *</label>
                        <input type="date" name="arrival_date" id="arrivalDateInput" class="form-input mt-2" required>
{{--                        <p id="arrivalDateError" class="text-red"></p>--}}
                    </div>
                    <div class="flex justify-between mt-4">
                        <div>
                            <label for="arrival_hour" class="text-blue">Heures: </label>
                            <select name="arrival_hour" id="arrival_hour" class="form-select">
                                @for($i = 1; $i <= 24; $i++)
                                    @if($i < 10)
                                        <option value="0{{ $i }}">0{{ $i }}</option>
                                    @elseif ($i === 12)
<option value="{{ $i }}">{{ $i }}</option>
                                     @else
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="arrival_minutes" class="text-blue">Minutes: </label>
                            <select name="arrival_minutes" id="arrival_minutes" class="form-select">
                                @for($i = 0; $i <= 59; $i++)
                                    @if($i < 10)
                                        <option value="0{{ $i }}">0{{ $i }}</option>
                                    @elseif($i === 30)
                                        <option value="{{ $i }}" selected>{{ $i }}</option>
                                    @else
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                    </div>
                </div> <!-- End Arrival Date & Hours -->
            </fieldset> <!-- End Dates & Hours Fieldset -->

            <fieldset> <!-- Start Other Information Fieldset -->
                <legend class="text-blue text-2xl py-10 text-center">Informations complémentaires</legend>

                <div class="mt-4 flex items-center">
                    <label for="allows_pets">Acceptez-vous les animaux?</label>
                    <input type="checkbox" name="allows_pets" value="1" class="ml-5" id="allows_pets">
                </div>

                <div class="mt-4 flex items-center">
                    <label for="allows_smoking">Acceptez-vous les fumeurs?</label>
                    <input type="checkbox" name="allows_smoking" value="1" class="ml-5" id="allows_smoking">
                </div>

                <div class="mt-4 flex-col">
            <textarea name="driver_comment" id="driverCommentInput" class="form-input h-32" maxlength="300"
                      placeholder="Voulez-vous laisser un message sur ce trajet ?"></textarea>
{{--                    <p id="driverCommentError" class="text-red"></p>--}}
                </div>
            </fieldset> <!-- End Other Information Fieldset -->

            @include('includes.errors.session-errors')

            <p class="block italic my-6">Les champs marqués d'un * sont requis.</p>
<div class="flex justify-end mt-4">
            <input type="submit" class="form-submit w-full md:w-32" value="Proposer">
</div>
        </form>
    </main>
@endsection

@section('bottom_scripts')
    @include('includes.api-calls.get-towns')
{{--    @include('includes.validation.journey-form')--}}
    <script>
        let form = document.getElementById('form-journey');

        form.addEventListener('submit', validateDates);

        function validateDates(event) {
            event.preventDefault();

            const dateNow = new Date();

            const departureDate = document.getElementById('departureDateInput').value;
            let departureTime =
                document.getElementById('departure_hour').value + ':' + document.getElementById('departure_minutes').value;

            let departureDateTime = departureDate + ' ' + departureTime;
            let departureInput = new Date(departureDateTime);

            const arrivalDate = document.getElementById('arrivalDateInput').value;
            let arrivalTime =
                document.getElementById('arrival_hour').value + ':' + document.getElementById('arrival_minutes').value;

            let arrivalDateTime = arrivalDate + ' ' + arrivalTime;
            let arrivalInput = new Date(arrivalDateTime);

            if (
                arrivalInput <= departureInput.setMinutes(departureInput.getMinutes() + 10) ||
                departureInput < dateNow || arrivalInput < dateNow
            ) {
                let datesErrors = document.getElementById('dates-error');
                datesErrors.innerHTML = "Les dates de départ ou d'arrivée sont incorrectes"
                datesErrors.className = "bg-red-light p-4 text-white visible my-10 block";
                document.getElementById('departureDateInput').className = "form-input border-2 border-red-light";
                document.getElementById('arrivalDateInput').className = "form-input border-2 border-red-light";
            } else {
                form.submit();
            }

        }
    </script>
@endsection
	