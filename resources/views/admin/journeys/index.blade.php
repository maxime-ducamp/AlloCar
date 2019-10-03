@extends('base')

@section('content')
    <main class="mx-auto mt-10 px-4 md:mt-16">


        <h1 class="text-center text-blue pb-10">Liste des trajets</h1>


        <div class="px-10">

            <a href="{{ route('admin.dashboard') }}" class="link block py-5"> <= Retour à l'Espace d'Administration</a>

            @can('update', $journeys->first())
                @if($journeys->count() < 1)
                    <p class="text-center text-grey-darkest">Aucun trajet n'a encore été créé.</p>
                @else
                    <table class="w-full text-left">
                        <tr>
                            <th class="bg-blue p-3 text-white">Conducteur</th>
                            <th class="bg-blue p-3 text-white">Départ</th>
                            <th class="bg-blue p-3 text-white">Arrivée</th>
                            <th class="bg-blue p-3 text-white">Date Départ</th>
                            <th class="bg-blue p-3 text-white">Date Arrivée</th>
                            <th class="bg-blue p-3 text-white">Places</th>
                            <th class="bg-blue p-3 text-white">Complété</th>
                            <th class="bg-blue p-3 text-white text-center">Editer</th>
                            <th class="bg-blue p-3 text-white text-center">Supprimer</th>
                            <th class="bg-blue p-3 text-white text-center">Completer</th>
                        </tr>
                        @foreach($journeys as $journey)
                            <tr class="border-b border-grey-dark">
                                <td class="py-5">
                                    <a href="{{ route('profiles.index', ['user' => $journey->driver]) }}" class="link">
                                        {{ $journey->driver->name }}
                                    </a>
                                </td>
                                <td>{{ $journey->departure }}</td>
                                <td>{{ $journey->arrival }}</td>
                                <td>{{ ucfirst(\Jenssegers\Date\Date::parse($journey->departure_datetime)->format('Y-m-d | H:i:s')) }}</td>
                                <td>{{ ucfirst(\Jenssegers\Date\Date::parse($journey->arrival_datetime)->format('Y-m-d | H:i:s')) }}</td>
                                <td class="text-center">{{ $journey->seats }}</td>
                                <td class="text-center">{{ $journey->completed_at ? 'Oui' : 'Non' }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.journeys.edit', ['journey' => $journey]) }}" class="far fa-edit text-lg text-blue"></a>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.journeys.update', ['journey' => $journey]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="fas fa-times-circle text-lg text-red"></button>
                                    </form>
                                </td>
                                <td class="text-center">
                                    @if(!$journey->completed_at)
                                        <form action="{{ route('journeys.complete', ['journey' => $journey]) }}" method="post">
                                            @csrf
                                            <button type="submit" class="far fa-thumbs-up text-lg text-orange-dark outline-none"></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            @endcan
        </div>


        <div class="mb-10">
            {{ $journeys->links() }}
        </div>
    </main>
@endsection