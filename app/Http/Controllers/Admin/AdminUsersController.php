<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminUsersController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('admin')) {
            $users = User::whereDoesntHave('roles')->paginate(10);
        } else if (auth()->user()->hasRole('super_admin')) {
            $users = User::paginate(10);
        }

        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact(['user', 'roles']));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('adminManage', $user);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'user_avatar' => 'mimes:jpeg,bmp,png|max:2000',
        ]);

        if ($request->file('user_avatar')) {

            $previous_avatar = $user->avatar_path;

            if ($previous_avatar !== 'user_uploads/avatars/default-avatar.png') {
                Storage::delete('/public/' . $previous_avatar);
            }

            $avatar_path = $request->file('user_avatar')->store('user_uploads/avatars', 'public');

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'avatar_path' => $avatar_path
            ]);
        } else {
            $user->update($request->only(['name', 'email']));
        }

        return redirect()->route('admin.users.index')->with('flash', [
            'status' => 'success',
            'message' => 'Utilisateur modifié'
        ]);
    }

    public function destroy(User $user)
    {
        $this->authorize('adminManage', $user);

        foreach($user->roles as $role) {
            $user->roles()->detach($role);
        }

        if ($user->delete()) {
            return redirect()->route('admin.users.index')
                ->with('flash', [
                    'status' => 'success',
                    'message' => 'Utilisateur supprimé'
                ]);
        } else {
            return redirect()->back()->with('flash', [
                'status' => 'error',
                'message' => 'Une erreur est survenue'
            ]);
        }
    }
}
