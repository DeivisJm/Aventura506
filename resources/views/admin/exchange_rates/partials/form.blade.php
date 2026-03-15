<div class="admin-page">

    <div class="admin-page-header">

        <h1 class="admin-page-title">
            {{ $exchangeRate ? 'Editar Tipo de Cambio' : 'Nuevo Tipo de Cambio' }}
        </h1>

        <p class="admin-page-subtitle">
            {{ $exchangeRate
                ? 'Actualiza el valor del tipo de cambio utilizado por el sistema.'
                : 'Registra un nuevo tipo de cambio para utilizarlo dentro del sistema.' }}
        </p>

    </div>

    <form method="POST"
        action="{{ $exchangeRate
            ? route('admin.exchange_rates.update', $exchangeRate)
            : route('admin.exchange_rates.store') }}"
        class="admin-form">

        @csrf

        @if($exchangeRate)
        @method('PUT')
        @endif

        @php
        $parts = $exchangeRate ? explode('_to_', $exchangeRate->key) : ['USD', 'CRC'];
        @endphp

        <section class="admin-card">

            <div class="admin-card-header">

                <div>
                    <h2 class="admin-section-title">
                        Información del Tipo de Cambio
                    </h2>

                    <p class="admin-help">
                        Configura la moneda de origen, la moneda de destino y el valor actual del cambio.
                    </p>
                </div>

            </div>

            <div class="form-section">

                {{-- BASIC INFO --}}
                <div class="form-card">

                    <div class="form-card-header">
                        <h3 class="form-card-title">Monedas</h3>
                    </div>

                    <div class="form-grid">

                        <div class="form-field">
                            <label class="form-label">Moneda origen</label>

                            @if($exchangeRate)
                            <input
                                type="text"
                                value="{{ strtoupper($parts[0]) }}"
                                class="form-input"
                                disabled>
                            @else
                            <select name="from_currency" class="form-input" required>
                                <option value="USD" selected>USD</option>
                            </select>
                            @endif
                        </div>

                        <div class="form-field">
                            <label class="form-label">Moneda destino</label>

                            @if($exchangeRate)
                            <input
                                type="text"
                                value="{{ strtoupper($parts[1]) }}"
                                class="form-input"
                                disabled>
                            @else
                            <select name="to_currency" class="form-input" required>
                                <option value="CRC" selected>CRC</option>
                            </select>
                            @endif
                        </div>

                    </div>

                </div>

                {{-- RATE VALUE --}}
                <div class="form-card">

                    <div class="form-card-header">
                        <h3 class="form-card-title">Valor del cambio</h3>
                    </div>

                    <div class="form-field">

                        <label class="form-label">Valor del tipo de cambio</label>

                        <input
                            type="number"
                            step="0.01"
                            name="value"
                            value="{{ old('value', $exchangeRate->value ?? '') }}"
                            class="form-input"
                            placeholder="520"
                            required>

                        @error('value')
                        <p class="form-help text-red-500">{{ $message }}</p>
                        @enderror

                    </div>

                </div>

            </div>

        </section>

        <div class="mt-12">
            <button type="submit" class="admin-btn-primary">
                {{ $exchangeRate ? 'Actualizar Tipo de Cambio' : 'Guardar Tipo de Cambio' }}
            </button>
        </div>

    </form>

</div>