@extends('base')

@section('stylesheets')
    <style>

        .parallax {
            /* The image used */
            background-image: url("../images/backgrounds/index-parallax/car-country.jpg");

            /* Full height */
            height: 80vh;

            /* Create the parallax scrolling effect */
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
@endsection

@section('content')
    <div>
        <div class="h-full">
            <div class="parallax flex justify-center items-center">
                <div class="flex-col items-center justify-center px-3">
                    <h1 class="text-white text-4xl text-center tracking-wide mb-16">Bienvenue sur AlloCar !</h1>
                    <a href="{{ route('journeys.search.index') }}" class="button">Trouver un trajet</a>
                </div>
            </div>
        </div>

        <main class="mx-auto mt-10 px-4">

            <div class="text-center mb-10">

                <div class="mt-12">
                    <p class="italic text-center text-blue md:mb-10 md:text-lg leading-normal">Comment ça marche ?</p>
                    <div class="flex mb-4 flex-wrap md:flex-row md:w-4/5 md:mx-auto">
                        <p class="flex mt-6 w-full md:flex-col md:items-center md:justify-center md:w-1/2">
                            <i class="fas fa-map-marked-alt text-3xl text-blue-light flex-1 md:border-2 md:rounded-full md:border-blue-light md:p-5 md:mb-6 md:text-5xl"></i>
                            <span class="text-grey-darker flex-1 text-left md:text-center md:text-xl md:leading-normal">Proposez des trajets à la communauté !</span>
                        </p>

                        <p class="flex mt-6 w-full md:flex-col md:items-center md:justify-center md:w-1/2">
                            <i class="fas fa-comments text-3xl text-blue-light flex-1 md:border-2 md:rounded-full md:border-blue-light md:p-5 md:mb-6 md:text-5xl "></i>
                            <span class="text-grey-darker flex-1 text-left md:text-center md:text-xl">Planifiez avec les conducteurs</span>
                        </p>
                        <p class="flex mt-6 w-full md:flex-col md:items-center md:justify-center md:w-full md:mt-16">
                            <i class="fas fa-car text-3xl text-blue-light flex-1 md:border-2 md:rounded-full md:border-blue-light md:p-5 md:mb-6 md:text-5xl"></i>
                            <span class="text-grey-darker flex-1 text-left md:text-center md:text-xl">Retrouvez-vous sur la route</span>
                        </p>
                    </div>

                    <a class="italic text-center text-blue mt-6 block no-underline md:mt-10 md:text-lg md:w-1/2 md:p-5 md:mx-auto" href="{{ route('faq') }}">Lire notre FAQ</a>
                </div>
            </div>
        </main>
        <div class="parallax h-32 flex items-center justify-center">
            <div class="w-full md:w-1/2 md:mx-auto px-4">
                @Auth
                    <a href="{{ route('journeys.create') }}" class="button mt-4">Proposer un nouveau trajet</a>
                @else
                    <div class="block md:flex md:-px-4">
                        <a href="{{ route('register') }}" class="button md:flex-1 md:mx-4">M'inscrire</a>
                        <a href="{{ route('login') }}" class="button mt-4 md:flex-1 md:mt-0 md:mx-4">Me connecter</a>
                    </div>
                @endauth

            </div>
        </div>
    </div>
@endsection
