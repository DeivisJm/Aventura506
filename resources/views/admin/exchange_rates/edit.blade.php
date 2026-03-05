@extends('admin.layouts.admin')

@section('admin-content')

<div class="mb-10">

    <h1 class="admin-page-title">

        Editar Tipo de Cambio

    </h1>

    <p class="admin-page-subtitle">

        Actualiza el valor del tipo de cambio utilizado por el sistema

    </p>

</div>



<div class="admin-card">

    <form
        method="POST"
        action="{{ route('admin.exchange_rates.update',$exchangeRate) }}">

        @csrf
        @method('PUT')


        @php
        $parts = explode('_to_', $exchangeRate->key);
        @endphp



        <div class="admin-grid">

            <div class="admin-field">

                <label class="admin-label">

                    Moneda origen

                </label>

                <input
                    type="text"
                    value="{{ strtoupper($parts[0]) }}"
                    disabled
                    class="admin-input">

            </div>



            <div class="admin-field">

                <label class="admin-label">

                    Moneda destino

                </label>

                <input
                    type="text"
                    value="{{ strtoupper($parts[1]) }}"
                    disabled
                    class="admin-input">

            </div>

        </div>



        <div class="admin-field mt-6">

            <label class="admin-label">

                Valor del tipo de cambio

            </label>

            <input
                type="number"
                step="0.01"
                name="value"
                value="{{ $exchangeRate->value }}"
                class="admin-input">

            <p class="admin-help">

                Ejemplo: si 1 USD = 520 CRC, entonces el valor es <strong>520</strong>.

            </p>

        </div>



        <button
            class="admin-btn-primary mt-8">

            Actualizar tipo de cambio

        </button>

    </form>

</div>

@endsection