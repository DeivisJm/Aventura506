<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::post('/translate', function (Request $request) {

    $response = Http::post('https://libretranslate.de/translate', [
        'q'      => $request->text,
        'source' => 'es',
        'target' => $request->target,
        'format' => 'text',
    ]);

    return response()->json($response->json());
});
