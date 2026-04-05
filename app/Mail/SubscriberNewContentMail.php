<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Email;

class SubscriberNewContentMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $content;

    public function __construct(array $content)
    {
        $this->content = $content;
    }

    public function build()
    {
        return $this->subject(__('subscriber_notifications.email_subject'))
            ->withSymfonyMessage(function (Email $message) {
                $message->embedFromPath(
                    public_path('images/logos/logo.png'),
                    'logo',
                    'image/png'
                );
            })
            ->view('emails.subscriber-new-content');
    }
}