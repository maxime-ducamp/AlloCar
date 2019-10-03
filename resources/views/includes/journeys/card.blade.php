<div class="md:w-1/2 lg:w-1/3 md:px-2 md:mt-5">

    @if (auth()->check()
    && Request::is('utilisateurs/' . '*' . '/trajets')
    && auth()->user()->id === $journey->driver->id
    && $journey->completed_at === null
    )

        <form action="{{ route('journeys.complete', ['journey' => $journey]) }}" class="w-3/5" method="post">
            @csrf
            <button type="submit" class="bg-blue px-2 py-3 text-sm text-white rounded-t-lg">Marquer comme complété</button>
        </form>
    @endif
    <a class="shadow-md py-6 mb-10 bg-white block cursor-pointer no-underline text-grey-darkest md:mb-0"
       href="{{ route('journeys.show', ['$journey' => $journey]) }}">

        <header class="text-center">

            <div class="flex justify-center items-center">
                <div class="user-avatar border-blue rounded-full bg-cover" style="background-image: url('{{ asset('storage/' . $journey->driver->avatar_path)  }}')"></div>
            </div>

            <p class="mt-2 leading-normal lg:text-l"><span
                    class="text-blue">{{ $journey->driver->name  }}</span> effectuera un
                trajet le
                <br>{{ ucfirst(\Jenssegers\Date\Date::parse($journey->departure_datetime)->format('l j F')) }}
            </p>
            <p class="text-red py-3 font-bold {{ $journey->seats > 0 && $journey->seats < 3 ? 'visible' : 'invisible' }}">Bientôt complet !</p>
        </header>

        <div class="mt-10 md:mt-3">
            <div class="flex justify-between items-center px-3">
                <div class="text-center flex-col w-1/3">
                    <p class="lg:text-l">Départ:</p>
                    <p class="lg:text-l">{{ $journey->departure }}</p>
                    <p class="mt-4 lg:text-l">{{ \Jenssegers\Date\Date::parse($journey->departure_datetime)->format('H:i') }}</p>
                </div>

                <div class="text-center">
                    {{--                                            <div>Icons made by <a href="https://www.flaticon.com/authors/dave-gandy" title="Dave Gandy">Dave Gandy</a> from <a href="https://www.flaticon.com/" 			    title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" 			    title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>--}}
                    <img src="{{ asset('images/svg/arrow-right.svg') }}" alt="" class="svg-filter-blue w-1/4 z-0">
                </div>

                <div class="text-center flex-col w-1/3">
                    <p class="lg:text-l">Arrivée:</p>
                    <p class="lg:text-l">{{ $journey->arrival }}</p>
                    <p class="mt-4 lg:text-l">{{ \Jenssegers\Date\Date::parse($journey->arrival_datetime)->format('H:i') }}</p>
                </div>
            </div>
        </div>

        <div class="mt-10 mx-auto w-5/6 px-2 py-5 flex items-center justify-between border-t lg:w-4/5">
            <div class="flex justify-between items-center">
                @if($journey->seats === 0)
                    <i class="fas fa-car text-red-light text-3xl flex-1"></i>
                @elseif($journey->seats > 0 and $journey->seats <= 2)
                    <i class="fas fa-car text-orange text-3xl flex-1"></i>
                @elseif($journey->seats > 2)
                    <i class="fas fa-car text-green text-3xl flex-1"></i>
                @endif
            </div>
            <div class="flex justify-between items-center">
                <i class="fas fa-paw text-{{ $journey->allows_pets ? 'green ' : 'red-light' }} text-3xl flex-1"></i>
            </div>
            <div class="flex justify-between items-center">
                <i class="fas fa-smoking-ban text-{{ $journey->allows_smoking ? 'green ' : 'red-light' }} text-3xl flex-1"></i>
            </div>
        </div>
    </a>
</div>
