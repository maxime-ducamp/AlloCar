@extends('base')

@section('content')
    <main class="mx-auto mt-10 px-4 md:mt-16">
        <div class="text-grey-darkest">
            <header class="text-center">
                <a href="{{ route('profiles.index', ['user' => $journey->driver->name]) }}" title="{{ $journey->driver->name }}" class="flex items-center justify-center">
                    <div class="user-avatar bg-cover border-blue" style="background-image: url('{{ asset('storage/' . $journey->driver->avatar_path)  }}')"></div>
                </a>
                <p class="mt-2 leading-normal">
                    <a class="link"
                          href="{{ route('profiles.index', ['user' => $journey->driver->name]) }}">{{ $journey->driver->name  }}</a>
                    effectuera un
                    trajet le
                    <br>{{ ucfirst(\Jenssegers\Date\Date::parse($journey->departure_datetime)->format('l j F')) }}</p>
                <p class="text-red py-3 font-bold {{ $journey->seats > 0 && $journey->seats < 3 ? 'visible' : 'invisible' }}">
                    Bientôt complet !</p>
            </header>

            <div class="mt-10">
                <div class="flex justify-between items-center px-3 md:w-1/2 md:mx-auto">
                    <div class="text-center flex-col w-1/3">
                        <p>Départ:</p>
                        <p>{{ $journey->departure }}</p>
                        <p class="mt-4">{{ \Jenssegers\Date\Date::parse($journey->departure_datetime)->format('H:i') }}</p>
                    </div>

                    <div class="text-center">
                        <img src="{{ asset('images/svg/arrow-right.svg') }}" alt="" class="svg-filter-blue w-1/4 z-0">
                    </div>

                    <div class="text-center flex-col w-1/3">
                        <p>Arrivée:</p>
                        <p>{{ $journey->arrival }}</p>
                        <p class="mt-4">{{ \Jenssegers\Date\Date::parse($journey->arrival_datetime)->format('H:i') }}</p>
                    </div>
                </div>

                <div class="mt-10 text-center leading-normal">
                    <p>Arrivée prévue
                        le {{ ucfirst(\Jenssegers\Date\Date::parse($journey->arrival_datetime)->format('l j F')) }}</p>
                    
                </div>

            </div>


            <div class="mt-10 mx-auto w-5/6 px-2 md:w-1/2 md:text-center">
                <div class="flex justify-between items-center">
                    @if($journey->seats === 0)
                        <i class="fas fa-car text-red-light text-3xl flex-1"></i>
                    @elseif($journey->seats > 0 and $journey->seats <= 2)
                        <i class="fas fa-car text-orange text-3xl flex-1"></i>
                    @elseif($journey->seats > 2)
                        <i class="fas fa-car text-green text-3xl flex-1"></i>
                    @endif

                    @if($journey->seats == 0)
                        <p class="flex-1 text-left text-red-light font-bold">Trajet Complet !</p>
                    @else
                        <p class="flex-1 text-left">Il
                        reste {{ $journey->seats }} {{ $journey->seats > 1 ? ' places' : ' place' }}</p>
                    @endif

                </div>
                <div class="flex justify-between items-center mt-4">
                    <i class="fas fa-paw text-{{ $journey->allows_pets ? 'green ' : 'red-light' }} text-3xl flex-1"></i>
                    <p class="flex-1 text-left">{{ $journey->allows_pets ? 'Animaux acceptés' : 'Animaux non acceptés' }}</p>
                </div>
                <div class="flex justify-between items-center mt-4">
                    <i class="fas fa-smoking-ban text-{{ $journey->allows_smoking ? 'green ' : 'red-light' }} text-3xl flex-1"></i>
                    <p class="flex-1 text-left">{{ $journey->allows_smoking ? 'Fumeur' : 'Non-fumeur' }}</p>
                </div>
            </div>


            <div class="mt-10 mx-auto w-5/6 px-2 md:w-1/2 md:pl-16">
                <p>Participants: </p>
                <div class="mt-5 flex">
                    @forelse($journey->participants() as $participant)
                        <a href="{{ route('profiles.index', ['user' => $participant->name]) }}" title="{{ $participant->name }}"
                           class="{{ $loop->index != 0 ? 'ml-3' : '' }}">
                            <div class="user-avatar bg-cover border-blue h-12 w-12 md:h-16 md:w-16" style="background-image: url('{{ asset('storage/' . $participant->avatar_path)  }}')"></div>
                        </a>
                    @empty
                        <span>Soyez le premier à demander à participer !</span>
                    @endforelse
                </div>
            </div>

            <div class="mt-10 md:mt-16 md:w-4/5 md:mx-auto">
                @if($journey->driver_comment)
                    <h3 class="text-blue text-center">Le conducteur a laissé ce commentaire:</h3>
                    <p class="leading-normal text-center mt-4">{{ $journey->driver_comment }}</p>
                @else
                    <div class="text-center">
                        <h3 class="text-blue text-center">Le conducteur n'a pas commenté ce trajet.</h3>
                    </div>
                @endif
            </div>

            @auth
                <div class="flex mt-6 md:w-1/2 md:mx-auto">
                    @can('update', $journey)
                        <a href="{{ route('journeys.edit', ['journey' => $journey]) }}"
                           class="button w-1/2 rounded-r-none">Modifier</a>
                        <form action="{{ route('journeys.destroy', ['journey' => $journey]) }}" method="post"
                              class="w-1/2">
                            @csrf
                            @method('delete')
                            <input type="submit" class="button bg-red-light text-white rounded-l-none cursor-pointer"
                                   value="Supprimer">
                        </form>
                    @else
                        @if($journey->seats > 0 && !$journey->hasBookingForUser(auth()->user()))
                            <form action="{{ route('bookings.store', ['journey' => $journey]) }}" method="post"
                                  class="mt-6 flex-1 md:mx-auto md:flex-none">
                                @csrf
                                <input type="submit" class="button" value="Demander à participer">
                            </form>
                        @endif
                    @endcan
                </div>
            @endauth

        </div>


        <section class="mt-10">
            <h3 class="text-blue text-center mb-10">Discussion</h3>

            <div class="my-10 md:w-2/3 md:mx-auto"> <!-- Comments Container Start -->

                @forelse($comments as $comment)
                    <div class="p-2 border-t border-grey-light text-grey-darkest ">
                        <div class="flex h-16 items-center justify-between">
                            <a href="{{ route('profiles.index', ['user' => $comment->user]) }}" title="{{ $comment->user->name }}" class="flex items-center justify-center">
                                <div class="user-avatar bg-cover border-blue h-12 w-12"
                                     style="background-image: url('{{ asset('storage/' . $comment->user->avatar_path)  }}')">
                                </div>
                            </a>

                            <div class="text-right">
                                <div class="flex justify-end items-center">
                                    <a href="{{ route('profiles.index', ['user' => $comment->user]) }}"
                                       class="text-blue font-bold no-underline">{{ $comment->user->name }}
                                        @if($comment->user->is($journey->driver))
                                            <i class="fas fa-car text-blue-light ml-2"></i>
                                        @endif
                                    </a>
                                </div>
                                <small>{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small>
                            </div>
                        </div>
                        <p class="leading-normal mt-2 border-l border-blue-light pl-2">{{ $comment->body }}</p>
                        @can('update', $comment)
                            <div class="my-4">
                                <a href="{{ route('comments.edit', ['journey' => $journey, 'comment' => $comment]) }}"
                                   class="link">Modifier</a>
                                <form action="{{ route('comments.destroy', ['journey' => $journey, 'comment' => $comment]) }}"
                                      method="post" class="inline">
                                    @csrf
                                    @method('delete')
                                    <input type="submit" class="link text-red-light bg-transparent cursor-pointer"
                                           value="Supprimer">
                                </form>
                            </div>
                        @endcan
                    </div>
                @empty
                    <div class="text-center">
                        <p class="text-grey-darker">N'hésitez pas à poser vos questions au conducteur !</p>
                    </div>
                @endforelse

            </div> <!--Comments Container End -->

            {{ $comments->links() }}

            <div class="my-10 pb-16 md:w-2/3 md:mx-auto"> <!-- Comment Form Start -->
                <h3 class="text-center text-blue">Participer à cette discussion</h3>

                @auth
                    <form action="{{ route('comments.store', ['journey' => $journey]) }}" method="post" class="mt-10"
                          id="comment-form">
                        @csrf
                        <textarea name="body" id="comment-body" class="form-input h-32" required
                                  placeholder="Une question à poser ?"></textarea>
                        <div class="bg-red-light text-white mt-5 rounded-md flex items-center"
                             id="validation-errors"></div>
                        <div class="flex justify-end">
                            <input type="submit" class="form-submit" value="Commenter" id="comment-form-submit">
                        </div>
                    </form>
                @else
                    <div class="text-center h-24 p-5 leading-normal">
                        <p class="text-grey-darker">
                            <a href="{{ route('login') }}" class="link">Connectez-vous</a> ou
                            <a href="{{ route('register') }}" class="link">Inscrivez-vous</a>
                            pour pouvoir participer à cette discussion
                        </p>
                    </div>
                @endauth
            </div> <!-- Comment Form End -->

        </section>
    </main>
@endsection

@section('bottom_scripts')
    <script>

        const form = document.getElementById('comment-form'),
            validationErrorsContainer = document.getElementById('validation-errors');

        const formData = {
            body: {
                value: null,
                validation: "required|string|min:3|max:200"
            }
        };


        form.addEventListener('submit', function (e) {
            e.preventDefault();

            let bodyInput = document.getElementById('comment-body');

            formData.body.value = bodyInput.value;

            const result = validator.validateForm({formData});

            if (result.errors.body) {

                let p = document.createElement('p');
                p.innerHTML = "Caractères minimum: 3, maximum: 200";
                validationErrorsContainer.appendChild(p);
                validationErrorsContainer.classList.add('p-5');
                document.querySelector('[name=body]').classList.add('form-input-error');
                document.getElementById('comment-form-submit').addEventListener('click', function () {
                    validationErrorsContainer.innerHTML = '';
                    validationErrorsContainer.classList.remove('form-input-error');
                    validationErrorsContainer.classList.remove('p-5');
                });

            } else {
                document.querySelector('[name=body]').classList.remove('form-input-error');
                form.submit();
            }
        });
    </script>
@endsection
