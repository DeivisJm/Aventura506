<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingMail;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    /**
     * Handle incoming booking request.
     * Validates data, generates PDF and sends email via SMTP (Gmail).
     */
    public function store(Request $request)
    {
        // -------------------------------------------------
        // Validate incoming request
        // -------------------------------------------------
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

            // -------------------------------------------------
            // Generate localized PDF
            // -------------------------------------------------
            $pdf = Pdf::loadView('emails.booking-pdf', [
                'data' => $validated
            ])->setPaper('a4');

            $pdfContent = $pdf->output();

            // Dynamic PDF filename (professional touch)
            $fileName = 'Aventura506-Booking-' . now()->format('YmdHis') . '.pdf';

            // -------------------------------------------------
            // Send email with PDF attachment
            // -------------------------------------------------
            Mail::to(config('mail.booking_receiver'))      // Admin email
                ->cc($validated['email'])                  // Customer copy
                ->send(
                    (new BookingMail($validated))
                        ->attachData($pdfContent, $fileName, [
                            'mime' => 'application/pdf',
                        ])
                );

            // -------------------------------------------------
            // Success response
            // -------------------------------------------------
            return back()->with('booking_success', true);
        } catch (\Throwable $e) {

            // -------------------------------------------------
            // Log error for debugging
            // -------------------------------------------------
            Log::error('Booking email failed', [
                'error' => $e->getMessage(),
                'booking_data' => $validated
            ]);

            // -------------------------------------------------
            // Error response
            // -------------------------------------------------
            return back()->with('booking_error', true);
        }
    }
}
