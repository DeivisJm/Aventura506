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
        $validated = $request->validate([
            'tour_id'     => 'required|exists:tours,id',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'required|string|max:30',
            'persons'     => 'required|integer|min:1',
            'nationality' => 'required|string|max:255',
            'date'        => 'required|date',
            'time'        => 'required|string|max:20',
        ]);

        try {

            // Get tour to calculate price properly
            $tour = \App\Models\Tour::findOrFail($validated['tour_id']);

            $total = $tour->price * $validated['persons'];

            // Save booking to database
            $booking = \App\Models\Booking::create([
                'tour_id'    => $tour->id,
                'name'       => $validated['name'],
                'email'      => $validated['email'],
                'phone'      => $validated['phone'],
                'nationality' => $validated['nationality'],
                'persons'    => $validated['persons'],
                'date'       => $validated['date'],
                'time'       => $validated['time'],
                'total'      => $total,
                'status'     => 'pending',
            ]);

            // Generate PDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('emails.booking-pdf', [
                'data' => $booking
            ]);

            $pdfContent = $pdf->output();

            // Send email
            Mail::to(config('mail.booking_receiver'))
                ->cc($validated['email'])
                ->send(
                    (new \App\Mail\BookingMail($booking->toArray()))
                        ->attachData($pdfContent, 'booking.pdf', [
                            'mime' => 'application/pdf',
                        ])
                );

            return back()->with('booking_success', true);
        } catch (\Throwable $e) {

            Log::error('Booking email failed', [
                'error' => $e->getMessage(),
            ]);

            return back()->with('booking_error', true);
        }
    }
}
