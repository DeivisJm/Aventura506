<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;

class WelcomeSubscriberMail extends Mailable
{
    use SerializesModels;

    public $locale;

    public function __construct($locale)
    {
        $this->locale = $locale;
    }

    public function build()
    {
        app()->setLocale($this->locale);

        return $this->subject(__('subscribe.email_subject'))
            ->view('emails.subscribe-welcome')
            ->withSymfonyMessage(function (Email $message) {
                $message->embedFromPath(
                    public_path('images/logo.png'),
                    'logo',
                    'image/png'
                );
            });
    }
}