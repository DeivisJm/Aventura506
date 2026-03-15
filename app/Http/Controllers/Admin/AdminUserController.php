<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subscriber;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('role')
            ->latest()
            ->get();

        $subscribers = Subscriber::latest()->get();

        return view('admin.users.index', compact('users', 'subscribers'));
    }

    public function create()
    {
        $roles = Role::all();

        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $protectedRoleId = 1;

        $isProtectedUser = (int) $user->role_id === $protectedRoleId;
        $totalProtectedUsers = User::where('role_id', $protectedRoleId)->count();
        $isChangingProtectedRole = $isProtectedUser && (int) $validated['role_id'] !== $protectedRoleId;

        if ($isChangingProtectedRole && $totalProtectedUsers === 1) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'No se puede cambiar el rol de este usuario porque es el único Superadministrador del sistema.');
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }


    public function destroy(User $user)
    {
        $protectedRoleId = 1;

        $isProtectedUser = (int) $user->role_id === $protectedRoleId;
        $totalProtectedUsers = User::where('role_id', $protectedRoleId)->count();

        if ($isProtectedUser && $totalProtectedUsers === 1) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'No se puede eliminar este usuario porque es el único Superadministrador del sistema.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }


    public function editSubscriber(Subscriber $subscriber)
    {
        return view('admin.users.edit-subscriber', compact('subscriber'));
    }

    public function updateSubscriber(Request $request, Subscriber $subscriber)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:subscribers,email,' . $subscriber->id],
        ]);

        $subscriber->update([
            'email' => $validated['email'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Suscriptor actualizado correctamente.');
    }

    public function destroySubscriber(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Suscriptor eliminado correctamente.');
    }
}
