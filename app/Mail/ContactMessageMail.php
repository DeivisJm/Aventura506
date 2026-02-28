<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('info.aventura506@gmail.com', 'Aventura506 Website'),
            replyTo: [
                new Address(
                    $this->data['email'],
                    $this->data['name']
                )
            ],
            subject: 'New Contact Message - Aventura506'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-message'
        );
    }
}
