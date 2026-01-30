<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        try {
            Mail::send([], [], function ($mail) use ($data) {
                $mail->to('ds.aventura506@gmail.com')
                     ->from($data['email'], $data['name'])
                     ->subject('Nuevo mensaje desde Aventura506')
                     ->html("
                        <strong>Nombre:</strong> {$data['name']}<br>
                        <strong>Email:</strong> {$data['email']}<br><br>
                        <strong>Mensaje:</strong><br>
                        {$data['message']}
                     ");
            });

            return back()->with('success', 'Tu mensaje fue enviado correctamente.');

        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo enviar el mensaje. Intentá nuevamente.');
        }
    }
}
