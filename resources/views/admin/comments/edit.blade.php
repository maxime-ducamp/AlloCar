@extends('base')

@section('content')
    <main class="mx-auto mt-10 mb-16 px-4 md:mt-16">
        <h2 class="text-blue text-center">Modifier un commentaire</h2>

        @can('update', $comment)
            <form action="{{ route('admin.comments.update', ['comment' => $comment]) }}" method="post"
                  class="mt-10 md:w-1/2 md:mx-auto">
                @csrf
                @method('put')
                <textarea name="body" id="bodyInput" class="form-input h-32 leading-normal">{{ $comment->body }}</textarea>
                <div class="flex justify-end">
                    <input type="submit" class="form-submit" value="Modifier">
                </div>
            </form>
        @endcan
    </main>

@endsection