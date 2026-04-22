<div class="admin-page">

    @php
    $isEditing = isset($accommodation->id);
    $requiresMainImage = !$isEditing || empty($accommodation->main_image);
    @endphp

    <div class="admin-page-header">

        <h1 class="admin-page-title">
            {{ $isEditing ? 'Editar Hospedaje' : 'Agregar Hospedaje' }}
        </h1>

        <p class="admin-page-subtitle">
            {{ $isEditing
                ? 'Modifica la información del hospedaje seleccionado.'
                : 'Completa la información para crear un nuevo hospedaje.' }}
        </p>

    </div>

    {{-- Validation modal --}}
    <div
        id="accommodation-validation-alert"
        class="form-validation-modal {{ $errors->any() ? 'is-open' : '' }}"
        data-validation-alert
        aria-hidden="{{ $errors->any() ? 'false' : 'true' }}">

        <div class="form-validation-modal__backdrop" data-alert-close></div>

        <div
            class="form-validation-modal__dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="accommodation-validation-title">

            <div class="form-validation-modal__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v5m0 4h.01M10.29 3.86l-7.4 12.82A2 2 0 004.63 20h14.74a2 2 0 001.74-3.32l-7.4-12.82a2 2 0 00-3.48 0z" />
                </svg>
            </div>

            <div class="form-validation-modal__content">
                <h3 id="accommodation-validation-title" class="form-validation-modal__title">
                    {{ $isEditing ? 'No se pudo actualizar el hospedaje' : 'No se pudo crear el hospedaje' }}
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

    <form method="POST"
        action="{{ $isEditing ? route('admin.accommodations.update', $accommodation) : route('admin.accommodations.store') }}"
        enctype="multipart/form-data"
        class="admin-form"
        id="accommodation-form"
        data-submit-label="{{ $isEditing ? 'actualizar' : 'crear' }}"
        novalidate>

        @csrf

        <input type="hidden" name="active_tab" id="active-tab-input" value="{{ old('active_tab', session('active_tab', 'general')) }}">

        @if($isEditing)
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
                                <label class="form-label" for="accommodation-name-es">Nombre del hospedaje (Español)</label>
                                <input
                                    type="text"
                                    id="accommodation-name-es"
                                    name="name[es]"
                                    value="{{ old('name.es', $accommodation->name['es'] ?? '') }}"
                                    class="form-input {{ $errors->has('name.es') ? 'form-input-error' : '' }}"
                                    data-validate="text"
                                    data-label="Nombre del hospedaje (Español)"
                                    required>

                                @error('name.es')
                                <p class="form-input-error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label class="form-label" for="accommodation-name-en">Nombre del hospedaje (Inglés)</label>
                                <input
                                    type="text"
                                    id="accommodation-name-en"
                                    name="name[en]"
                                    value="{{ old('name.en', $accommodation->name['en'] ?? '') }}"
                                    class="form-input {{ $errors->has('name.en') ? 'form-input-error' : '' }}"
                                    data-validate="text"
                                    data-label="Nombre del hospedaje (Inglés)"
                                    required>

                                @error('name.en')
                                <p class="form-input-error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="form-label" for="accommodation-slug">Slug del hospedaje</label>
                                <input
                                    type="text"
                                    id="accommodation-slug"
                                    name="slug"
                                    value="{{ old('slug', $accommodation->slug ?? '') }}"
                                    class="form-input {{ $errors->has('slug') ? 'form-input-error' : '' }}"
                                    data-validate="slug"
                                    data-label="Slug del hospedaje"
                                    required>

                                <p class="form-help">Este texto se usa en la URL interna del hospedaje.</p>

                                @error('slug')
                                <p class="form-input-error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label class="form-label" for="accommodation-host-name">Nombre del anfitrión</label>
                                <input
                                    type="text"
                                    id="accommodation-host-name"
                                    name="host_name"
                                    value="{{ old('host_name', $accommodation->host_name ?? '') }}"
                                    class="form-input {{ $errors->has('host_name') ? 'form-input-error' : '' }}"
                                    data-validate="letters"
                                    data-label="Nombre del anfitrión"
                                    placeholder="Ej: Ana López"
                                    required>

                                @error('host_name')
                                <p class="form-input-error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-card">
                        <div class="form-card-header">
                            <h3 class="form-card-title">Ubicación y contacto</h3>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="form-label" for="accommodation-location">Ubicación</label>
                                <input
                                    type="text"
                                    id="accommodation-location"
                                    name="location"
                                    value="{{ old('location', $accommodation->location ?? '') }}"
                                    class="form-input {{ $errors->has('location') ? 'form-input-error' : '' }}"
                                    data-validate="location"
                                    data-label="Ubicación"
                                    placeholder="Ej: La Fortuna, San Carlos"
                                    required>

                                @error('location')
                                <p class="form-input-error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label class="form-label" for="accommodation-phone">Teléfono</label>
                                <input
                                    type="text"
                                    id="accommodation-phone"
                                    name="phone"
                                    value="{{ old('phone', $accommodation->phone ?? '') }}"
                                    class="form-input {{ $errors->has('phone') ? 'form-input-error' : '' }}"
                                    data-validate="phone"
                                    data-label="Teléfono"
                                    inputmode="numeric"
                                    placeholder="Ej: 88888888"
                                    required>

                                <p class="form-help">Usa únicamente números, sin espacios ni guiones.</p>

                                @error('phone')
                                <p class="form-input-error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-field">
                            <label class="form-label" for="accommodation-external-url">Enlace externo</label>
                            <input
                                type="url"
                                id="accommodation-external-url"
                                name="external_url"
                                value="{{ old('external_url', $accommodation->external_url ?? '') }}"
                                class="form-input {{ $errors->has('external_url') ? 'form-input-error' : '' }}"
                                data-validate="url"
                                data-label="Enlace externo"
                                placeholder="https://www.airbnb.com/..."
                                required>

                            <p class="form-help">Este será el enlace de redirección hacia Airbnb u otra plataforma externa.</p>

                            @error('external_url')
                            <p class="form-input-error-message">{{ $message }}</p>
                            @enderror
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
                                <label class="form-label" for="short-description-es">Español</label>
                                <textarea
                                    id="short-description-es"
                                    name="short_description[es]"
                                    class="form-textarea {{ $errors->has('short_description.es') ? 'form-input-error' : '' }}"
                                    data-validate="textarea"
                                    data-label="Descripción corta en español"
                                    required>{{ old('short_description.es', $accommodation->short_description['es'] ?? '') }}</textarea>

                                @error('short_description.es')
                                <p class="form-input-error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label class="form-label" for="short-description-en">English</label>
                                <textarea
                                    id="short-description-en"
                                    name="short_description[en]"
                                    class="form-textarea {{ $errors->has('short_description.en') ? 'form-input-error' : '' }}"
                                    data-validate="textarea"
                                    data-label="Descripción corta en inglés"
                                    required>{{ old('short_description.en', $accommodation->short_description['en'] ?? '') }}</textarea>

                                @error('short_description.en')
                                <p class="form-input-error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-card">
                        <div class="form-card-header">
                            <h3 class="form-card-title">Capacidad del hospedaje</h3>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="form-label" for="guests">Huéspedes</label>
                                <input
                                    type="number"
                                    id="guests"
                                    name="guests"
                                    min="1"
                                    value="{{ old('guests', $accommodation->guests ?? 1) }}"
                                    class="form-input {{ $errors->has('guests') ? 'form-input-error' : '' }}"
                                    data-validate="number"
                                    data-label="Huéspedes"
                                    required>

                                @error('guests')
                                <p class="form-input-error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label class="form-label" for="bedrooms">Habitaciones</label>
                                <input
                                    type="number"
                                    id="bedrooms"
                                    name="bedrooms"
                                    min="0"
                                    value="{{ old('bedrooms', $accommodation->bedrooms ?? 0) }}"
                                    class="form-input {{ $errors->has('bedrooms') ? 'form-input-error' : '' }}"
                                    data-validate="number"
                                    data-label="Habitaciones"
                                    required>

                                @error('bedrooms')
                                <p class="form-input-error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-grid">
                            <div class="form-field">
                                <label class="form-label" for="beds">Camas</label>
                                <input
                                    type="number"
                                    id="beds"
                                    name="beds"
                                    min="0"
                                    value="{{ old('beds', $accommodation->beds ?? 0) }}"
                                    class="form-input {{ $errors->has('beds') ? 'form-input-error' : '' }}"
                                    data-validate="number"
                                    data-label="Camas"
                                    required>

                                @error('beds')
                                <p class="form-input-error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label class="form-label" for="bathrooms">Baños</label>
                                <input
                                    type="number"
                                    id="bathrooms"
                                    name="bathrooms"
                                    min="0"
                                    value="{{ old('bathrooms', $accommodation->bathrooms ?? 0) }}"
                                    class="form-input {{ $errors->has('bathrooms') ? 'form-input-error' : '' }}"
                                    data-validate="number"
                                    data-label="Baños"
                                    required>

                                @error('bathrooms')
                                <p class="form-input-error-message">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-card">
                        <div class="form-card-header">
                            <h3 class="form-card-title">Amenidades</h3>
                        </div>

                        <p class="form-help">
                            Agregar las Amenidades por coma. Ejm: Wifi, Cocina, Parqueo
                        </p>

                        <div class="accommodation-amenities-grid">
                            <div class="form-field">
                                <label class="form-label" for="amenities-es">Amenidades (Español)</label>
                                <input
                                    type="text"
                                    id="amenities-es"
                                    name="amenities[es]"
                                    value="{{ old('amenities.es', $accommodation->getAmenityAdminInput('es')) }}"
                                    class="form-input {{ $errors->has('amenities.es') ? 'form-input-error' : '' }}"
                                    data-validate="amenities"
                                    data-label="Amenidades en español"
                                    placeholder="Wi-Fi, Cocina, Parqueo gratis"
                                    required>

                                <p class="form-help">
                                    Este campo se mostrará en español en el sitio público.
                                </p>

                                @error('amenities.es')
                                <p class="form-input-error-message">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-field">
                                <label class="form-label" for="amenities-en">Amenities (English)</label>
                                <input
                                    type="text"
                                    id="amenities-en"
                                    name="amenities[en]"
                                    value="{{ old('amenities.en', $accommodation->getAmenityAdminInput('en')) }}"
                                    class="form-input {{ $errors->has('amenities.en') ? 'form-input-error' : '' }}"
                                    data-validate="amenities"
                                    data-label="Amenidades en inglés"
                                    placeholder="Wi-Fi, Kitchen, Free parking"
                                    required>

                                <p class="form-help">
                                    This field is used for the English version of the website.
                                </p>

                                @error('amenities.en')
                                <p class="form-input-error-message">{{ $message }}</p>
                                @enderror
                            </div>
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
                                accept="image/*"
                                {{ $requiresMainImage ? 'required' : '' }}>

                            <span class="accommodation-dropzone-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" class="w-10 h-10">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2 1.586-1.586a2 2 0 012.828 0L20 14m-10-4h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </span>

                            <span class="accommodation-dropzone-title">Seleccionar imagen principal</span>
                            <span class="accommodation-dropzone-text">JPG, PNG, WEBP o AVIF</span>
                        </label>

                        @error('main_image')
                        <p class="form-input-error-message mt-3">{{ $message }}</p>
                        @enderror

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

                        @error('gallery_images')
                        <p class="form-input-error-message mt-3">{{ $message }}</p>
                        @enderror

                        @error('gallery_images.*')
                        <p class="form-input-error-message mt-3">{{ $message }}</p>
                        @enderror

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
                {{ $isEditing ? 'Actualizar Hospedaje' : 'Crear Hospedaje' }}
            </button>
        </div>

    </form>

</div>