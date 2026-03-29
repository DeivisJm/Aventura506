<?php

namespace App\Jobs;

use App\Mail\BookingMail;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendBookingEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $bookingId;

    /**
     * Create a new job instance.
     */
    public function __construct(int $bookingId)
    {
        $this->bookingId = $bookingId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $booking = Booking::with([
                'tour.company',
                'details.tourPrice',
            ])->find($this->bookingId);

            if (!$booking) {
                Log::warning('BOOKING MAIL JOB: booking not found', [
                    'booking_id' => $this->bookingId,
                ]);

                return;
            }

            $pdf = Pdf::loadView('emails.booking-pdf', [
                'booking' => $booking,
            ]);

            $pdfContent = $pdf->output();

            /* Main receiver */
            $to = [config('mail.booking_receiver')];

            /* CC recipients */
            $cc = [$booking->guest_email];

            if (!empty($booking->tour?->company?->email)) {
                $cc[] = $booking->tour->company->email;
            }

            /* Remove empty and duplicated emails */
            $to = array_values(array_unique(array_filter($to)));
            $cc = array_values(array_unique(array_filter($cc)));

            if (empty($to)) {
                Log::warning('BOOKING MAIL JOB: no main receiver configured', [
                    'booking_id' => $booking->id,
                ]);

                return;
            }

            Mail::to($to)
                ->cc($cc)
                ->send(
                    (new BookingMail($booking))
                        ->attachData($pdfContent, 'booking.pdf', [
                            'mime' => 'application/pdf',
                        ])
                );
        } catch (\Throwable $e) {
            Log::error('BOOKING MAIL JOB ERROR: ' . $e->getMessage(), [
                'booking_id' => $this->bookingId,
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }
}