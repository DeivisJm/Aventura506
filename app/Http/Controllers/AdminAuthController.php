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
     * Only superadmin and client flows are allowed here.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt authentication with the provided credentials
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => __('admin.invalid_credentials'),
            ])->onlyInput('email');
        }

        // Regenerate session after successful authentication
        $request->session()->regenerate();

        $user = Auth::user();
        $role = $user?->role?->name;

        // Redirect superadmin users to the admin dashboard
        if ($role === 'superadmin') {
            return redirect()->route('admin.dashboard');
        }

        // Redirect client users to the public home page
        if ($role === 'client') {
            return redirect()->route('home');
        }

        // Reject unsupported roles from this login flow
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
            'username' => ['nullable', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => __('admin.validation_name_required'),
            'username.unique' => __('admin.validation_username_unique'),
            'email.required' => __('admin.validation_email_required'),
            'email.email' => __('admin.validation_email_invalid'),
            'email.unique' => __('admin.validation_email_unique'),
            'password.required' => __('admin.validation_password_required'),
            'password.min' => __('admin.validation_password_min'),
            'password.confirmed' => __('admin.validation_password_confirmed'),
        ]);

        // Resolve the default client role for new registrations
        $clientRole = Role::where('name', 'client')->first();

        if (!$clientRole) {
            return back()->withErrors([
                'email' => __('admin.register_error_message'),
            ])->withInput();
        }

        // Create the user with an optional username
        User::create([
            'name' => $validated['name'],
            'username' => !empty($validated['username']) ? $validated['username'] : null,
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $clientRole->id,
        ]);

        return redirect()->route('login')->with('register_success', true);
    }

    /**
     * Check whether a username already exists.
     */
    public function checkUsername(Request $request)
    {
        $username = trim((string) $request->query('username', ''));

        // Username is optional, so an empty value is always valid
        if ($username === '') {
            return response()->json([
                'exists' => false,
                'message' => '',
            ]);
        }

        $exists = User::where('username', $username)->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists
                ? __('admin.validation_username_unique')
                : '',
        ]);
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}