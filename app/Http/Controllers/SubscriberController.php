<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeSubscriberMail;

class SubscriberController extends Controller
{


    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email'
        ]);

        $subscriber = \App\Models\Subscriber::create([
            'email' => $request->email
        ]);

        $locale = app()->getLocale();

        Mail::to($subscriber->email)
            ->send(new WelcomeSubscriberMail($locale));

        return back()->with('subscribe_success', true);
    }
}
