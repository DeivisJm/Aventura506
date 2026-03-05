@extends('admin.layouts.admin')

@section('admin-content')

<h1 class="admin-page-title mb-10">

    Nuevo Tipo de Cambio

</h1>

<div class="admin-card">

    <form method="POST"
        action="{{ route('admin.exchange_rates.store') }}">

        @csrf

        <div class="admin-grid">

            <div class="admin-field">

                <label>Moneda origen</label>

                <select name="from_currency" class="admin-input">

                    <option value="USD" selected>USD</option>

                </select>

            </div>

            <div class="admin-field">

                <label>Moneda destino</label>

                <select name="to_currency" class="admin-input">

                    <option value="CRC" selected>CRC</option>

                </select>

            </div>

        </div>


        <div class="admin-field mt-6">

            <label>Valor del tipo de cambio</label>

            <input
                type="number"
                step="0.01"
                name="value"
                class="admin-input"
                placeholder="520">

        </div>

        <button class="admin-btn-primary mt-6">

            Guardar tipo de cambio

        </button>

    </form>

</div>

@endsection