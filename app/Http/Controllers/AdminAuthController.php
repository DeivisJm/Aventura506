<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    /**
     * Handle admin login.
     * Only superadmin and admin can access admin area.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Validate credentials against users table
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => __('admin.invalid_credentials'),
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();
        $role = $user?->role?->name;

        // Redirect superadmin to admin dashboard
        if ($role === 'superadmin') {
            return redirect()->route('admin.dashboard');
        }

        // Redirect client to home page
        if ($role === 'client') {
            return redirect()->route('home');
        }

        // Reject any other role
        Auth::logout();

        return back()->withErrors([
            'email' => __('admin.unauthorized'),
        ])->onlyInput('email');
    }
    /**
     * Show admin login form.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Show register form.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration.
     * New users are created with the "client" role by default.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Get default client role
        $clientRole = Role::where('name', 'client')->first();

        if (!$clientRole) {
            return back()->withErrors([
                'email' => __('admin.register_error_message')
            ])->withInput();
        }

        // Create new user in database
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $clientRole->id,
        ]);

        return redirect()->route('login')->with('register_success', true);
    }



    /**
     * Handle logout.
     */

    public function logout(Request $request)
    {
        \Illuminate\Support\Facades\Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
