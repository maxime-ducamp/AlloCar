@extends('base')

@section('content')

    <main class="mx-auto mt-10 px-4 md:mt-16">


        <h1 class="text-center text-blue pb-10">Rôles utilisateurs</h1>


        <div class="px-10 lg:w-5/6 md:mx-auto mb-10">

            <a href="{{ route('admin.dashboard') }}" class="link block py-5"> <= Retour à l'Espace d'Administration</a>

            <table class="w-full text-left">
                <tr>
                    <th class="bg-blue p-3 text-white">Nom</th>
                    <th class="bg-blue p-3 text-white">Email</th>
                    <th class="bg-blue p-3 text-white">Rôles</th>
                    <th class="bg-blue p-3 text-white text-center">Ajouter un rôle</th>
                    <th class="bg-blue p-3 text-white text-center">Retirer un rôle</th>
                </tr>
                @foreach($users as $user)
                    <tr class="border-b border-grey-light">
                        <td class="py-5">
                            <a href="{{ route('profiles.index', ['user' => $user]) }}" class="link">
                                {{ $user->name }}
                            </a>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td class="leading-normal">
                            @foreach($user->roles as $role)
                                <p>{{ $role->getReadableName() }}</p>
                            @endforeach
                        </td>
                        <td>
                            <form action="{{ route('admin.roles.assign-role', ['user' => $user]) }}" method="post"
                                class="flex justify-center items-center"
                            >
                                @csrf
                                <select name="user_role" class="form-select w-2/3 rounded-r-none">
                                    @foreach($roles as $role)
                                        @if(!$user->hasRole($role->name))
                                            <option value="{{ $role->name }}">{{ $role->getReadableName() }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <button type="submit" class="fas fa-plus bg-green-light text-white h-10 rounded-r-lg w-1/5 shadow-md"></button>
                            </form>
                        </td>
                        <td class="text-center">
                            <form action="{{ route('admin.roles.remove-role', ['user' => $user]) }}" method="post"
                                  class="flex justify-center items-center"
                            >
                                @csrf
                                <select name="user_role" class="form-select w-2/3 rounded-r-none">
                                    @foreach($user->roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->getReadableName() }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="fas fa-times bg-red-light text-white h-10 rounded-r-lg w-1/5 shadow-md"></button>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </table>
        </div>

    </main>
@endsection
