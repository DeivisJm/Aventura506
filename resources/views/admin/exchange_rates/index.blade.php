@extends('admin.layouts.admin')

@section('admin-content')

<div class="flex justify-between items-center mb-10">

    <div>

        <h1 class="admin-page-title">
            Tipos de Cambio
        </h1>

        <p class="admin-page-subtitle">
            Administración del tipo de cambio utilizado en el sistema
        </p>

    </div>

    <a href="{{ route('admin.exchange_rates.create') }}"
        class="admin-btn-primary">

        + Nuevo tipo de cambio

    </a>

</div>



<div class="admin-card">

    <table class="admin-table">

        <thead>

            <tr>

                <th>Moneda</th>
                <th>Tipo de cambio</th>
                <th>Última actualización</th>
                <th>Acciones</th>

            </tr>

        </thead>

        <tbody>

            @forelse($rates as $rate)

            @php
            $parts = explode('_to_', $rate->key);
            @endphp

            <tr>

                <td>

                    <strong>
                        {{ strtoupper($parts[0]) }} → {{ strtoupper($parts[1]) }}
                    </strong>

                </td>

                <td class="rate-value">

                    ₡ {{ number_format($rate->value,2) }}

                </td>

                <td class="text-gray-500 text-sm">

                    {{ $rate->updated_at->format('d M Y H:i') }}

                </td>

                <td class="table-actions">

                    <a
                        href="{{ route('admin.exchange_rates.edit',$rate) }}"
                        class="admin-btn-edit">

                        Editar

                    </a>


                    <form
                        method="POST"
                        action="{{ route('admin.exchange_rates.destroy',$rate) }}">

                        @csrf
                        @method('DELETE')

                        <button
                            class="admin-btn-delete"
                            onclick="return confirm('¿Eliminar este tipo de cambio?')">

                            Eliminar

                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="4" class="text-center py-10 text-gray-500">

                    No hay tipos de cambio registrados

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection