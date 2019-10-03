<header id="main-header" class="z-10">
    <div>
        <a href="/" class="no-underline">
            <h1 class="text-white">AlloCar</h1>
        </a>
    </div>
    @auth
        <div class="flex items-center">
            <div class="hidden md:visible md:flex md:justify-between md:mr-6">
                <a href="{{ route('journeys.search.index') }}" class="link text-white md:ml-6 font-semibold">Trouver un trajet</a>
                <a href="{{ route('journeys.create') }}" class="link text-white font-semibold md:ml-6">Proposer un trajet</a>
            </div>
            <a href="{{ route('profiles.index', ['user' => auth()->user()]) }}" class="no-underline">
                <div class="user-avatar bg-cover inline-block" style="background-image: url('{{ asset('storage/' . auth()->user()->avatar_path)  }}')"></div>

                <div class="notification-bubble" style="visibility: {{ count(auth()->user()->unreadNotifications) > 0 ? 'visible' : 'hidden' }};">{{ count(auth()->user()->unreadNotifications) > 0 ? count(auth()->user()->unreadNotifications) : '' }}</div>
            </a>
            <i class="fas fa-bars text-white text-4xl cursor-pointer w-10 text-center" id="nav-toggle-button"
               aria-roledescription="Navigation Toggle" onclick="toggleNav()"></i>
        </div>
    @else
        <div class="flex items-center">
            <div class="invisible lg:visible lg:flex lg:justify-between">
                <a href="{{ route('journeys.search.index') }}" class="link text-white mr-10 font-semibold">Trouver un trajet</a>
            </div>
            <i class="fas fa-bars text-white text-4xl cursor-pointer w-10 text-center"
               id="nav-toggle-button" aria-roledescription="Navigation Toggle" onclick="toggleNav()"></i>
        </div>
    @endauth
</header>
