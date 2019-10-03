@switch($notification->type)
    @case('App\Notifications\BookingRequestNotification')
    <div class="mt-10 shadow-md">
        <div class="w-full text-center pt-6 md:pt-12">
            <img src="{{ asset('storage/' . $notification->data['sender_avatar']) }}"
                 alt="Avatar pour {{ $notification->data['sender_name'] }}"
                 class="user-avatar border-blue">
        </div>
        <p class="p-5 text-center md:my-10">
            <a href="{{ route('profiles.index', ['user' => $notification->data['sender_name']]) }}"
               class="link">{{ $notification->data['sender_name'] }}</a>
            a demandé à participer à l'un de vos trajets
            <a
                href="/trajets/{{ $notification->data['journey_id'] }}" class="link block mt-5">Voir le
                trajet</a>
        </p>
        <div class="flex justify-around items-center w-5/6 mx-auto pb-5 md:pb-12 md:w-1/2">

            <form action="{{ route('bookings.deny', ['journey' => $notification->data['journey_id'], 'booking' => $notification->data['booking_id']]) }}"
                  method="post">
                @csrf
                <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                <button type="submit"
                        class="fas fa-times-circle text-5xl text-red-light cursor-pointer"></button>
            </form>

            <form action="{{ route('bookings.approve', ['journey' => $notification->data['journey_id'], 'booking' => $notification->data['booking_id']]) }}"
                  method="post">
                @csrf
                <input type="hidden" name="notification_id" value="{{ $notification->id }}">
                <button type="submit"
                        class="fas fa-check-circle text-5xl text-green-light cursor-pointer"></button>
            </form>

        </div>
    </div>
    @break

    @case('App\Notifications\JourneyDeletedNotification')
    <div class="mt-10 shadow-md">
        <div class="w-full text-center pt-6">
            <img src="{{ asset('storage/' . $notification->data['driver_avatar']) }}"
                 alt="Avatar pour {{ $notification->data['driver_name'] }}"
                 class="user-avatar border-blue">
        </div>
        <p class="p-5">
            <a href="{{ route('profiles.index', ['user' => $notification->data['driver_name']]) }}"
               class="link">{{ $notification->data['driver_name'] }}</a>
            a <span class="text-red-light">supprimé</span> un trajet pour lequel vous aviez réservé.
        </p>
        <p class="p-5 mt-3">
            Ce trajet était prévu pour
            le {{ ucfirst(\Jenssegers\Date\Date::parse($notification->data['journey_departure_datetime'])->format('l j F')) }}
            et était au départ de {{ $notification->data['journey_departure'] }}
        </p>

        <form action="{{ route('notifications.destroy', ['user' => auth()->user(), 'notification_id' => $notification->id]) }}"
              method="post" class="pb-8 pt-4 w-1/2 mx-auto">
            @csrf
            <input type="submit" class="button text-sm" value="Marquer comme lu">
        </form>
    </div>
    @break

    @case('App\Notifications\BookingApprovedNotification')
    <div class="mt-10 shadow-md">
        <div class="w-full text-center pt-6">
            <img src="{{ asset('storage/' . $notification->data['driver_avatar']) }}"
                 alt="Avatar pour {{ $notification->data['driver_name'] }}"
                 class="user-avatar border-blue">
        </div>
        <div class="p-5 text-center">
            <p class="mb-3">
                <a href="{{ route('profiles.index', ['user' => $notification->data['driver_name']]) }}"
                   class="link">{{ $notification->data['driver_name'] }}</a>
                a <span class="{{ $notification->data['display_class'] }}">{{ $notification->data['notification_status'] }}</span> votre demande de participation à son trajet
            </p>
            <a href="/trajets/{{ $notification->data['journey_id'] }}" class="link">Voir le trajet</a>
        </div>

        <form action="{{ route('notifications.destroy', ['user' => auth()->user(), 'notification_id' => $notification->id]) }}"
              method="post" class="pb-8 pt-4 w-1/2 mx-auto">
            @csrf
            <input type="submit" class="button text-sm" value="Marquer comme lu">
        </form>
    </div>
    @break

    @case('App\Notifications\BookingDeniedNotification')
    <div class="mt-10 shadow-md">
        <div class="w-full text-center pt-6">
            <img src="{{ asset('storage/' . $notification->data['driver_avatar']) }}"
                 alt="Avatar pour {{ $notification->data['driver_name'] }}"
                 class="user-avatar border-blue">
        </div>
        <div class="p-5 text-center">
            <p class="mb-3">
                <a href="{{ route('profiles.index', ['user' => $notification->data['driver_name']]) }}"
                   class="link">{{ $notification->data['driver_name'] }}</a>
                a <span class="{{ $notification->data['display_class'] }}">{{ $notification->data['notification_status'] }}</span> votre demande de participation à son trajet
            </p>
            <a href="/trajets/{{ $notification->data['journey_id'] }}" class="link">Voir le trajet</a>
        </div>

        <form action="{{ route('notifications.destroy', ['user' => auth()->user(), 'notification_id' => $notification->id]) }}"
              method="post" class="pb-8 pt-4 w-1/2 mx-auto">
            @csrf
            <input type="submit" class="button text-sm" value="Marquer comme lu">
        </form>
    </div>
    @break

    @case('App\Notifications\UserCreatedNotification')
    <div class="mt-10 shadow-md leading-normal">
        <div class="w-full text-center pt-6">
            <h2 class="text-blue">Bienvenue {{ $notification->data['notified_name'] }} !</h2>
        </div>
        <div class="p-5 md:px-16 md:text-center md:leading-normal">
            <p class="mb-3">
                Ceci est votre première visite et nous vous encourageons à lire notre <a href="{{route('faq')}}" class="link">FAQ</a>
                pour toute question concernant l'utilisation de l'application.
            </p>
            <p class="mb-3">
                Vous y trouverez également des informations sur comment modifier vos données personnelles (ex: modifier votre avatar...)
            </p>
            <p class="mb-3">
                Merci de nous faire confiance et à bientôt sur la route ! ;)
            </p>
        </div>

        <form action="{{ route('notifications.destroy', ['user' => auth()->user(), 'notification_id' => $notification->id]) }}"
              method="post" class="pb-8 pt-4 w-1/2 mx-auto">
            @csrf
            <input type="submit" class="button text-sm" value="Marquer comme lu">
        </form>
    </div>
    @break

    @case('App\Notifications\PrivateMessageReceivedNotification')
    <div class="w-full text-center pt-6 mt-10 shadow-md leading-normal">
        <div>
            <h2 class="text-blue">Bonjour, {{ $notification->data['notifiable_name'] }} !</h2>
        </div>
        <div class="p-5">
            <p class="mb-3">
                {{ $notification->data['sender_name'] }} vient de vous envoyer un message privé. Rendez-vous dans votre
                messagerie pour pouvoir le consulter !
            </p>
            <form action="{{ route('notifications.destroy', ['user' => auth()->user(), 'notification_id' => $notification->id]) }}"
                  method="post" class="pb-8 pt-4 w-1/2 mx-auto">
                @csrf
                <input type="submit" class="button text-sm" value="Marquer comme lu">
            </form>
        </div>
    </div>
    @break

    @case('App\Notifications\RoleGrantedNotification')
    @case('App\Notifications\RoleRemovedNotification')
    <div class="w-full text-center pt-6 mt-10 shadow-md leading-normal">
        <div>
            <h2 class="text-blue">Bonjour, {{ $notification->data['user']['name'] }} !</h2>
        </div>
        <div class="p-5">
            <p class="mb-3">
                <a href="{{ route('profiles.index', ['user' => $notification->data['super_admin']['name']]) }}" class="link">
                    {{ $notification->data['super_admin']['name'] }}
                </a>
                 vous a {{ $notification->data['action'] === 'add' ? 'assigné un nouveau rôle !' : 'retiré un rôle.' }}
            </p>

            @if($notification->data['action'] === 'assigné')
                <p>Vous êtes désormais <span class="text-blue font-bold">{{ $notification->data['role'] }}</span></p>
            @else
                <p>Vous n'êtes désormais plus <span class="text-blue font-bold">{{ $notification->data['role'] }}</span></p>
            @endif
            <form action="{{ route('notifications.destroy', ['user' => auth()->user(), 'notification_id' => $notification->id]) }}"
                  method="post" class="pb-8 pt-4 w-1/2 mx-auto">
                @csrf
                <input type="submit" class="button text-sm" value="Marquer comme lu">
            </form>
        </div>
    </div>
    @break

{{--    @default--}}
{{--    Default case...--}}
@endswitch


