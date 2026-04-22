<div class="admin-page">

    @php
        $isEditing = $method === 'PUT';
    @endphp

    <div class="admin-page-header">
        <h1 class="admin-page-title">{{ $title }}</h1>
        <p class="admin-page-subtitle">{{ $subtitle }}</p>
    </div>

    {{-- Validation modal --}}
    <div
        id="company-validation-alert"
        class="form-validation-modal {{ $errors->any() ? 'is-open' : '' }}"
        data-validation-alert
        aria-hidden="{{ $errors->any() ? 'false' : 'true' }}">

        <div class="form-validation-modal__backdrop" data-alert-close></div>

        <div
            class="form-validation-modal__dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="company-validation-title">

            <div class="form-validation-modal__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v5m0 4h.01M10.29 3.86l-7.4 12.82A2 2 0 004.63 20h14.74a2 2 0 001.74-3.32l-7.4-12.82a2 2 0 00-3.48 0z" />
                </svg>
            </div>

            <div class="form-validation-modal__content">
                <h3 id="company-validation-title" class="form-validation-modal__title">
                    {{ $isEditing ? 'No se pudo actualizar la compañía' : 'No se pudo crear la compañía' }}
                </h3>

                <p class="form-validation-modal__text">
                    Revisa los campos marcados y corrige los errores antes de continuar.
                </p>

                <ul class="form-validation-modal__list" data-validation-alert-list>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="form-validation-modal__actions">
                <button type="button" class="form-validation-modal__close" data-alert-close>
                    Cerrar y revisar
                </button>
            </div>
        </div>
    </div>

    {{-- Server-side validation errors --}}
    <script type="application/json" id="company-server-errors-json">
        {!! json_encode($errors->messages(), JSON_UNESCAPED_UNICODE) !!}
    </script>

    <form method="POST" action="{{ $action }}" class="admin-form" id="company-form" novalidate>
        @csrf
        @if($method === 'PUT')
        @method('PUT')
        @endif

        <section class="admin-card">

            <div class="admin-card-header">
                <div>
                    <h2 class="admin-section-title">Información de la compañía</h2>
                    <p class="admin-help">
                        Esta información será utilizada por todos los tours vinculados a esta compañía.
                    </p>
                </div>
            </div>

            <div class="form-section">

                <div class="form-card">

                    <div class="form-card-header">
                        <h3 class="form-card-title">Datos principales</h3>
                    </div>

                    <div class="form-grid">

                        <div class="form-field">
                            <label class="form-label" for="company-name">Nombre</label>
                            <input
                                type="text"
                                id="company-name"
                                name="name"
                                value="{{ old('name', $company->name ?? '') }}"
                                class="form-input"
                                data-validate="text"
                                required>
                        </div>

                        <div class="form-field">
                            <label class="form-label" for="company-email">Correo</label>
                            <input
                                type="email"
                                id="company-email"
                                name="email"
                                value="{{ old('email', $company->email ?? '') }}"
                                class="form-input"
                                data-validate="email"
                                required>
                        </div>

                    </div>

                    <div class="form-grid">

                        <div class="form-field">
                            <label class="form-label" for="company-phone">Teléfono</label>
                            <input
                                type="text"
                                id="company-phone"
                                name="phone"
                                value="{{ old('phone', $company->phone ?? '') }}"
                                class="form-input"
                                inputmode="numeric"
                                placeholder="88888888"
                                data-validate="phone"
                                required>
                        </div>

                        <div class="form-field">
                            <label class="form-label" for="company-location">Ubicación</label>
                            <input
                                type="text"
                                id="company-location"
                                name="location_name"
                                value="{{ old('location_name', $company->location_name ?? '') }}"
                                class="form-input"
                                placeholder="Ej: La Fortuna, San Carlos"
                                data-validate="location"
                                required>
                        </div>

                    </div>

                    <div class="form-field">

                        <label class="form-label" for="company_map_embed_url">Mapa embebido</label>

                        <textarea
                            name="map_embed_url"
                            id="company_map_embed_url"
                            class="form-textarea"
                            placeholder="https://www.google.com/maps/embed?pb=..."
                            data-validate="url"
                            required>{{ old('map_embed_url', $company->map_embed_url ?? '') }}</textarea>

                        <p class="form-help">
                            Pega únicamente la URL del mapa embebido de Google Maps.
                        </p>

                    </div>

                    <div class="map-help-box">

                        <details class="map-help-details">
                            <summary class="map-help-summary">
                                <div class="map-help-summary-left">
                                    <span class="map-help-icon">📍</span>
                                    <div>
                                        <div class="map-help-title">Ver instrucciones para obtener la URL del mapa</div>
                                        <div class="map-help-subtitle">Guía rápida para copiar correctamente el enlace desde Google Maps</div>
                                    </div>
                                </div>

                                <span class="map-help-toggle">Ver pasos</span>
                            </summary>

                            <div class="map-help-content">

                                <div class="map-help-note">
                                    <strong>Importante:</strong> No copies el enlace normal del navegador. Debes copiar la URL del mapa embebido que aparece dentro de <strong>src="..."</strong>.
                                </div>

                                <ol class="map-help-steps">
                                    <li>Abre <strong>Google Maps</strong>.</li>
                                    <li>Busca la ubicación exacta de la compañía o punto de salida del tour.</li>
                                    <li>Haz clic sobre el lugar para abrir su ficha de información.</li>
                                    <li>Presiona <strong>Compartir</strong>.</li>
                                    <li>Selecciona <strong>Incorporar un mapa</strong>.</li>
                                    <li>Se mostrará un código HTML con una etiqueta <strong>iframe</strong>.</li>
                                    <li>Ubica el texto que aparece después de <strong>src="</strong>.</li>
                                    <li>Copia únicamente esa URL, desde <strong>https</strong> hasta antes de la comilla de cierre.</li>
                                    <li>Pega esa URL en el campo <strong>Mapa embebido</strong>.</li>
                                </ol>

                                <div class="map-help-example-box">
                                    <div class="map-help-example-title">Ejemplo de lo que sí debes copiar</div>
                                    <code class="map-help-code">https://www.google.com/maps/embed?pb=...</code>
                                </div>

                                <div class="map-help-example-box map-help-example-box-wrong">
                                    <div class="map-help-example-title">Ejemplo de lo que no debes pegar</div>
                                    <code class="map-help-code">src="https://www.google.com/maps/embed?pb=..."</code>
                                </div>

                            </div>
                        </details>

                    </div>

                    <div id="company-map-preview-wrapper"
                        class="admin-map-preview {{ old('map_embed_url', $company->map_embed_url ?? '') ? '' : 'hidden' }}">

                        <iframe
                            id="company-map-preview"
                            src="{{ old('map_embed_url', $company->map_embed_url ?? '') }}"
                            loading="lazy"
                            allowfullscreen>
                        </iframe>

                    </div>

                </div>

            </div>

        </section>

        <div class="mt-12">
            <button type="submit" class="admin-btn-primary">
                {{ $buttonText }}
            </button>
        </div>

    </form>

</div>