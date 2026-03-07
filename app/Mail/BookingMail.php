<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Symfony\Component\Mime\Email;

class BookingMail extends Mailable
{
    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('booking.email_subject'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking',
            with: [
                'booking' => $this->booking,
            ],
        );
    }

    public function build()
    {
        return $this->withSymfonyMessage(function (Email $message) {
            $message->embedFromPath(
                public_path('images/logos/logo.png'),
                'logo',
                'image/png'
            );
        });
    }
}
