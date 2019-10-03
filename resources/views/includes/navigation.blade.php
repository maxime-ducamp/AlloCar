<div class="main-navbar-container" id="main-navbar-container">
    <nav class="main-navbar">
        <ul class="list-reset h-full flex flex-col">
            @Auth
                @if(auth()->user()->hasRole('admin') or auth()->user()->hasRole('super_admin'))
                    <li class="navbar-list-item"><a href="{{ route('admin.dashboard') }}" class="main-navbar-link">Espace d'Administration</a></li>
                @endif
                <li class="navbar-list-item"><a href="{{ route('profiles.index', ['user' => auth()->user()]) }}" class="main-navbar-link">Profil</a></li>
                <li class="navbar-list-item"><a href="{{ route('journeys.search.index') }}" class="main-navbar-link">Trouver un trajet</a></li>
                <li class="navbar-list-item"><a href="{{ route('journeys.create') }}" class="main-navbar-link">Proposer un trajet</a></li>
                <li class="navbar-list-item"><a href="{{ route('profiles.journeys', ['user' => auth()->user()]) }}" class="main-navbar-link">Mes trajets</a></li>
                <li class="navbar-list-item"><a href="{{ route('profiles.bookings', ['user' => auth()->user()]) }}" class="main-navbar-link">Mes réservations</a></li>
                <li class="navbar-list-item ">
                    <form action="{{ route('logout') }}" method="post" class="h-full w-full flex items-center justify-center">
                        @csrf
                        <input type="submit" class="h-full w-full bg-transparent text-white text-lg cursor-pointer" value="Déconnexion">
                    </form>
                </li>
            @else
                <li class="navbar-list-item"><a href="{{ route('journeys.search.index') }}" class="main-navbar-link">Trouver un trajet</a></li>
                <li class="navbar-list-item"><a href="{{ route('inscription') }}" class="main-navbar-link">M'inscrire</a>
                </li>
                <li class="navbar-list-item"><a href="{{ route('connection') }}" class="main-navbar-link">Me connecter</a>
                </li>
            @endauth
        </ul>
    </nav>
</div>
