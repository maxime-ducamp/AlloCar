@extends('base')

@section('content')
    <main class="mx-auto mt-10 mb-16 px-4 md:mt-16">
        <h1 class="text-blue text-center text-2xl">Espace d'Administration</h1>

            <aside>
                <nav class="mt-10 flex flex-col justify-center items-center">
                    @if(auth()->user()->hasRole('admin') or auth()->user()->hasRole('super_admin'))
                        <a href="{{ route('admin.users.index') }}" class="hover:bg-blue-light hover:border-blue-light hover:text-white block py-4 my-5 border-2 border-blue cursor-pointer w-4/5 md:w-1/3 bg-white text-blue rounded-xl flex justify-center items-center mx:auto no-underline md:text-2xl">Liste des utilisateurs</a>
                        <a href="{{ route('admin.comments.index') }}" class="hover:bg-blue-light hover:border-blue-light hover:text-white block py-4 my-5 border-2 border-blue cursor-pointer w-4/5 md:w-1/3 bg-white text-blue rounded-xl flex justify-center items-center mx:auto no-underline md:text-2xl">Liste des commentaires</a>
                        <a href="{{ route('admin.journeys.index') }}" class="hover:bg-blue-light hover:border-blue-light hover:text-white block py-4 my-5 border-2 border-blue cursor-pointer w-4/5 md:w-1/3 bg-white text-blue rounded-xl flex justify-center items-center mx:auto no-underline md:text-2xl">Liste des trajets</a>
                    @endif
                    @if(auth()->user()->hasRole('super_admin'))
                        <a href="{{ route('admin.roles.index') }}" class="hover:bg-blue-light hover:border-blue-light hover:text-white block py-4 my-5 border-2 border-blue cursor-pointer w-4/5 md:w-1/3 bg-white text-blue rounded-xl flex justify-center items-center mx:auto no-underline md:text-2xl">Gérer les membres de l'équipe</a>
                    @endif
                </nav>
            </aside>
    </main>
@endsection