<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\BookingMail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\TourPrice;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tour_id'     => 'required|exists:tours,id',
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|max:255',
            'phone'       => 'required|string|max:30',
            'nationality' => 'required|string|max:255',
            'date'        => 'required|date',
            'time'        => 'required|string|max:20',
            'prices'      => 'required|array',
        ]);

        $selectedPrices = array_filter($validated['prices'], function ($qty) {
            return (int) $qty > 0;
        });

        if (count($selectedPrices) === 0) {
            return back()->withErrors([
                'prices' => 'You must select at least one ticket.'
            ])->withInput();
        }


        try {

            $tour = \App\Models\Tour::findOrFail($validated['tour_id']);

            $total = 0;
            $persons = 0;

            $booking = Booking::create([
                'tour_id'     => $tour->id,
                'name'        => $validated['name'],
                'email'       => $validated['email'],
                'phone'       => $validated['phone'],
                'nationality' => $validated['nationality'],
                'persons'     => 0,
                'date'        => $validated['date'],
                'time'        => $validated['time'],
                'total'       => 0,
                'status'      => 'pending',
            ]);

            foreach ($validated['prices'] as $priceId => $quantity) {

                if ($quantity > 0) {

                    $tourPrice = TourPrice::findOrFail($priceId);

                    BookingDetail::create([
                        'booking_id'    => $booking->id,
                        'tour_price_id' => $tourPrice->id,
                        'quantity'      => $quantity,
                        'price'         => $tourPrice->price,
                    ]);

                    if (!$tourPrice->is_free) {
                        $total += $quantity * $tourPrice->price;
                    }

                    $persons += $quantity;
                }
            }

            $booking->update([
                'persons' => $persons,
                'total'   => $total,
            ]);

            $booking->load('details.tourPrice');

            $pdf = Pdf::loadView('emails.booking-pdf', [
                'booking' => $booking
            ]);

            $pdfContent = $pdf->output();

            Mail::to(config('mail.booking_receiver'))
                ->cc($booking->email)
                ->send(
                    (new BookingMail($booking))
                        ->attachData($pdfContent, 'booking.pdf', [
                            'mime' => 'application/pdf',
                        ])
                );

            return redirect()
                ->route('tours.show', $tour->slug)
                ->with('booking_success', true);
        } catch (\Throwable $e) {

            dd($e->getMessage());
        }
    }
}
