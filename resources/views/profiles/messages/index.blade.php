@extends('base')

@section('content')
    <main class="mx-auto mt-10 mb-16 px-4 md:mt-16 md:w-1/2 md:mx-auto">
        <h2 class="text-blue text-center">Messagerie</h2>

        <section class="px-6 mt-10 md:mt-24">
            <h3 class="text-blue pb-5">Messages reçus</h3>
            @forelse($received as $message)
                <div class="flex-col mb-5 border-b border-grey-light leading-normal">
                    <p class="flex-1 mb-3">De:
                        <a href="{{ route('profiles.index', ['user' => $message->sender->name]) }}" class="link">
                            {{ $message->sender->name }}
                        </a>
                    </p>
                    <p class="flex-1 mb-3">Sujet: {{ $message->subject }}</p>
                    <p class="flex-1 mb-3">Message: {{ $message->body }}</p>
                    <div>
                        <a href="{{ route('private-messages.answer' , ['user' => auth()->user(), 'private_message' => $message->id]) }}" class="link">Répondre</a>
                        <form action="{{ route('private-messages.markAsRead', [
                            'user' => $message->receiver,
                            'private_message' => $message
                        ]) }}" method="post" class="mb-5">
                            @csrf
                            <input type="submit" class="text-blue no-underline cursor-pointer bg-transparent p-0"
                                   value="Marquer comme lu"/>
                        </form>
                    </div>
                </div>
            @empty
                <p class="">Vous n'avez pas de nouveaux messages</p>
            @endforelse
        </section>

        <section class="px-6 mt-5">
            <h3 class="text-blue pb-5">Messages envoyés</h3>
            @forelse($sent as $message)
                <div class="flex-col mb-5 border-b border-grey-light leading-normal">
                    <p class="flex-1 mb-3">A:
                        <a href="{{ route('profiles.index', ['user' => $message->receiver->name]) }}" class="link">
                            {{ $message->receiver->name }}
                        </a>
                    </p>
                    <p class="flex-1 mb-3">Sujet: {{ $message->subject }}</p>
                    <p class="flex-1 mb-3">Message: {{ $message->body }}</p>
                </div>
            @empty
                <p class="pb-5">Vous n'avez pas encore envoyé de message</p>
            @endforelse
        </section>
    </main>

@endsection
