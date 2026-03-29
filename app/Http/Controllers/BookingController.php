<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\TourPrice;
use App\Models\Tour;
use App\Models\ExchangeRate;
use App\Jobs\SendBookingEmailJob;
use Carbon\Carbon;

class BookingController extends Controller
{
    /**
     * Store a new booking request.
     */
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

        /*
        |--------------------------------------------------------------------------
        | Validate selected prices
        |--------------------------------------------------------------------------
        */
        $selectedPrices = array_filter(
            $validated['prices'],
            fn($qty) => (int) $qty > 0
        );

        if (count($selectedPrices) === 0) {
            return back()
                ->withErrors([
                    'prices' => __('booking.select_ticket_error'),
                ])
                ->withInput();
        }

        $tour = Tour::with('company')->findOrFail($validated['tour_id']);

        DB::beginTransaction();

        try {
            $totalUsd = 0;
            $persons = 0;

            $selectedCurrency = $validated['currency'];

            /*
            |--------------------------------------------------------------------------
            | Exchange rate
            |--------------------------------------------------------------------------
            | Fallback value is kept for safety.
            */
            $exchangeRate = (float) ExchangeRate::getValue('usd_to_crc', 500);

            $formattedDate = Carbon::parse($validated['date'])->format('Y-m-d');
            $formattedTime = Carbon::parse($validated['time'])->format('H:i:s');

            /*
            |--------------------------------------------------------------------------
            | Create booking
            |--------------------------------------------------------------------------
            */
            $booking = Booking::create([
                'tour_id'           => $tour->id,
                'guest_name'        => $validated['name'],
                'guest_email'       => $validated['email'],
                'guest_phone'       => $validated['phone'],
                'guest_nationality' => $validated['nationality'],
                'notes'             => $validated['notes'] ?? null,
                'date'              => $formattedDate,
                'time'              => $formattedTime,
                'total'             => 0,
                'status'            => 'pending',
                'currency'          => $selectedCurrency,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create booking details and compute totals
            |--------------------------------------------------------------------------
            */
            foreach ($validated['prices'] as $priceId => $quantity) {
                $quantity = (int) $quantity;

                if ($quantity <= 0) {
                    continue;
                }

                $tourPrice = TourPrice::findOrFail($priceId);

                $priceInUsd = (float) $tourPrice->price;
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

            $totalCrc = $totalUsd * $exchangeRate;

            $totalDisplay = $selectedCurrency === 'CRC'
                ? $totalCrc
                : $totalUsd;

            /*
            |--------------------------------------------------------------------------
            | Update booking totals
            |--------------------------------------------------------------------------
            */
            $booking->update([
                'persons'       => $persons,
                'total'         => $totalDisplay,
                'currency'      => $selectedCurrency,
                'exchange_rate' => $exchangeRate,
                'total_usd'     => $totalUsd,
                'total_crc'     => $totalCrc,
                'total_display' => $totalDisplay,
            ]);

            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | Send booking email asynchronously
            |--------------------------------------------------------------------------
            | The response is returned immediately. Email and PDF generation
            | happen later in a queued job.
            */
            SendBookingEmailJob::dispatch($booking->id);

            return redirect()
                ->route('tours.show', $tour->slug)
                ->with('booking_success', __('booking.success_message'));
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('BOOKING ERROR: ' . $e->getMessage(), [
                'tour_id' => $validated['tour_id'] ?? null,
                'email'   => $validated['email'] ?? null,
            ]);

            return redirect()
                ->route('tours.show', $tour->slug)
                ->with('booking_error', __('booking.error_message'))
                ->withInput();
        }
    }
}