<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\RoleGrantedNotification;
use App\Notifications\RoleRemovedNotification;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminRolesController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '=', 'super_admin')
                ->orWhere('name', '=', 'admin')
                ->orWhere('name', '=', 'moderator');
        })->get();

        return view('admin.roles.index', compact([
            'roles', 'users'
        ]));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:20|unique:roles',
        ]);

        Role::create($data);

        return back();
    }


    public function addRole(Request $request, User $user)
    {
        $this->authorize('superAdminManage', $user);

        $role = $request->user_role;

        if (!$user->hasRole($role)) {
            $user->addRole($role);
            $user->notify(new RoleGrantedNotification(auth()->user(), $role));

        }

        return redirect()->route('admin.roles.index')->with('flash', [
            'status' => 'success',
            'message' => 'Nouveau rôle pour ' . $user->name
        ]);
    }


    public function removeRole(Request $request, User $user)
    {
        $this->authorize('superAdminManage', $user);
        $role = $request->user_role;
        if ($user->hasRole($role)) {
            $user->removeRole($role);
            $user->notify(new RoleRemovedNotification(auth()->user(), $role));
        }

        return redirect()->route('admin.roles.index')->with('flash', [
            'status' => 'success',
            'message' => 'Rôle retiré pour ' . $user->name
        ]);
    }
}
