@extends('base')

@section('content')

    <div class="pt-10 h-full pb-20 bg-cover bg-bottom"
         style="background-image: url('../images/backgrounds/profile/profile-background.jpg')">

        <div class="mx-auto mt-10 mb-16 px-4 md:w-2/3 lg:w-1/2">

            <div class="profile-background">

               <div class="flex flex-col justify-center items-center">
                   <div class="user-avatar bg-cover border-blue"
                        style="background-image: url('{{ asset('storage/' .$user->avatar_path)  }}')"></div>
                   <h2 class="text-blue mt-5">
                       {{ (auth()->check() && auth()->user()->id === $user->id) ? 'Votre Profil' : 'Profil de ' . $user->name }}
                   </h2>
               </div>

                <ul class="list-reset mt-5 px-5">
                    <li class="profile-list-item"><span class="text-blue-light">Utilisateur: </span> {{ $user->name }}
                    </li>
                    @can('manage', $user)
                        <li class="profile-list-item"><span class="text-blue-light">Email:</span> {{ $user->email }}
                        </li>
                    @endcan
                    <li class="profile-list-item"><span class="text-blue-light">Experience:</span>
                        <div class="w-1/3 flex justify-end">
                            <span>{{ $user->getReadableExperience() }}</span>
                        </div>
                    </li>

                    @can('manage', $user)
                        <li class="profile-list-item justify-start">
                            <a href="{{ route('private-messages.index', ['user' => $user]) }}"
                               class="no-underline flex justify-center items-center">
                                <i class="far fa-envelope lg:text-3xl text-blue-light"></i>
                                <span class="text-blue-light ml-4">Messagerie</span>
                            </a>
                        </li>
                    @endcan

                </ul>

                @can('manage', $user)
                    <button class="button mb-4 mt-8 lg:w-1/2 lg:mx-auto" onclick="openPanel('edit')">Modifier mes informations</button>
                    <div id="edit-panel" class="profile-option-panel-hidden">
                        <form action="{{ route('users.update', ['user' => $user]) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div>
                                <label for="name" class="text-blue-light text-lg">Nom d'utilisateur: </label>
                                <input id="name" type="text" placeholder="Nom" name="name" value="{{ $user->name }}"
                                       class="form-input mt-2">
                            </div>
                            <div class="mt-6">
                                <label for="email" class="text-blue-light text-lg">Email: </label>
                                <input id="email" type="email" placeholder="Email" name="email"
                                       value="{{ $user->email }}"
                                       class="form-input mt-2">
                            </div>
                            <div class="flex-col items-center mt-6">
                                <label for="user_avatar" class="text-lg text-blue-light w-full">Avatar: </label>
                                <input type="file" name="user_avatar" id="user_avatar" class="mt-2 w-full">
                            </div>
                            <div class="flex justify-end mt-6">
                                <input type="submit" value="Modifier" class="form-submit"/>
                            </div>

                        </form>
                    </div>

                    @if(count($notifications) < 1)
                        <button class="button mt-10 lg:w-1/2 lg:mx-auto" onclick="openPanel('notifications')">Notifications</button>
                    @elseif(count($notifications) === 1)
                        <button class="button mt-10 lg:w-1/2 lg:mx-auto" onclick="openPanel('notifications')">1 Notification</button>
                    @else
                        <button class="button mt-10"
                                onclick="openPanel('notifications')">{{ count($notifications) . ' Notifications' }}</button>
                    @endif
                    <div id="notifications-panel" class="profile-option-panel-hidden">
                        <div class="text-grey-darker">

                            @forelse($notifications as $notification)
                                @include('includes.notifications.profiles-notifications')
                            @empty
                                <div class="p-10 text-center">
                                    <p>Vous n'avez aucune notification</p>
                                </div>
                            @endforelse
                        </div>


                    </div>

                    <a class="button mt-10 lg:w-1/2 lg:mx-auto" href="{{ route('profiles.journeys', ['user' => auth()->user()]) }}">Mes
                        trajets</a>

                    <a class="button mt-10 lg:w-1/2 lg:mx-auto" href="{{ route('profiles.bookings', ['user' => auth()->user()]) }}">Mes
                        réservations</a>

                    <a href="{{ route('users.delete-form', ['user' => auth()->user()]) }}" class="button bg-red-light mt-10 lg:w-1/2 lg:mx-auto">Supprimer mon compte</a>

{{--                    <form action="{{ route('users.destroy', ['user' => auth()->user()]) }}" method="post"--}}
{{--                          class="inline">--}}
{{--                        @csrf--}}
{{--                        @method('delete')--}}
{{--                        <input type="submit" class="button bg-red-light mt-10 lg:w-1/2 lg:mx-auto" value="Supprimer mon compte">--}}
{{--                    </form>--}}
                @else
                    <div class="py-8 text-lg">
                        <a href="{{ route('profiles.journeys', ['user' => $user]) }}" class="link block text-blue-light text-xl pl-4">Voir les
                            trajets de cet
                            utilisateur</a>

                        @auth

                            <button class="link block mt-16 text-blue-light text-xl ml-4 border-none focus:outline-none" onclick="showPrivateMessageForm()"
                                    id="showPrivateMessageForm">
                                Envoyer un message privé
                            </button>

                            @include('includes.errors.session-errors')


                            <div class="send-private-message-hidden" id="privateMessageFormContainer">
                                <form action="{{ route('private-messages.store', ['user' => $user]) }}" method="post"
                                      class="mt-4 ml-4" id="pm-form">
                                    @csrf
                                    <input required type="text" class="form-input" name="subject" placeholder="Sujet *"
                                           id="pm-subject">
                                    <textarea required name="body" id="pm-body" class="form-input h-32 mt-4"
                                              maxlength="300"
                                              placeholder="Message *"></textarea>

                                    <input type="submit" class="form-submit" value="Envoyer">
                                </form>
                            </div>
                        @endauth
                    </div>
                @endcan
            </div>
        </div>
    </div>

@endsection

@can('manage', $user)
@section('bottom_scripts')
    <script>
        function openPanel(which) {
            let panel = document.getElementById(which + '-panel');

            if (panel.className === 'profile-option-panel-hidden') {
                panel.className = "profile-option-panel-visible";
            } else {
                panel.className = "profile-option-panel-hidden";
            }
        }
    </script>
@endsection

@else
@section('bottom_scripts')
    <script>
        function showPrivateMessageForm() {
            let button = document.getElementById('showPrivateMessageForm'),
                formContainer = document.getElementById('privateMessageFormContainer');

            if (formContainer.className === 'send-private-message-hidden') {
                button.innerHTML = 'Annuler';
                button.classList.remove('text-blue-light');
                button.classList.add('text-red');
                formContainer.className = "send-private-message-visible";
            } else {
                button.innerHTML = 'Envoyer un message privé';
                button.classList.remove('text-red');
                button.classList.add('text-blue-light');
                formContainer.className = "send-private-message-hidden";
            }
        }
    </script>
@endsection
@endcan
