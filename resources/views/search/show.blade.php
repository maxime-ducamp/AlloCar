@extends('base')

@section('content')
    <main class="mx-auto mt-10 px-4 mb-16">
        <h2 class="text-blue text-center lg:text-2xl">Résultats de votre recherche</h2>

        @if(count($journeys) > 0)
            <div class="text-center my-6">
                <p class="lg:text-xl text-grey-darker">{{ count($journeys) }} {{ count($journeys) > 1 ? 'résultats' : 'résultat' }} pour votre recherche</p>
            </div>

            <div class="md:px-2">
                <div class="md:flex md:-mx-2 md:flex-wrap {{ $journeys->count() < 3 ? 'justify-center' : '' }}">

                    @foreach($journeys as $journey)
                        @include('includes.journeys.card')
                    @endforeach

                </div>
            </div>
            @else
            <div class="my-10">
                <p class="text-center">Désolé, nous n'avons trouvé aucun résultat pour votre recherche</p>
            </div>
        @endif

        <a href="{{ route('journeys.search.index') }}" class="button mt-10 md:w-1/3 md:mx-auto">Nouvelle recherche</a>
    </main>
@endsection
