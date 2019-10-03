@extends('base')

@section('content')
    <main class="mx-auto mt-10 mb-16 px-4 md:mt-16">

    @if(count($journeys) < 1)
            <h2 class="text-blue text-center mb-10">Aucun trajet pour {{ $user->name }}</h2>
        @elseif(count($journeys) === 1)
            <h2 class="text-blue text-center mb-10">1 trajet pour {{ $user->name }}</h2>
        @else
            <h2 class="text-blue text-center mb-10">{{ count($journeys) }} trajets pour {{ $user->name }}</h2>
        @endif

        @if(count($journeys) > 0)
            <div class="md:px-2">
                <div class="md:flex md:-mx-2 md:flex-wrap {{ $journeys->count() < 3 ? 'justify-center' : '' }}">
                @forelse($journeys as $journey)
                    @include('includes.journeys.card')
                @empty
                        <div class="my-10">
                            <p class="text-center">Désolé, nous n'avons trouvé aucun résultat pour votre recherche</p>
                        </div>
                @endforelse
                </div>
            </div>
        @endif
    </main>
@endsection
