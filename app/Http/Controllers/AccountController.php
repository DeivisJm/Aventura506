<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Display the authenticated user's profile page.
     */
    public function profile()
    {
        /** @var User $user */
        $user = Auth::user();

        return view('account.profile', compact('user'));
    }

    /**
     * Update the authenticated user's profile information.
     */
    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'username' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($user->id),
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        /* Update basic user information */
        $user->name = $validated['name'];
        $user->username = $validated['username'] ?? null;
        $user->email = $validated['email'];

        /* Update password only when a new one is provided */
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('account.profile')
            ->with('success', __('profile.profile_updated_success'));
    }

    /**
     * Display bookings associated with the authenticated user.
     * Matches records by user_id when available, and also by guest_email.
     */
    public function bookings()
    {
        /** @var User $user */
        $user = Auth::user();

        $bookings = Booking::with(['tour'])
            ->where(function ($query) use ($user) {
                $query->where('guest_email', $user->email);

                if (!is_null($user->id)) {
                    $query->orWhere('user_id', $user->id);
                }
            })
            ->latest()
            ->get();

        return view('account.bookings', compact('user', 'bookings'));
    }
}