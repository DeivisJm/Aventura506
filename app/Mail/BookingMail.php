<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;

class BookingMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
    /**
     * Build the email message.
     */
    public function build()
    {
        return $this
            // Subject translated according to current locale
            ->subject(__('booking.email_subject'))
            ->view('emails.booking');
    }
}
