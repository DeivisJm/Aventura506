<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Mail\BookingMail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\TourPrice;
use App\Models\Tour;
use Carbon\Carbon;

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
            'notes'       => 'nullable|string|max:1000',
            'date'        => 'required',
            'time'        => 'required|string|max:20',
            'prices'      => 'required|array',
            'currency'    => 'required|in:USD,CRC',
        ]);

        $selectedPrices = array_filter($validated['prices'], fn($qty) => (int) $qty > 0);

        if (count($selectedPrices) === 0) {
            return back()->withErrors([
                'prices' => 'You must select at least one ticket.'
            ])->withInput();
        }

        DB::beginTransaction();

        try {

            $tour = Tour::findOrFail($validated['tour_id']);

            $totalUsd = 0;
            $persons = 0;

            $selectedCurrency = $validated['currency'];

            //change tip form settings (default 500) 
            $exchangeRate = (float) \App\Models\Setting::getValue('usd_to_crc', 500);

            $formattedDate = Carbon::parse($validated['date'])->format('Y-m-d');
            $formattedTime = Carbon::parse($validated['time'])->format('H:i:s');

            $booking = Booking::create([
                'tour_id'           => $tour->id,
                'guest_name'        => $validated['name'],
                'guest_email'       => $validated['email'],
                'guest_phone'       => $validated['phone'],
                'guest_nationality' => $validated['nationality'],
                'notes'             => $validated['notes'],
                'date'              => $formattedDate,
                'time'              => $formattedTime,
                'total'             => 0,
                'status'            => 'pending',
            ]);

            foreach ($validated['prices'] as $priceId => $quantity) {

                if ($quantity > 0) {

                    $tourPrice = TourPrice::findOrFail($priceId);

                    //price in USD always 
                    $priceInUsd = $tourPrice->price;

                    //convert to CRC 
                    $priceInCrc = $priceInUsd * $exchangeRate;

                    BookingDetail::create([
                        'booking_id'    => $booking->id,
                        'tour_price_id' => $tourPrice->id,
                        'quantity'      => $quantity,
                        'price'         => $priceInUsd,
                        'price_usd'     => $priceInUsd,
                        'price_crc'     => $priceInCrc,
                    ]);

                    if (!$tourPrice->is_free) {
                        $totalUsd += $quantity * $priceInUsd;
                    }

                    $persons += $quantity;
                }
            }

            $totalCrc = $totalUsd * $exchangeRate;

            $totalDisplay = $selectedCurrency === 'CRC'
                ? $totalCrc
                : $totalUsd;

            $booking->update([
                'persons'       => $persons,
                'total'         => $totalDisplay,
                'currency'      => $selectedCurrency,
                'exchange_rate' => $exchangeRate,
                'total_usd'     => $totalUsd,
                'total_crc'     => $totalCrc,
                'total_display' => $totalDisplay,
            ]);

            $booking->load('details.tourPrice');

            $pdf = Pdf::loadView('emails.booking-pdf', [
                'booking' => $booking
            ]);

            $pdfContent = $pdf->output();

            Mail::to(config('mail.booking_receiver'))
                ->cc($booking->guest_email)
                ->send(
                    (new BookingMail($booking))
                        ->attachData($pdfContent, 'booking.pdf', [
                            'mime' => 'application/pdf',
                        ])
                );

            DB::commit();

            return redirect()
                ->route('tours.show', $tour->slug)
                ->with('booking_success', 'Booking sent successfully!');
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('BOOKING ERROR: ' . $e->getMessage());

            return redirect()
                ->route('tours.show', $tour->slug)
                ->with('booking_error', 'There was a problem processing your booking. Please try again.');
        }
    }
}
