<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Symfony\Component\Mime\Email;

class BookingMail extends Mailable
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /*
    |--------------------------------------------------------------------------
    | Email Subject
    |--------------------------------------------------------------------------
    */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('booking.email_subject'),
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Email Content
    |--------------------------------------------------------------------------
    */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking',
            with: [
                'data' => $this->data,
            ],
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Attach logo inline using Symfony Mailer
    |--------------------------------------------------------------------------
    */
    public function build()
    {
        return $this->withSymfonyMessage(function (Email $message) {
            $message->embedFromPath(
                public_path('images/logo.png'),
                'logo',
                'image/png'
            );
        });
    }
}
