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

        Nuevo tipo de cambio

    </a>

</div>

<div class="admin-card">

    <table class="admin-table">

        <thead>
            <tr>
                <th>Moneda</th>
                <th>Tipo de cambio</th>
                <th>Última actualización</th>
                <th class="text-right">Acciones</th>
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
                    ₡ {{ number_format($rate->value, 2) }}
                </td>

                <td class="text-gray-500 text-sm dark:text-gray-400">
                    {{ $rate->updated_at->format('d M Y H:i') }}
                </td>

                <td class="users-actions-cell">
                    <div class="users-actions">


                        <a
                            href="{{ route('admin.exchange_rates.edit', $rate) }}"
                            class="users-btn users-btn-edit">

                            Editar

                        </a>

                        @php
                        $isLastRate = $rates->count() === 1;
                        @endphp

                        @if($isLastRate)
                        <button
                            type="button"
                            class="users-btn users-btn-delete users-btn-delete-disabled"
                            title="No se puede eliminar porque debe existir al menos un tipo de cambio en el sistema."
                            disabled>

                            Eliminar

                        </button>
                        @else
                        <form
                            method="POST"
                            action="{{ route('admin.exchange_rates.destroy', $rate) }}">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="users-btn users-btn-delete"
                                onclick="return confirm('¿Eliminar este tipo de cambio?')">

                                Eliminar

                            </button>

                        </form>
                        @endif


                    </div>
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="4" class="text-center py-10 text-gray-500 dark:text-gray-400">
                    No hay tipos de cambio registrados
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection