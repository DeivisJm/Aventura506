<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class AdminExchangeRateController extends Controller
{

    public function index()
    {
        $rates = ExchangeRate::latest()->get();

        return view('admin.exchange_rates.index', compact('rates'));
    }

    public function create()
    {
        return view('admin.exchange_rates.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'from_currency' => 'required',
            'to_currency' => 'required',
            'value' => 'required|numeric'
        ]);

        $key = strtolower($request->from_currency . '_to_' . $request->to_currency);

        ExchangeRate::create([
            'key' => $key,
            'value' => $request->value
        ]);

        return redirect()
            ->route('admin.exchange_rates.index')
            ->with('success', 'Tipo de cambio creado');
    }

    public function edit(ExchangeRate $exchangeRate)
    {
        return view(
            'admin.exchange_rates.edit',
            compact('exchangeRate')
        );
    }

    public function update(Request $request, ExchangeRate $exchangeRate)
    {

        $request->validate([
            'value' => 'required|numeric'
        ]);

        $exchangeRate->update($request->all());

        return redirect()
            ->route('admin.exchange_rates.index')
            ->with('success', 'Tipo actualizado');
    }

    public function destroy(ExchangeRate $exchangeRate)
    {
        if (\App\Models\ExchangeRate::count() === 1) {
            return redirect()
                ->route('admin.exchange_rates.index')
                ->with('error', 'No se puede eliminar el tipo de cambio porque debe existir al menos uno en el sistema.');
        }

        $exchangeRate->delete();

        return redirect()
            ->route('admin.exchange_rates.index')
            ->with('success', 'Tipo de cambio eliminado correctamente.');
    }
}
