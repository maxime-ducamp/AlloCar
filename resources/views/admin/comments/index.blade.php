@extends('base')

@section('content')
    <main class="mx-auto mt-10 px-4 md:mt-16">


        <h1 class="text-center text-blue pb-10">Liste des commentaires</h1>


        <div class="px-10">

            <a href="{{ route('admin.dashboard') }}" class="link block py-5"> <= Retour à l'Espace d'Administration</a>

            @can('update', $comments->first())
                @if($comments->count() < 1)
                    <p class="text-center text-grey-darkest">Personne n'a encore commenté.</p>
                @else
                    <table class="w-full text-left">
                        <tr>
                            <th class="bg-blue p-3 text-white">Utilisateur</th>
                            <th class="bg-blue p-3 text-white">Trajet</th>
                            <th class="bg-blue p-3 text-white">Contenu</th>
                            <th class="bg-blue p-3 text-white text-center">Editer</th>
                            <th class="bg-blue p-3 text-white text-center">Supprimer</th>
                        </tr>
                        @foreach($comments as $comment)
                            <tr class="border-b border-grey-light">
                                <td class="py-5">
                                    <a href="{{ route('profiles.index', ['user' => $comment->user]) }}" class="link">
                                        {{ $comment->user->name }}
                                    </a>
                                </td>
                                <td class="text-center"><a href="{{ route('journeys.show', ['journey' => $comment->journey]) }}" class="link">
                                        {{ $comment->journey->id }}
                                    </a>
                                </td>
                                <td class="leading-normal text-grey-darkest">{{ $comment->body}}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.comments.edit', ['comment' => $comment]) }}" class="far fa-edit text-lg text-blue"></a>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('admin.comments.update', ['comment' => $comment]) }}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="fas fa-times-circle text-lg text-red"></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            @endcan
        </div>


        <div class="mb-10">
            {{ $comments->links() }}
        </div>
    </main>
@endsection