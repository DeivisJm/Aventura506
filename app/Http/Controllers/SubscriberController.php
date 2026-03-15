<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeSubscriberMail;
use Illuminate\Support\Facades\Validator;


class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => ['required', 'email', 'unique:subscribers,email'],
            ]
        );

        if ($validator->fails()) {
            return back()
                ->with('subscribe_error', __('subscribe.error_message'))
                ->withInput();
        }

        try {
            $subscriber = Subscriber::create([
                'email' => $request->email,
            ]);

            $locale = app()->getLocale();

            Mail::to($subscriber->email)
                ->send(new WelcomeSubscriberMail($locale));

            return back()->with('subscribe_success', true);
        } catch (\Throwable $e) {
            return back()
                ->with('subscribe_error', __('subscribe.error_message'))
                ->withInput();
        }
    }
}
