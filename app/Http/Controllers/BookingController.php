<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingMail;

class BookingController extends Controller
{
    /**
     * Handle incoming booking request.
     * Validates data and sends email using SMTP (Gmail).
     * Returns localized success or error feedback.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'required|string|max:30',
            'persons'     => 'required|integer|min:1',
            'nationality' => 'required|string|max:255',
            'date'        => 'required|date',
            'time'        => 'required|string|max:20',
            'total'       => 'required|numeric|min:0'
        ]);

        try {

            // Send email to business
            Mail::to(config('mail.booking_receiver'))
                ->send(new BookingMail($validated));

            // Send copy to customer
            Mail::to($validated['email'])
                ->send(new BookingMail($validated));

            return back()->with('booking_success', true);
        } catch (\Throwable $e) {

            Log::error('Booking email failed', [
                'error' => $e->getMessage(),
            ]);

            return back()->with('booking_error', true);
        }
    }
}
