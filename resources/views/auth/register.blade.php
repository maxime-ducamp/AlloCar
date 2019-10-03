@extends('base')

@section('content')

    <div class="pt-10 h-full pb-20 bg-cover bg-bottom"
         style="background-image: url('images/backgrounds/registration-page/registration-background.jpg')">
        <h1 class="text-center text-white text-lg leading-normal lg:text-3xl">Rejoignez la communauté AlloCar !</h1>
        <form action="{{ route('register') }}" method="post" class="mt-10 md:w-1/2 md:mx-auto p-10 form rounded-lg"
              id="form">
            @csrf
            <input id="name" type="text" required placeholder="Nom d'utilisateur *" name="name"
                   class="form-input">
            <input id="email" type="email" required placeholder="Email *" name="email"
                   class="form-input mt-6">
            <input id="password" type="password" required placeholder="Mot de passe *" name="password"
                   class="form-input mt-6">
            <input id="password-confirm" type="password" required placeholder="Confirmation du mot de passe *"
                   name="password_confirmation"
                   class="form-input mt-6">

            <div class="bg-red-light text-white mt-5 rounded-md" id="validation-errors"></div>

            <small class="block italic mt-6 text-white md:font-semibold md:text-grey-darkest">Les champs marqués d'un *
                sont requis.
            </small>
            <div class="mt-2 flex justify-end">
                 {!! NoCaptcha::display() !!}
            </div>
@include('includes.errors.session-errors')

            <div class="flex justify-end">
                <input type="submit" value="M'inscrire" class="form-submit">
            </div>
        </form>
    </div>
@endsection

@section('bottom_scripts')
    <script>
/*
        const form = document.getElementById('form'),
            validationErrorsContainer = document.getElementById('validation-errors');

        const formData = {
            name: {
                value: null,
                validation: "required|string|max:255"
            },
            email: {
                value: null,
                validation: "required|string|email|max:255"
            },
            password: {
                value: null,
                validation: "required|min:8"
            },
            password_confirm: {
                value: null,
                validation: "required|string|min:8"
            }
        };

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            let nameInput = document.getElementById('name'),
                emailInput = document.getElementById('email'),
                passwordInput = document.getElementById('password'),
                passwordConfirmInput = document.getElementById('password-confirm');

            formData.name.value = nameInput.value;
            formData.email.value = emailInput.value;
            formData.password.value = passwordInput;
            formData.password_confirm.value = passwordConfirmInput.value;

            const result = validator.validateForm({formData});

            if (result.errors) {
                const results = Object.entries(result.errors);
                console.log(results);

                for (let [error, message] of results) {
                    let p = document.createElement('p');
                    p.innerHTML = message;
                    p.classList.add('mt-4');
                    validationErrorsContainer.appendChild(p);
                    validationErrorsContainer.classList.add('p-5');
                    document.querySelector('[name=' + error + ']').classList.add('form-input-error');
                }

            } else {
                form.submit();
            }
        });
*/
    </script>
@endsection