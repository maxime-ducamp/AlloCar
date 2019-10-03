@extends('base')

@section('content')

    <main class="mx-auto mt-10 px-4 md:mt-16 mb-10">
        <div class="text-blue text-center py-10 mb-4">
            <h2>Modifier un trajet</h2>
        </div>

        <form action="{{ route('admin.journeys.update', ['journey' => $journey]) }}" method="post" id="form-journey" class="md:w-1/2 md:mx-auto">
            @csrf
            @method('put')
            <fieldset> <!-- Start General Information Fieldset -->
                <legend class="text-blue text-2xl pb-6 text-center">Informations générales</legend>
                <div>
                    <input type="text" class="form-input" name="departure" required  value="{{ $journey->departure }}"
                           id="departureInput"/>
                    <span id="departureError" class="text-red"></span>
                    <div id="departureAxiosResults"></div>
                </div>
                <div class="mt-4">
                    <input type="text" class="form-input" name="arrival" required value="{{ $journey->arrival }}"
                           id="arrivalInput"/>
                    <span id="arrivalError" class="text-red"></span>
                    <div id="arrivalAxiosResults"></div>
                </div>
                <div class="mt-4">
                    <label for="seatsInput" class="text-blue">Places: *</label>
                    <select class="form-select" id="seatsInput" name="seats">
                        @for($i = 1; $i <= 7; $i++)
                            @if($i === $journey->seats)
                                <option value="{{ $i }}" selected>{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                    <p id="seatsError" class="text-red"></p>
                </div>
            </fieldset> <!-- End General Information Fieldset -->

            <fieldset> <!-- Start Dates & Hours Fieldset -->
                <legend class="text-blue text-2xl py-6 mt-6 text-center">Dates & Horaires</legend>

                <div> <!-- Departure Date & Hours -->
                    <div>
                        <label for="departureDateInput" class="text-blue">Départ *</label>
                        <input type="date" name="departure_date" id="departureDateInput"
                               value="{{ ucfirst(\Jenssegers\Date\Date::parse($journey->departure_datetime)->format('Y-m-d')) }}"
                               class="form-input mt-2" required />
                    </div>
                    <div class="flex justify-between mt-4">
                        <div>
                            <label for="departure_hour" class="text-blue">Heure</label>
                            <select name="departure_hour" id="departure_hour" class="form-select">
                                @for($i = 1; $i <= 24; $i++)
                                    <option value="{{ $i < 10 ? '0' . $i : $i }}"
                                            {{ $i === (int)$journey->getHoursFor('departure') ? 'selected' : '' }}>{{ $i < 10 ? '0' . $i : $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="departure_minutes" class="text-blue">Minutes</label>
                            <select name="departure_minutes" id="departure_minutes" class="form-select">
                                @for($i = 1; $i <= 59; $i++)
                                    <option value="{{ $i < 10 ? '0' . $i : $i }}"
                                            {{ $i === (int)$journey->getMinutesFor('departure') ? 'selected' : '' }}>{{ $i < 10 ? '0' . $i : $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div> <!-- End Departure Date & Hours -->

                <div class="mt-6"> <!-- Arrival Date & Hours -->
                    <div>
                        <label for="arrivalDateInput" class="text-blue">Arrivée *</label>
                        <input type="date" name="arrival_date" id="arrivalDateInput" class="form-input mt-2" required
                               value="{{ ucfirst(\Jenssegers\Date\Date::parse($journey->arrival_datetime)->format('Y-m-d')) }}" />
                    </div>
                    <div class="flex justify-between mt-4">
                        <div>
                            <label for="arrival_hour" class="text-blue">Heure</label>
                            <select name="arrival_hour" id="arrival_hour" class="form-select">
                                @for($i = 1; $i <= 24; $i++)
                                    <option value="{{ $i < 10 ? '0' . $i : $i }}"
                                            {{ $i === (int)$journey->getHoursFor('arrival') ? 'selected' : '' }}>{{ $i < 10 ? '0' . $i : $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="arrival_minutes" class="text-blue">Minutes</label>
                            <select name="arrival_minutes" id="arrival_minutes" class="form-select">
                                @for($i = 1; $i <= 59; $i++)
                                    <option value="{{ $i < 10 ? '0' . $i : $i }}"
                                            {{ $i === (int)$journey->getMinutesFor('arrival') ? 'selected' : '' }}>{{ $i < 10 ? '0' . $i : $i }}</option>
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
                    <input type="checkbox" name="allows_pets" value="1" class="ml-5" {{ $journey->allows_pets === 1 ? 'checked' : '' }} id="allows_pets" />
                </div>

                <div class="mt-4 flex items-center">
                    <label for="allows_smoking">Acceptez-vous les fumeurs?</label>
                    <input type="checkbox" name="allows_smoking" value="1" class="ml-5" {{ $journey->allows_smoking === 1 ? 'checked' : '' }} id="allows_smoking" />
                </div>

                <div class="mt-4 flex-col">
                    <textarea name="driver_comment" id="driverCommentInput" class="form-input h-32">{{ $journey->driver_comment }}</textarea>
                    <p id="driverCommentError" class="text-red"></p>
                </div>
            </fieldset> <!-- End Other Information Fieldset -->

            <small class="block italic mt-4">Les champs marqués d'un * sont requis.</small>

            <div class="flex justify-end">
                <input type="submit" class="form-submit" value="Modifier">
            </div>
        </form>
    </main>
@endsection

@section('bottom_scripts')
    @include('includes.api-calls.get-towns')
    @include('includes.validation.journey-form')
@endsection