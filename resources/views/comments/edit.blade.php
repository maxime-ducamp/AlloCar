@extends('base')

@section('content')
    <main class="mx-auto mt-10 mb-16 px-4 md:mt-16">
        <h2 class="text-blue text-center">Modifier votre commentaire</h2>

        @can('update', $comment)
            <form action="{{ route('comments.update', ['journey' => $journey, 'comment' => $comment]) }}" method="post"
                  class="mt-10 md:w-1/2 md:mx-auto">
                @csrf
                @method('put')
                <textarea name="body" id="bodyInput" class="form-input h-32">{{ $comment->body }}</textarea>
                <p id="bodyError" class="text-red"></p>
                <div class="flex justify-end">
                    <input type="submit" class="form-submit" value="Modifier">
                </div>
            </form>
        @endcan
    </main>

@endsection
