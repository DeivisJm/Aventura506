<?php

namespace App\Services;

use App\Mail\SubscriberNewContentMail;
use App\Models\Accommodation;
use App\Models\Subscriber;
use App\Models\Tour;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SubscriberNotificationService
{
    /**
     * Send a notification email to all subscribers for a new tour.
     */
    public function sendNewTourNotification(Tour $tour): void
    {
        $content = [
            'type_es' => 'Nuevo tour disponible',
            'type_en' => 'New tour available',
            'title_es' => $tour->name['es'] ?? '',
            'title_en' => $tour->name['en'] ?? '',
            'description_es' => Str::limit(strip_tags($tour->description['es'] ?? ''), 180),
            'description_en' => Str::limit(strip_tags($tour->description['en'] ?? ''), 180),
            'url' => route('tours.show', $tour->slug),
        ];

        $this->sendToAllSubscribers($content);
    }

    /**
     * Send a notification email to all subscribers for a new accommodation.
     */
    public function sendNewAccommodationNotification(Accommodation $accommodation): void
    {
        $content = [
            'type_es' => 'Nuevo hospedaje disponible',
            'type_en' => 'New accommodation available',
            'title_es' => $accommodation->name['es'] ?? '',
            'title_en' => $accommodation->name['en'] ?? '',
            'description_es' => Str::limit(strip_tags($accommodation->short_description['es'] ?? ''), 180),
            'description_en' => Str::limit(strip_tags($accommodation->short_description['en'] ?? ''), 180),
            'url' => $accommodation->external_url,
        ];

        $this->sendToAllSubscribers($content);
    }

    /**
     * Send the notification email individually to every subscriber.
     */
    protected function sendToAllSubscribers(array $content): void
    {
        Subscriber::query()
            ->select('id', 'email')
            ->orderBy('id')
            ->chunk(100, function ($subscribers) use ($content) {
                foreach ($subscribers as $subscriber) {
                    try {
                        Mail::to($subscriber->email)->send(
                            new SubscriberNewContentMail($content)
                        );
                    } catch (\Throwable $e) {
                        Log::error('Failed sending subscriber notification.', [
                            'subscriber_id' => $subscriber->id,
                            'subscriber_email' => $subscriber->email,
                            'message' => $e->getMessage(),
                        ]);
                    }
                }
            });
    }
}