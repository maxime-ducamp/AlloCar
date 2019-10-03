@extends('base')

@section('content')
    <main class="mx-auto mt-10 px-4 md:mt-16">


        <h1 class="text-center text-blue pb-10">Liste des utilisateurs</h1>


       <div class="px-10">

           <a href="{{ route('admin.dashboard') }}" class="link block py-5"> <= Retour à l'Espace d'Administration</a>


           @can('adminManage', $users->first())
               <table class="w-full text-left">
                   <tr>
                       <th class="bg-blue p-3 text-white">Nom</th>
                       <th class="bg-blue p-3 text-white">Email</th>
                       <th class="bg-blue p-3 text-white">Avatar</th>
                       <th class="bg-blue p-3 text-white text-center">Editer</th>
                       <th class="bg-blue p-3 text-white text-center">Supprimer</th>
                   </tr>
                   @foreach($users as $user)
                       <tr>
                           <td class="py-5">
                               <a href="{{ route('profiles.index', ['user' => $user]) }}" class="link">
                                   {{ $user->name }}
                               </a>
                           </td>
                           <td>{{ $user->email }}</td>
                           <td>
                               <div class="user-avatar bg-cover inline-block" style="background-image: url('{{ asset('storage/' . $user->avatar_path)  }}')"></div>
                           </td>
                           <td class="text-center">
                               <a href="{{ route('admin.users.edit', ['user' => $user]) }}" class="fas fa-user-edit text-lg text-blue"></a>
                           </td>
                           <td class="text-center">
                               <form action="{{ route('admin.users.destroy', ['user' => $user]) }}" method="post">
                                   @csrf
                                   @method('delete')
                                   <button type="submit" class="fas fa-times-circle text-lg text-red"></button>
                               </form>
                           </td>
                       </tr>
                   @endforeach
               </table>
           @endif
       </div>




        <div class="mb-10">
            {{ $users->links() }}
        </div>
    </main>
@endsection
