@extends('base')

@section('content')

    <main class="mx-auto mt-10 px-4 md:mt-16">

        <section>
            <h2 class="text-blue text-center">Modifier un utilisateur</h2>

            <form action="{{ route('admin.users.update', ['user' => $user]) }}" method="post" class="md:w-1/2 md:mx-auto md:mt-10"
                  enctype="multipart/form-data"
            >
                @csrf
                @method('put')

                <div class="mt-4">
                    <label for="name" class="text-blue">Nom: </label>
                    <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-input mt-4" required>
                </div>

                <div class="mt-4">
                    <label for="email" class="text-blue">Email: </label>
                    <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-input mt-4" required>
                </div>

                <div class="mt-4">
                    <label for="user_avatar" class="text-lg text-blue-light w-full">Avatar: </label>
                    <input type="file" name="user_avatar" id="user_avatar" class="mt-2 w-full">
                </div>

                <div class="flex justify-end">
                    <input type="submit" value="Modifier" class="form-submit">
                </div>
            </form>
        </section>

        @can('superAdminManage', $user)
            <section class="mb-32">

                <h2 class="text-blue text-center mb-10">Assigner un rôle</h2>
                <form action="{{ route('admin.roles.assign-role', ['user' => $user]) }}" method="post"
                      class="flex justify-center items-center md:w-1/2 md:mx-auto"
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
            </section>

            <section class="mb-32">

                <h2 class="text-blue text-center mb-10">Retirer un rôle</h2>
                <form action="{{ route('admin.roles.remove-role', ['user' => $user]) }}" method="post"
                      class="flex justify-center items-center md:w-1/2 md:mx-auto"
                >
                    @csrf
                    <select name="user_role" class="form-select w-2/3 rounded-r-none">
                        @foreach($user->roles as $role)
                            <option value="{{ $role->name }}">{{ $role->getReadableName() }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="fas fa-times bg-red-light text-white h-10 rounded-r-lg w-1/5 shadow-md"></button>
                </form>
            </section>
        @endcan

    </main>
@endsection