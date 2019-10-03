{{--
@extends('base')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
--}}

@extends('base')

@section('content')

    <main class="mx-auto mt-10 mb-16 px-4 md:mt-16">

        <h1 class="text-blue text-center">Changement de mot de passe</h1>

        <form method="POST" action="{{ route('password.update') }}" class="md:w-1/2 md:mx-auto md:mt-10">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">


            <div>
                <label for="email" class="text-blue py-2">Email: </label>
                <input id="email" type="email" class="form-input mt-2 {{ $errors->has('email') ? 'form-input-error' : '' }}"
                       name="email" value="{{ $email ?? old('email') }}" required autofocus>
            </div>

            <div>
                <label for="password" class="text-blue py-2">Nouveau mot de passe: </label>
                <input id="password" type="password"
                       class="form-input mt-2 {{ $errors->has('password') ? 'form-input-error' : '' }}" name="password"
                       required>
            </div>

            <div>
                <label for="password-confirm" class="text-blue py-2">Confirmation du mot de passe: </label>
                <input id="password-confirm" type="password"
                       class="form-input mt-2 {{ $errors->has('password') ? 'form-input-error' : '' }}" name="password_confirmation"
                       required>
            </div>

            <div class="flex justify-end">
                <input type="submit" value="Mettre à jour" class="form-submit">
            </div>
        </form>
    </main>
@endsection
