@extends('base')

@section('content')
    <main class="mx-auto mt-10 mb-16 px-4 md:mt-16">

        <h1 class="text-blue text-center">Confirmez votre identité</h1>

        <form method="post" action="{{ route('users.destroy', ['user' => auth()->user()->name]) }}" class="md:w-1/2 md:mx-auto md:mt-10 lg:w-1/3">
            @csrf

            <div>
                <label for="email" class="text-blue py-2">Email: </label>
                <input id="email" type="email" class="form-input mt-2"
                       name="email" required autofocus>
            </div>

            <div class="mt-3">
                <label for="password" class="text-blue py-2">Mot de passe: </label>
                <input id="password" type="password"
                       class="form-input mt-2" name="password"
                       required>
            </div>

<div class="flex justify-end mt-10">{!! NoCaptcha::display() !!}</div>


            <div class="flex justify-end">
                <input type="submit" value="Supprimer mon compte" class="form-submit bg-red-light text-white">
            </div>
        </form>


    </main>

@endsection
