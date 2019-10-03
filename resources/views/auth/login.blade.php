@extends('base')

@section('content')

<div class="pt-10 h-full pb-20 bg-cover bg-bottom"
     style="background-image: url('images/backgrounds/registration-page/registration-background.jpg')">
    <h1 class="text-center text-white text-lg leading-normal lg:text-3xl">Connectez-vous !</h1>
    <form action="{{ route('login') }}" method="post" class="mt-10 md:w-1/2 md:mx-auto p-10 form rounded-lg"
          id="login-form">
        @csrf
        <input id="email" type="email" required placeholder="Email *" name="email"
               class="form-input mt-6">
        <input id="password" type="password" required placeholder="Mot de passe *" name="password"
               class="form-input mt-6">

        <div class="bg-red-light text-white mt-5 rounded-md" id="validation-errors"></div>

        <a href="{{ route('password.request') }}" class="text-white cursor-pointer no-underline">Mot de passe oublié ?</a>
        
        @include('includes.errors.session-errors')

        <small class="block italic mt-6 md:font-semibold md:text-grey-darkest">Les champs marqués d'un *
            sont requis.
        </small>
        <div class="flex justify-end">
            <input type="submit" value="Me connecter" class="form-submit">
        </div>
    </form>
</div>
@endsection

{{--@section('bottom_scripts')--}}
{{--    <script>--}}
{{--        const form = document.getElementById('login-form'),--}}
{{--            validationErrorsContainer = document.getElementById('validation-errors');--}}

{{--        const formData = {--}}
{{--            email: {--}}
{{--                value: null,--}}
{{--                validation: "required|string|email|max:255"--}}
{{--            },--}}
{{--            password: {--}}
{{--                value: null,--}}
{{--                validation: "required|string|min:8"--}}
{{--            }--}}
{{--        };--}}

{{--        form.addEventListener('submit', function (e) {--}}
{{--            e.preventDefault();--}}

{{--            let emailInput = document.getElementById('email'),--}}
{{--                passwordInput = document.getElementById('password');--}}

{{--            formData.email = emailInput.value;--}}
{{--            formData.password = passwordInput.value;--}}

{{--            const result = validator.validateForm({formData});--}}

{{--            if (result.errors) {--}}

{{--                validationErrorsContainer.classList.add('p-5');--}}
{{--                document.getElementById('comment-form-submit').addEventListener('click', function () {--}}
{{--                    validationErrorsContainer.innerHTML = '';--}}
{{--                    validationErrorsContainer.classList.remove('form-input-error');--}}
{{--                    validationErrorsContainer.classList.remove('p-5');--}}
{{--                });--}}

{{--                if (result.errors.email) {--}}

{{--                    let p = document.createElement('p');--}}
{{--                    p.innerHTML = "Veuillez entrer une adresse e-mail valide";--}}
{{--                    validationErrorsContainer.appendChild(p);--}}
{{--                    document.querySelector('[name=email]').classList.add('form-input-error');--}}

{{--                }--}}

{{--                if (result.errors.password) {--}}
{{--                    let p = document.createElement('p');--}}
{{--                    p.innerHTML = "Le mot de passe doit contenir au moins 8 caractères";--}}
{{--                    validationErrorsContainer.appendChild(p);--}}
{{--                    document.querySelector('[name=password]').classList.add('form-input-error');--}}
{{--                    document.getElementById('comment-form-submit').addEventListener('click', function () {--}}
{{--                        validationErrorsContainer.innerHTML = '';--}}
{{--                        validationErrorsContainer.classList.remove('form-input-error');--}}
{{--                        validationErrorsContainer.classList.remove('p-5');--}}
{{--                    });--}}

{{--                }--}}
{{--            } else {--}}
{{--                document.querySelector('#login-form input').classList.remove('form-input-error');--}}
{{--                form.submit();--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}
