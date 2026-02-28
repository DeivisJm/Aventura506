<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessageMail;

class ContactController extends Controller
{


    public function send(Request $request)
    {
        try {

            $request->validate([
                'name'    => 'required|string|max:100',
                'email'   => 'required|email',
                'message' => 'required|string|max:2000',
            ]);

            Mail::to('info.aventura506@gmail.com')
                ->send(new ContactMessageMail($request->only('name', 'email', 'message')));

            return back()->with('contact_success', true);
        } catch (\Exception $e) {

            return back()->with('contact_error', true);
        }
    }
}
