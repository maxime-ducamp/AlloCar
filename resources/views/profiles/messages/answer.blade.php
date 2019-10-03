@extends('base')


@section('content')
    <main class="mx-auto mt-10 mb-16 px-4 md:mt-16">
        <h2 class="text-blue text-center">Messagerie</h2>

        <h3 class="text-blue mt-10 md:text-center">Répondre à un message</h3>

        <form action="{{ route('private-messages.answer', ['user' => $message->receiver, 'private_message' => $message->id]) }}"
              method="post" class="mt-10 md:w-1/2 md:mx-auto">
            @csrf
            <div>
                <label for="subject" class="text-blue">Sujet: </label>
                <input
                    required
                    type="text"
                    class="form-input md:mt-4"
                    name="subject"
                    value="RE: {{ $message->subject }}"
                    id="subject" />
            </div>
            <div class="mt-6">
                <label for="body" class="text-blue">Message: </label>
                <textarea name="body" id="body" class="form-input h-32 mt-4" maxlength="300"
                          placeholder="Message *" required></textarea>
                <div class="flex justify-end">
                    <input type="submit" class="form-submit" value="Envoyer">
                </div>
            </div>
        </form>
    </main>
@endsection
