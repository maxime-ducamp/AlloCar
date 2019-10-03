<footer class="w-full pin-b text-center text-white bg-blue-dark py-10">
    <div class="flex flex-col">
        <a href="{{ route('faq') }}" class="link text-white py-2">FAQ</a>
        <a href="{{ route('legal-mentions') }}" class="link text-white py-2">Mentions Légales</a>
        <a href="{{ route('journeys.search.index') }}" class="link text-white py-2">Trouver un trajet</a>
        @auth
            <a href="{{ route('journeys.create') }}" class="link text-white py-2">Proposer un trajet</a>
            <a href="{{ route('profiles.index', ['user' => auth()->user()]) }}" class="link text-white py-2">Votre Profil</a>
            @if(auth()->user()->hasRole('admin') or auth()->user()->hasRole('super_admin'))
                <a href="{{ route('admin.dashboard') }}" class="link text-white py-2">Espace d'Administration</a>
            @endif
        @endauth
    </div>
</footer>
		