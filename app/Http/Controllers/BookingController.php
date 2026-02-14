<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingMail;

class BookingController extends Controller
{
    /**
     * Handle incoming booking request and send email notification.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email',
            'phone'       => 'required|string|max:30',
            'persons'     => 'required|integer|min:1',
            'nationality' => 'required|string|max:255',
            'date'        => 'required|date',
            'time'        => 'required|string',
            'total'       => 'required|numeric|min:0'
        ]);

        Mail::to('info.aventura506@gmail.com')
            ->send(new BookingMail($validated));

        return back()->with('booking_success', true);
    }
}
