<div class="admin-page">

    <div class="admin-page-header">

        <h1 class="admin-page-title">
            {{ isset($accommodation->id) ? 'Editar Hospedaje' : 'Agregar Hospedaje' }}
        </h1>

        <p class="admin-page-subtitle">
            {{ isset($accommodation->id)
                ? 'Modifica la información del hospedaje seleccionado.'
                : 'Completa la información para crear un nuevo hospedaje.' }}
        </p>

    </div>
    @if ($errors->any())
    <div style="background:#fee2e2; color:#991b1b; padding:16px; border-radius:10px; margin-bottom:20px;">
        <strong>Errores de validación:</strong>
        <ul style="margin-top:10px;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST"
        action="{{ isset($accommodation->id) ? route('admin.accommodations.update', $accommodation) : route('admin.accommodations.store') }}"
        enctype="multipart/form-data"
        class="admin-form"
        id="accommodation-form"
        novalidate>

        @csrf

        <input type="hidden" name="active_tab" id="active-tab-input" value="{{ old('active_tab', session('active_tab', 'general')) }}">

        @if(isset($accommodation->id))
        @method('PUT')
        @endif

        {{-- TABS NAVIGATION --}}
        <div class="admin-tabs">

            <button type="button" class="admin-tab active" data-tab="general">
                General
            </button>

            <button type="button" class="admin-tab" data-tab="details">
                Detalles
            </button>

            <button type="button" class="admin-tab" data-tab="gallery">
                Imágenes
            </button>

        </div>

        {{-- GENERAL TAB --}}
        <div class="admin-tab-content active" id="general">

            <section class="admin-card">

                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-section-title">Información General</h2>
                        <p class="admin-help">
                            Configura la información principal del hospedaje que será visible en el sitio web.
                        </p>
                    </div>
                </div>

                <div class="form-section">

                    <div class="form-card">
                        <div class="form-card-header">
                            <h3 class="form-card-title">Información básica</h3>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="form-label">Nombre del hospedaje (Español)</label>
                                <input type="text" name="name[es]" value="{{ old('name.es', $accommodation->name['es'] ?? '') }}" class="form-input" required>
                            </div>

                            <div class="form-field">
                                <label class="form-label">Nombre del hospedaje (Inglés)</label>
                                <input type="text" name="name[en]" value="{{ old('name.en', $accommodation->name['en'] ?? '') }}" class="form-input" required>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="form-label">Slug del hospedaje</label>
                                <input type="text" name="slug" value="{{ old('slug', $accommodation->slug ?? '') }}" class="form-input" required>
                                <p class="form-help">Este texto se usa en la URL interna del hospedaje.</p>
                            </div>

                            <div class="form-field">
                                <label class="form-label">Nombre del anfitrión</label>
                                <input type="text" name="host_name" value="{{ old('host_name', $accommodation->host_name ?? '') }}" class="form-input" placeholder="Ej: Jorge Mario">
                            </div>
                        </div>
                    </div>

                    <div class="form-card">
                        <div class="form-card-header">
                            <h3 class="form-card-title">Ubicación y contacto</h3>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="form-label">Ubicación</label>
                                <input type="text" name="location" value="{{ old('location', $accommodation->location ?? '') }}" class="form-input" required>
                            </div>

                            <div class="form-field">
                                <label class="form-label">Teléfono</label>
                                <input type="text" name="phone" value="{{ old('phone', $accommodation->phone ?? '') }}" class="form-input" placeholder="Ej: +506 8888 8888">
                            </div>
                        </div>

                        <div class="form-field">
                            <label class="form-label">Enlace externo</label>
                            <input type="url" name="external_url" value="{{ old('external_url', $accommodation->external_url ?? '') }}" class="form-input" placeholder="https://www.airbnb.com/..." required>
                            <p class="form-help">Este será el enlace de redirección hacia Airbnb u otra plataforma externa.</p>
                        </div>
                    </div>

                </div>

            </section>

        </div>

        {{-- DETAILS TAB --}}
        <div class="admin-tab-content" id="details">

            <section class="admin-card">

                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-section-title">Detalles del hospedaje</h2>
                        <p class="admin-help">
                            Configura descripción, capacidad y amenidades.
                        </p>
                    </div>
                </div>

                <div class="form-section">

                    <div class="form-card">
                        <div class="form-card-header">
                            <h3 class="form-card-title">Descripción corta</h3>
                        </div>

                        <p class="form-help">
                            Este texto aparece en las tarjetas del hospedaje.
                        </p>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="form-label">Español</label>
                                <textarea name="short_description[es]" class="form-textarea" required>{{ old('short_description.es', $accommodation->short_description['es'] ?? '') }}</textarea>
                            </div>

                            <div class="form-field">
                                <label class="form-label">English</label>
                                <textarea name="short_description[en]" class="form-textarea" required>{{ old('short_description.en', $accommodation->short_description['en'] ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-card">
                        <div class="form-card-header">
                            <h3 class="form-card-title">Capacidad del hospedaje</h3>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="form-label">Huéspedes</label>
                                <input type="number" name="guests" min="1" value="{{ old('guests', $accommodation->guests ?? 1) }}" class="form-input" required>
                            </div>

                            <div class="form-field">
                                <label class="form-label">Habitaciones</label>
                                <input type="number" name="bedrooms" min="0" value="{{ old('bedrooms', $accommodation->bedrooms ?? 0) }}" class="form-input" required>
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="form-label">Camas</label>
                                <input type="number" name="beds" min="0" value="{{ old('beds', $accommodation->beds ?? 0) }}" class="form-input" required>
                            </div>

                            <div class="form-field">
                                <label class="form-label">Baños</label>
                                <input type="number" name="bathrooms" min="0" value="{{ old('bathrooms', $accommodation->bathrooms ?? 0) }}" class="form-input" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-card">
                        <div class="form-card-header">
                            <h3 class="form-card-title">Amenidades</h3>
                        </div>

                        <div class="form-field">
                            <label class="form-label">Amenidades separadas por coma</label>
                            <input
                                type="text"
                                name="amenities"
                                value="{{ old('amenities', isset($accommodation->amenities) && is_array($accommodation->amenities) ? implode(', ', $accommodation->amenities) : '') }}"
                                class="form-input"
                                placeholder="wifi, kitchen, free_parking, jacuzzi">

                            <p class="form-help">
                                Usa comas para separar cada amenidad. Ejemplo: wifi, kitchen, free_parking
                            </p>
                        </div>
                    </div>

                </div>

            </section>

        </div>

        {{-- GALLERY TAB --}}
        <div class="admin-tab-content" id="gallery">

            <section class="admin-card">

                <div class="admin-card-header">
                    <div>
                        <h2 class="admin-section-title">Imágenes del hospedaje</h2>
                        <p class="admin-help">
                            Carga la imagen principal y administra la galería del hospedaje.
                        </p>
                    </div>
                </div>

                <div class="form-section">

                    {{-- MAIN IMAGE --}}
                    <div class="form-card accommodation-gallery-card">

                        <div class="form-card-header accommodation-gallery-header">
                            <div>
                                <h3 class="form-card-title">Imagen principal</h3>
                                <p class="form-help mt-1">
                                    Selecciona la imagen principal que representará el hospedaje.
                                </p>
                            </div>
                        </div>

                        <label class="accommodation-main-dropzone" for="main-image-input">
                            <input
                                type="file"
                                name="main_image"
                                id="main-image-input"
                                class="form-input-file"
                                accept="image/*">

                            <span class="accommodation-dropzone-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-10 h-10">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2 1.586-1.586a2 2 0 012.828 0L20 14m-10-4h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>

                            <span class="accommodation-dropzone-title">Seleccionar imagen principal</span>
                            <span class="accommodation-dropzone-text">JPG, PNG o WEBP</span>
                        </label>

                        <div class="accommodation-main-preview-list" id="main-image-preview-wrapper">
                            @if(!empty($accommodation->main_image))
                            <div class="accommodation-main-preview-card" id="main-image-preview-card">
                                <img
                                    id="main-image-preview"
                                    src="{{ asset($accommodation->main_image) }}"
                                    alt="Main image preview"
                                    class="accommodation-main-preview-image">
                            </div>
                            @else
                            <div class="accommodation-main-preview-card hidden" id="main-image-preview-card">
                                <img
                                    id="main-image-preview"
                                    src=""
                                    alt="Main image preview"
                                    class="accommodation-main-preview-image">
                            </div>
                            @endif
                        </div>

                    </div>

                    {{-- GALLERY --}}
                    <div class="form-card accommodation-gallery-card">

                        <div class="form-card-header accommodation-gallery-header">
                            <div>
                                <h3 class="form-card-title">Galería de imágenes</h3>
                                <p class="form-help mt-1">
                                    Puedes agregar hasta 7 imágenes en total. Si deseas subir más, primero quita alguna imagen actual o seleccionada.
                                </p>
                            </div>

                            <button
                                type="button"
                                id="add-gallery-image-btn"
                                class="accommodation-gallery-add-btn">
                                <span class="accommodation-gallery-add-btn-icon">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                                    </svg>
                                </span>
                                <span>Agregar imágenes</span>
                            </button>
                        </div>

                        <label class="accommodation-gallery-dropzone" for="gallery-images-input">
                            <input
                                type="file"
                                id="gallery-images-input"
                                class="form-input-file"
                                accept="image/*"
                                multiple>

                            <span class="accommodation-dropzone-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-10 h-10">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2 1.586-1.586a2 2 0 012.828 0L20 14m-10-4h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>

                            <span class="accommodation-dropzone-title">Seleccionar imágenes para la galería</span>
                            <span class="accommodation-dropzone-text">Puedes seleccionar una o varias imágenes por vez</span>
                        </label>

                        <input
                            type="file"
                            name="gallery_images[]"
                            id="gallery-images-store"
                            style="position:absolute; left:-9999px; width:1px; height:1px; opacity:0;"
                            multiple>

                        <input
                            type="file"
                            name="gallery_images[]"
                            id="gallery-images-store"
                            style="position:absolute; left:-9999px; width:1px; height:1px; opacity:0;"
                            multiple>

                        @php
                        $existingGalleryImages = is_array($accommodation->gallery_images ?? null)
                        ? $accommodation->gallery_images
                        : [];
                        @endphp

                        <div
                            class="accommodation-gallery-counter"
                            id="gallery-counter"
                            data-max="7"
                            data-existing-count="{{ count($existingGalleryImages) }}">
                            0 / 7 imágenes seleccionadas
                        </div>

                        <div class="accommodation-gallery-preview-grid" id="gallery-preview-grid"></div>

                        @if(!empty($existingGalleryImages))
                        <div class="mt-6">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-4">
                                Imágenes actuales
                            </h4>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4" id="existing-gallery-grid">
                                @foreach($existingGalleryImages as $index => $image)
                                <label
                                    class="block accommodation-existing-gallery-item"
                                    data-existing-gallery-item>
                                    <img
                                        src="{{ asset($image) }}"
                                        alt="Gallery image {{ $index + 1 }}"
                                        class="w-full h-28 object-cover rounded-xl border border-gray-200 dark:border-gray-700">

                                    <span class="mt-2 inline-flex items-center gap-2 text-sm text-red-600">
                                        <input
                                            type="checkbox"
                                            name="gallery_remove[]"
                                            value="{{ $index }}"
                                            class="existing-gallery-remove-checkbox">
                                        Quitar esta imagen
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    </div>

                </div>

            </section>

        </div>

        <div class="mt-12">
            <button type="submit" class="admin-btn-primary">
                {{ isset($accommodation->id) ? 'Actualizar Hospedaje' : 'Crear Hospedaje' }}
            </button>
        </div>

    </form>

</div>