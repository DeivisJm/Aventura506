<div class="admin-page">

    <div class="admin-page-header">
        <h1 class="admin-page-title">{{ $title }}</h1>
        <p class="admin-page-subtitle">{{ $subtitle }}</p>
    </div>

    <form method="POST" action="{{ $action }}" class="admin-form">
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
                            <label class="form-label">Nombre</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $company->name ?? '') }}"
                                class="form-input"
                                required>
                        </div>

                        <div class="form-field">
                            <label class="form-label">Correo</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $company->email ?? '') }}"
                                class="form-input">
                        </div>

                    </div>

                    <div class="form-grid">

                        <div class="form-field">
                            <label class="form-label">Teléfono</label>
                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone', $company->phone ?? '') }}"
                                class="form-input">
                        </div>

                        <div class="form-field">
                            <label class="form-label">Ubicación</label>
                            <input
                                type="text"
                                name="location_name"
                                value="{{ old('location_name', $company->location_name ?? '') }}"
                                class="form-input">
                        </div>

                    </div>

                    <div class="form-field">

                        <label class="form-label">Mapa embebido</label>

                        <textarea
                            name="map_embed_url"
                            id="company_map_embed_url"
                            class="form-textarea"
                            placeholder="https://www.google.com/maps/embed?pb=...">{{ old('map_embed_url', $company->map_embed_url ?? '') }}</textarea>

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