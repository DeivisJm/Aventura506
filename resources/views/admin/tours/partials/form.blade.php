@extends('admin.layouts.admin')

@section('admin-content')

@php
$isEditing = isset($tour->id);
$requiresTourImage = !$isEditing || empty($tour->image);
@endphp

<div class="admin-page">

    <div class="admin-page-header">

        <h1 class="admin-page-title">
            {{ $isEditing ? 'Editar Tour' : 'Agregar Tour' }}
        </h1>

        <p class="admin-page-subtitle">
            {{ $isEditing
                ? 'Modifica la información del tour seleccionado.'
                : 'Completa la información para crear un nuevo tour.' }}
        </p>

    </div>

    {{-- Validation modal --}}
    <div
        id="tour-validation-alert"
        class="form-validation-modal {{ $errors->any() ? 'is-open' : '' }}"
        data-validation-alert
        aria-hidden="{{ $errors->any() ? 'false' : 'true' }}">

        <div class="form-validation-modal__backdrop" data-alert-close></div>

        <div
            class="form-validation-modal__dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="tour-validation-title">

            <div class="form-validation-modal__icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v5m0 4h.01M10.29 3.86l-7.4 12.82A2 2 0 004.63 20h14.74a2 2 0 001.74-3.32l-7.4-12.82a2 2 0 00-3.48 0z" />
                </svg>
            </div>

            <div class="form-validation-modal__content">
                <h3 id="tour-validation-title" class="form-validation-modal__title">
                    {{ $isEditing ? 'No se pudo actualizar el tour' : 'No se pudo crear el tour' }}
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

    {{-- Server-side validation errors for field mapping --}}
    <script type="application/json" id="tour-server-errors-json">
        {!! json_encode($errors->messages(), JSON_UNESCAPED_UNICODE) !!}
    </script>

    <form method="POST"
        action="{{ $isEditing ? route('admin.tours.update', $tour) : route('admin.tours.store') }}"
        enctype="multipart/form-data"
        class="admin-form"
        id="tour-form"
        data-submit-label="{{ $isEditing ? 'actualizar' : 'crear' }}"
        novalidate>

        @csrf

        <input type="hidden" name="active_tab" id="active-tab-input" value="{{ old('active_tab', 'general') }}">

        @if($isEditing)
        @method('PUT')
        @endif

        <form method="POST"
            action="{{ isset($tour->id) ? route('admin.tours.update', $tour) : route('admin.tours.store') }}"
            enctype="multipart/form-data"
            class="admin-form">

            @csrf

            @if(isset($tour->id))
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

                <button type="button" class="admin-tab" data-tab="prices">
                    Precios
                </button>

                <button type="button" class="admin-tab" data-tab="schedules">
                    Horarios
                </button>

            </div>

            {{-- GENERAL TAB--}}
            <div class="admin-tab-content active" id="general">

                <section class="admin-card">

                    <div class="admin-card-header">

                        <div>

                            <h2 class="admin-section-title">
                                Información General
                            </h2>

                            <p class="admin-help">
                                Configura la información principal del tour que será visible en el sitio web.
                            </p>

                        </div>

                    </div>


                    <div class="form-section">

                        {{-- BASIC INFO--}}
                        <div class="form-card">

                            <div class="form-card-header">
                                <h3 class="form-card-title">Información básica</h3>
                            </div>

                            <div class="form-grid">

                                <div class="form-field">

                                    <label class="form-label">
                                        Nombre del Tour (Español)
                                    </label>

                                    <input
                                        type="text"
                                        name="name[es]"
                                        value="{{ old('name.es', $tour->name['es'] ?? '') }}"
                                        class="form-input"
                                        required>

                                </div>

                                <div class="form-field">

                                    <label class="form-label">
                                        Nombre del Tour (Inglés)
                                    </label>

                                    <input
                                        type="text"
                                        name="name[en]"
                                        value="{{ old('name.en', $tour->name['en'] ?? '') }}"
                                        class="form-input"
                                        required>

                                </div>

                            </div>

                            <div class="form-grid">

                                <div class="form-field">

                                    <label class="form-label">
                                        Slug del Tour
                                    </label>

                                    <input
                                        type="text"
                                        name="slug"
                                        value="{{ old('slug', $tour->slug ?? '') }}"
                                        class="form-input"
                                        required>

                                    <p class="form-help">
                                        Este texto se usa en la URL del tour.
                                    </p>

                                </div>


                                <div class="form-field">

                                    <label class="form-label">
                                        Categoría
                                    </label>

                                    <select name="category_id" id="category_id" class="form-input" required>
                                        <option value="">
                                            Selecciona una categoría
                                        </option>

                                        @foreach($categories as $category)
                                        <option
                                            value="{{ $category->id }}"
                                            {{ old('category_id', $tour->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                            {{ $category->translated_name }}
                                        </option>
                                        @endforeach

                                        <option disabled>──────────────</option>

                                        <option value="new" {{ old('category_id') == 'new' ? 'selected' : '' }}>
                                            + Agregar nueva categoría
                                        </option>
                                    </select>

                                    <p class="form-help">
                                        Selecciona una categoría existente o crea una nueva.
                                    </p>

                                </div>

                                <div
                                    id="new-category-wrapper"
                                    class="form-field {{ old('category_id') == 'new' ? '' : 'hidden' }} md:col-span-2">

                                    <div class="form-grid">

                                        <div class="form-field">
                                            <label class="form-label">
                                                Nombre de la nueva Categoria (Español)
                                            </label>

                                            <input
                                                type="text"
                                                name="new_category[es]"
                                                id="new_category_es"
                                                value="{{ old('new_category.es') }}"
                                                class="form-input"
                                                placeholder="Ej: Aventura extrema">
                                        </div>

                                        <div class="form-field">
                                            <label class="form-label">
                                                Nombre de la nueva Categoria (Ingles)
                                            </label>

                                            <input
                                                type="text"
                                                name="new_category[en]"
                                                id="new_category_en"
                                                value="{{ old('new_category.en') }}"
                                                class="form-input"
                                                placeholder="Example: Extreme Adventure">
                                        </div>

                                    </div>

                                    <p class="form-help">
                                        Escribe el nombre de la nueva categoría en ambos idiomas.
                                    </p>

                                </div>

                            </div>

                            {{-- LOCATION / COMPANY --}}
                            <div class="form-card">

                                <div class="form-card-header">
                                    <h3 class="form-card-title">Ubicación del Tour</h3>
                                </div>

                                <div class="form-grid">

                                    <div class="form-field">

                                        <label class="form-label">
                                            Ubicación del Tour
                                        </label>

                                        <input
                                            type="text"
                                            name="detail[location_name]"
                                            value="{{ old('detail.location_name', $tour->detail?->location_name ?? '') }}"
                                            class="form-input"
                                            required>


                                        <p class="form-help">
                                            Ubicación principal donde se realiza el tour.
                                        </p>

                                    </div>


                                    <div class="form-field">

                                        <label class="form-label">
                                            Compañía Operadora
                                        </label>

                                        <select name="company_id" id="company_select" class="form-input" required>
                                            <option value="">
                                                Selecciona una compañía
                                            </option>

                                            @foreach($companies as $company)
                                            <option
                                                value="{{ $company->id }}"
                                                data-email="{{ $company->email ?? '' }}"
                                                data-phone="{{ $company->phone ?? '' }}"
                                                data-map="{{ $company->map_embed_url ?? '' }}"
                                                {{ old('company_id', $tour->company_id ?? '') == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                            @endforeach

                                            <option disabled>──────────────</option>

                                            <option value="new" {{ old('company_id') == 'new' ? 'selected' : '' }}>
                                                + Agregar nueva compañía
                                            </option>
                                        </select>

                                        <p class="form-help">
                                            Selecciona una compañía existente o crea una nueva.
                                        </p>

                                    </div>

                                    <div
                                        id="new-company-wrapper"
                                        class="form-field {{ old('company_id') == 'new' ? '' : 'hidden' }} md:col-span-2">

                                        <label class="form-label">
                                            Nueva compañía operadora
                                        </label>

                                        <input
                                            type="text"
                                            name="new_company"
                                            id="new_company"
                                            value="{{ old('new_company') }}"
                                            class="form-input"
                                            placeholder="Ej: Relax Termalitas Hot Springs">

                                        <p class="form-help">
                                            Escribe el nombre de la nueva compañía operadora.
                                        </p>

                                    </div>

                                    <div class="form-field">
                                        <label class="form-label">
                                            Email de la Compañía
                                        </label>

                                        <input
                                            type="email"
                                            id="company_email"
                                            name="company[email]"
                                            value="{{ old('company.email', $tour->company?->email ?? '') }}"
                                            class="form-input"
                                            placeholder="ejemplo@empresa.com"
                                            required>
                                    </div>

                                    <div class="form-field">
                                        <label class="form-label">
                                            Teléfono de la Compañía
                                        </label>

                                        <input
                                            type="text"
                                            id="company_phone"
                                            name="company[phone]"
                                            value="{{ old('company.phone', $tour->company?->phone ?? '') }}"
                                            class="form-input"
                                            inputmode="numeric"
                                            placeholder="88888888"
                                            required>
                                    </div>

                                </div>

                            </div>

                            {{--GENERAL SCHEDULE--}}
                            <div class="form-card">

                                <div class="form-card-header">
                                    <h3 class="form-card-title">Horario General del Tour</h3>
                                </div>

                                <div class="form-grid">

                                    <div class="form-field">

                                        <label class="form-label">
                                            Horario (Español)
                                        </label>

                                        <input
                                            type="text"
                                            name="detail[start_hours_text][es]"
                                            value="{{ old('detail.start_hours_text.es', $tour->detail?->start_hours_text['es'] ?? '') }}"
                                            class="form-input"
                                            required>

                                    </div>

                                    <div class="form-field">

                                        <label class="form-label">
                                            Horario (Inglés)
                                        </label>

                                        <input
                                            type="text"
                                            name="detail[start_hours_text][en]"
                                            value="{{ old('detail.start_hours_text.en', $tour->detail?->start_hours_text['en'] ?? '') }}"
                                            class="form-input"
                                            required>
                                    </div>

                                </div>

                            </div>

                            {{-- IMAGE --}}
                            <div class="form-card accommodation-gallery-card">

                                <div class="form-card-header accommodation-gallery-header">
                                    <div>
                                        <h3 class="form-card-title">Imagen del Tour</h3>
                                        <p class="form-help mt-1">
                                            Selecciona la imagen principal que representará este tour en el sitio web.
                                        </p>
                                    </div>
                                </div>

                                {{-- Hidden field that stores the cropped result --}}
                                <input
                                    type="hidden"
                                    name="cropped_image"
                                    id="cropped-image-input"
                                    value="">

                                <label class="accommodation-main-dropzone" for="tour-image-input">
                                    <input
                                        type="file"
                                        name="image"
                                        id="tour-image-input"
                                        class="form-input-file"
                                        accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                        {{ $requiresTourImage ? 'required' : '' }}>

                                    <span class="accommodation-dropzone-icon">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-10 h-10" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2 1.586-1.586a2 2 0 012.828 0L20 14m-10-4h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </span>

                                    <span class="accommodation-dropzone-title">Seleccionar imagen del tour</span>
                                    <span class="accommodation-dropzone-text">JPG, PNG o WEBP</span>
                                </label>

                                <div class="accommodation-main-preview-list" id="tour-image-preview-wrapper">
                                    <div class="accommodation-main-preview-card {{ !empty($tour->image) ? '' : 'hidden' }}" id="tour-image-preview-card">

                                        <div class="tour-admin-preview-card">
                                            <div class="tour-admin-preview-media">
                                                <img
                                                    id="tour-image-preview"
                                                    src="{{ !empty($tour->image) ? $tour->image_url : '' }}"
                                                    alt="Tour preview"
                                                    class="tour-admin-preview-image">
                                            </div>

                                            <button
                                                type="button"
                                                id="open-tour-cropper"
                                                class="tour-admin-crop-btn"
                                                title="Editar recorte">

                                                <span class="tour-admin-crop-btn-icon">
                                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.65-1.65a2.121 2.121 0 113 3L7.5 19.5 3 21l1.5-4.5 12.362-12.013z" />
                                                    </svg>
                                                </span>

                                                <span class="tour-admin-crop-btn-text">
                                                    <strong>Editar imagen</strong>
                                                    <small>Ajustar imagen del card</small>
                                                </span>
                                            </button>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            {{-- IMAGE CROPPER MODAL --}}
                            <div class="tour-cropper-modal hidden" id="tour-cropper-modal">
                                <div class="tour-cropper-backdrop" id="tour-cropper-close-backdrop"></div>

                                <div class="tour-cropper-dialog" role="dialog" aria-modal="true" aria-labelledby="tour-cropper-title">
                                    <div class="tour-cropper-header">
                                        <div>
                                            <h3 class="tour-cropper-title" id="tour-cropper-title">Editar imagen de card</h3>
                                            <p class="tour-cropper-subtitle">
                                                Ajusta el recorte dentro del mismo formato que se mostrará en las cards públicas.
                                            </p>
                                        </div>

                                        <button type="button"
                                            id="tour-cropper-close"
                                            class="tour-cropper-close-text text-2xl md:text-3xl"
                                            aria-label="Cerrar editor">
                                            ✕
                                        </button>
                                    </div>

                                    <div class="tour-cropper-body">
                                        <div class="tour-cropper-stage">
                                            <img id="tour-cropper-image" src="" alt="Crop editor preview">
                                        </div>

                                        <div class="tour-cropper-side">
                                            <div class="tour-cropper-side-card">
                                                <h4 class="tour-cropper-side-title">Vista previa de la card</h4>
                                                <div class="tour-cropper-card-sample">
                                                    <img id="tour-cropper-preview-thumb" src="" alt="Card preview thumbnail">
                                                </div>
                                            </div>

                                            <div class="tour-cropper-side-card">
                                                <h4 class="tour-cropper-side-title">Acciones</h4>

                                                <div class="tour-cropper-actions">
                                                    <button type="button" class="tour-cropper-secondary-btn" id="tour-cropper-zoom-in">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                                                        </svg>
                                                        <span>Acercar</span>
                                                    </button>

                                                    <button type="button" class="tour-cropper-secondary-btn" id="tour-cropper-zoom-out">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14" />
                                                        </svg>
                                                        <span>Alejar</span>
                                                    </button>

                                                    <button type="button" class="tour-cropper-secondary-btn" id="tour-cropper-reset">
                                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" class="w-4 h-4" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 4.5v5h5M19.5 19.5v-5h-5" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 9a8 8 0 00-13.66-5.66L4.5 4.5M4 15a8 8 0 0013.66 5.66L19.5 19.5" />
                                                        </svg>
                                                        <span>Restablecer</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tour-cropper-footer">
                                        <button type="button" class="tour-cropper-cancel-btn" id="tour-cropper-cancel">
                                            Cancelar
                                        </button>

                                        <button type="button" class="tour-cropper-save-btn" id="tour-cropper-apply">
                                            Aplicar recorte
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>

            </div>

            {{--DETAILS TAB --}}
            <div class="admin-tab-content" id="details">

                <section class="admin-card">

                    <div class="admin-card-header">

                        <div>

                            <h2 class="admin-section-title">
                                Detalles del Tour
                            </h2>

                            <p class="admin-help">
                                Información detallada que aparecerá en la página del tour.
                            </p>

                        </div>

                    </div>


                    <div class="form-section">

                        {{--TOUR DURATION--}}
                        <div class="form-card">

                            <div class="form-card-header">

                                <h3 class="form-card-title">
                                    Duración del Tour
                                </h3>

                            </div>

                            <p class="form-help">
                                Indica cuánto dura la experiencia del tour.
                            </p>

                            <div class="form-grid">

                                <div class="form-field">

                                    <label class="form-label">
                                        Duración (Español)
                                    </label>

                                    <input
                                        type="text"
                                        name="detail[duration][es]"
                                        value="{{ old('detail.duration.es', $tour->detail?->duration['es'] ?? '') }}"
                                        class="form-input"
                                        placeholder="Ej: 2 horas"
                                        required>

                                </div>

                                <div class="form-field">

                                    <label class="form-label">
                                        Duration (English)
                                    </label>

                                    <input
                                        type="text"
                                        name="detail[duration][en]"
                                        value="{{ old('detail.duration.en', $tour->detail->duration['en'] ?? '') }}"
                                        class="form-input"
                                        placeholder="Example: 2 hours"
                                        required>

                                </div>

                            </div>

                        </div>


                        {{-- SHORT DESCRIPTION--}}
                        <div class="form-card">

                            <div class="form-card-header">
                                <h3 class="form-card-title">Descripción corta</h3>
                            </div>

                            <p class="form-help">
                                Este texto aparece en las tarjetas del tour.
                            </p>

                            <div class="form-grid">

                                <div class="form-field">

                                    <label class="form-label">Español</label>

                                    <textarea
                                        name="description[es]"
                                        class="form-textarea"
                                        placeholder="Describe brevemente el tour..."
                                        required>{{ old('description.es', $tour->description['es'] ?? '') }}</textarea>


                                </div>

                                <div class="form-field">

                                    <label class="form-label">English</label>

                                    <textarea
                                        name="description[en]"
                                        class="form-textarea"
                                        placeholder="Write a short description..."
                                        required>{{ old('description.en', $tour->description['en'] ?? '') }}</textarea>


                                </div>

                            </div>

                        </div>


                        {{--FULL DESCRIPTION--}}
                        <div class="form-card">

                            <div class="form-card-header">
                                <h3 class="form-card-title">Descripción completa</h3>
                            </div>

                            <p class="form-help">
                                Descripción detallada que aparecerá en la página del tour.
                            </p>

                            <div class="form-grid">

                                <div class="form-field">

                                    <label class="form-label">Español</label>

                                    <textarea
                                        name="detail[full_description][es]"
                                        class="form-textarea"
                                        placeholder="Describe el tour con más detalle..."
                                        required>{{ old('detail.full_description.es', $tour->detail->full_description['es'] ?? '') }}</textarea>
                                </div>

                                <div class="form-field">

                                    <label class="form-label">English</label>

                                    <textarea
                                        name="detail[full_description][en]"
                                        class="form-textarea"
                                        placeholder="Write the full tour description..."
                                        required>{{ old('detail.full_description.en', $tour->detail->full_description['en'] ?? '') }}</textarea>
                                </div>

                            </div>

                        </div>


                        {{--INCLUDES--}}
                        <div class="form-card">

                            <div class="form-card-header">
                                <h3 class="form-card-title">Qué incluye el tour</h3>
                            </div>

                            <p class="form-help">
                                Escribe los elementos separados por coma.
                            </p>

                            <div class="form-grid">

                                <div class="form-field">

                                    <label class="form-label">Español</label>

                                    <input
                                        type="text"
                                        name="detail[includes][es]"
                                        value="{{ old('detail.includes.es', isset($tour->detail->includes['es']) ? implode(', ', $tour->detail->includes['es']) : '') }}"
                                        class="form-input"
                                        placeholder="Transporte, Guía, Entrada"
                                        required>

                                </div>

                                <div class="form-field">

                                    <label class="form-label">English</label>

                                    <input
                                        type="text"
                                        name="detail[includes][en]"
                                        value="{{ old('detail.includes.en', isset($tour->detail->includes['en']) ? implode(', ', $tour->detail->includes['en']) : '') }}"
                                        class="form-input"
                                        placeholder="Transportation, Guide, Entrance"
                                        required>

                                </div>

                            </div>

                        </div>


                        {{--IDEAL FOR--}}
                        <div class="form-card">

                            <div class="form-card-header">
                                <h3 class="form-card-title">Ideal para</h3>
                            </div>

                            <p class="form-help">
                                Tipos de visitantes ideales para este tour.
                            </p>

                            <div class="form-grid">

                                <div class="form-field">

                                    <label class="form-label">Español</label>

                                    <input
                                        type="text"
                                        name="detail[ideal_for][es]"
                                        value="{{ old('detail.ideal_for.es', isset($tour->detail->ideal_for['es']) ? implode(', ', $tour->detail->ideal_for['es']) : '') }}"
                                        class="form-input"
                                        placeholder="Familias, Fotógrafos"
                                        required>
                                </div>

                                <div class="form-field">

                                    <label class="form-label">English</label>

                                    <input
                                        type="text"
                                        name="detail[ideal_for][en]"
                                        value="{{ old('detail.ideal_for.en', isset($tour->detail->ideal_for['en']) ? implode(', ', $tour->detail->ideal_for['en']) : '') }}"
                                        class="form-input"
                                        placeholder="Families, Photographers"
                                        required>
                                </div>

                            </div>

                        </div>


                        {{--RECOMMENDATIONS--}}
                        <div class="form-card">

                            <div class="form-card-header">
                                <h3 class="form-card-title">Recomendaciones</h3>
                            </div>

                            <p class="form-help">
                                Consejos para los visitantes antes del tour.
                            </p>

                            <div class="form-grid">

                                <div class="form-field">

                                    <label class="form-label">Español</label>

                                    <input
                                        type="text"
                                        name="detail[recommendations][es]"
                                        value="{{ old('detail.recommendations.es', isset($tour->detail->recommendations['es']) ? implode(', ', $tour->detail->recommendations['es']) : '') }}"
                                        class="form-input"
                                        placeholder="Protector solar, Agua"
                                        required>
                                </div>

                                <div class="form-field">

                                    <label class="form-label">English</label>

                                    <input
                                        type="text"
                                        name="detail[recommendations][en]"
                                        value="{{ old('detail.recommendations.en', isset($tour->detail->recommendations['en']) ? implode(', ', $tour->detail->recommendations['en']) : '') }}"
                                        class="form-input"
                                        placeholder="Sunscreen, Water"
                                        required>
                                </div>

                            </div>

                        </div>


                        {{-- MAP --}}
                        {{-- MAP --}}
                        <div class="form-card">

                            <div class="form-card-header">
                                <h3 class="form-card-title">Ubicación del tour</h3>
                            </div>

                            <p class="form-help">
                                Este mapa se mostrará en la página pública del tour.
                            </p>

                            <div class="form-field">

                                <label class="form-label">URL del mapa</label>

                                <input
                                    type="url"
                                    name="company[map_embed_url]"
                                    value="{{ old('company.map_embed_url', $tour->company?->map_embed_url ?? '') }}"
                                    class="form-input"
                                    placeholder="https://www.google.com/maps/embed?pb=..."
                                    required>

                                <p class="form-help">
                                    Pega únicamente la URL del mapa embebido de Google Maps.
                                </p>

                            </div>

                            {{-- Instructions dropdown --}}
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
                                            <li>Busca la ubicación exacta donde se realiza el tour.</li>
                                            <li>Haz clic sobre el lugar para abrir su ficha de información.</li>
                                            <li>Presiona el botón <strong>Compartir</strong>.</li>
                                            <li>Selecciona la pestaña <strong>Incorporar un mapa</strong>.</li>
                                            <li>Se mostrará un código HTML que incluye una etiqueta <strong>iframe</strong>.</li>
                                            <li>Dentro de ese código, ubica el texto que aparece después de <strong>src="</strong>.</li>
                                            <li>Copia únicamente esa URL, comenzando en <strong>https</strong> y terminando antes de la comilla de cierre.</li>
                                            <li>Pega esa URL en el campo <strong>URL del mapa</strong>.</li>
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

                            @if(!empty($tour->company->map_embed_url ?? null))
                            <div class="admin-map-preview">
                                <iframe
                                    src="{{ $tour->company->map_embed_url }}"
                                    loading="lazy"
                                    allowfullscreen>
                                </iframe>
                            </div>
                            @endif

                        </div>

                    </div>

                </section>

            </div>

            {{-- PRICES TAB --}}
            <div class="admin-tab-content" id="prices">

                <section class="admin-card">

                    <div class="admin-card-header">

                        <div>

                            <h2 class="admin-section-title">
                                Precios del Tour
                            </h2>

                            <p class="admin-help">
                                Configura los precios según el tipo de visitante o rango de edad.
                            </p>

                        </div>

                        <button
                            type="button"
                            onclick="addPrice()"
                            class="admin-btn-primary">

                            + Agregar tipo de precio

                        </button>

                    </div>


                    <div id="prices-container" class="form-section">

                        @foreach(old('prices', $tour->prices ?? []) as $index => $price)

                        @php
                        $price = is_array($price) ? (object)$price : $price;
                        @endphp

                        <div class="form-card price-block">

                            <input type="hidden"
                                name="prices[{{$index}}][id]"
                                value="{{ $price->id ?? '' }}">

                            <div class="form-card-header">

                                <h3 class="form-card-title">
                                    Tipo de precio #{{ $index + 1 }}
                                </h3>

                                <button
                                    type="button"
                                    class="form-delete remove-price">

                                    Eliminar

                                </button>

                            </div>


                            {{-- PRICE NAMES --}}
                            <div class="form-grid">

                                <div class="form-field">

                                    <label class="form-label">
                                        Nombre del tipo (Español)
                                    </label>

                                    <input
                                        type="text"
                                        name="prices[{{$index}}][type][es]"
                                        value="{{ old("prices.$index.type.es", $price->type['es'] ?? '') }}"
                                        class="form-input"
                                        placeholder="Ej: Adultos nacionales"
                                        required>

                                    <p class="form-help">
                                        Nombre que se mostrará en la página del tour.
                                    </p>

                                </div>


                                <div class="form-field">

                                    <label class="form-label">
                                        Name (English)
                                    </label>

                                    <input
                                        type="text"
                                        name="prices[{{$index}}][type][en]"
                                        value="{{ old("prices.$index.type.en", $price->type['en'] ?? '') }}"
                                        class="form-input"
                                        placeholder="Example: Adults"
                                        required>

                                </div>

                            </div>


                            {{-- VISITOR TYPE --}}
                            <div class="form-grid">

                                <div class="form-field">

                                    <label class="form-label">
                                        Tipo de visitante
                                    </label>

                                    <select
                                        name="prices[{{$index}}][category_type]"
                                        class="form-input"
                                        required>

                                        <option value="international"
                                            {{ old("prices.$index.category_type", $price->category_type ?? '') == 'international' ? 'selected' : '' }}>

                                            Internacional

                                        </option>

                                        <option value="national"
                                            {{ old("prices.$index.category_type", $price->category_type ?? '') == 'national' ? 'selected' : '' }}>

                                            Nacional (Costa Rica)

                                        </option>

                                    </select>

                                </div>


                                <div class="form-field">

                                    <label class="form-label">
                                        Precio por persona
                                    </label>

                                    <div class="form-money">

                                        <span>$</span>

                                        <input
                                            type="number"
                                            step="0.01"
                                            name="prices[{{$index}}][price]"
                                            value="{{ old("prices.$index.price", $price->price ?? '') }}"
                                            class="form-input"
                                            placeholder="Ej: 55.00"
                                            required>

                                    </div>

                                    <p class="form-help">
                                        Ingresa siempre el precio en dólares ($) usando el formato 00.00
                                    </p>

                                </div>

                            </div>


                            {{-- AGE RANGE --}}
                            <div class="form-grid">

                                <div class="form-field">

                                    <label class="form-label">
                                        Edad mínima
                                    </label>

                                    <input
                                        type="number"
                                        name="prices[{{$index}}][min_age]"
                                        value="{{ old("prices.$index.min_age", $price->min_age ?? '') }}"
                                        class="form-input">


                                </div>


                                <div class="form-field">

                                    <label class="form-label">
                                        Edad máxima
                                    </label>

                                    <input
                                        type="number"
                                        name="prices[{{$index}}][max_age]"
                                        value="{{ old("prices.$index.max_age", $price->max_age ?? '') }}"
                                        class="form-input">

                                    <p class="form-help">
                                        Déjalo vacío si no hay límite.
                                    </p>

                                </div>

                            </div>

                        </div>

                        @endforeach

                    </div>

                </section>

            </div>

            {{-- SCHEDULE TAB --}}
            <div class="admin-tab-content" id="schedules">

                <section class="admin-card">

                    <div class="admin-card-header">

                        <div>

                            <h2 class="admin-section-title">
                                Horarios del Tour
                            </h2>

                            <p class="admin-help">
                                Aquí puedes configurar los horarios en los que este tour está disponible.
                            </p>

                        </div>

                        <button
                            type="button"
                            onclick="addSchedule()"
                            class="admin-btn-primary">

                            + Agregar horario

                        </button>

                    </div>


                    <div
                        id="schedules-container"
                        class="form-section">

                        @foreach(old('schedules', $tour->schedulesAdmin ?? []) as $index => $schedule)

                        @php
                        $schedule = is_array($schedule) ? (object)$schedule : $schedule;
                        @endphp

                        <div class="form-card schedule-block">

                            <input type="hidden"
                                name="schedules[{{$index}}][id]"
                                value="{{ $schedule->id ?? '' }}">


                            <div class="form-card-header">

                                <h3 class="form-card-title">
                                    Horario #{{ $index + 1 }}
                                </h3>

                                <button
                                    type="button"
                                    class="form-delete remove-schedule">

                                    Eliminar

                                </button>

                            </div>


                            <div class="form-grid">

                                {{-- START TIME --}}
                                <div class="form-field">

                                    <label class="form-label">
                                        Hora de inicio
                                    </label>

                                    <input
                                        type="time"
                                        name="schedules[{{$index}}][start_time]"
                                        value="{{ old("schedules.$index.start_time", isset($schedule->start_time) ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') : '') }}"
                                        class="form-input"
                                        required>

                                    <p class="form-help">
                                        Hora en la que inicia el tour.
                                    </p>

                                </div>


                                {{-- ACTIVE STATUS --}}
                                <div class="form-field">

                                    <label class="form-label">
                                        Estado
                                    </label>

                                    <div class="schedule-status">

                                        <label class="schedule-toggle">

                                            <input
                                                type="checkbox"
                                                name="schedules[{{$index}}][active]"
                                                value="1"
                                                data-id="{{ $schedule->id ?? '' }}"
                                                {{ old("schedules.$index.active", $schedule->active ?? false) ? 'checked' : '' }}
                                                class="schedule-active-toggle">


                                            <span class="schedule-slider"></span>

                                        </label>

                                        <span class="schedule-status-text {{ old("schedules.$index.active", $schedule->active ?? false) ? 'active' : 'inactive' }}">
                                            {{ old("schedules.$index.active", $schedule->active ?? false) ? 'Activo' : 'Desactivado' }}
                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                        @endforeach

                    </div>

                </section>

            </div>

            <div class="mt-12">

                <button type="submit" class="admin-btn-primary">

                    {{ isset($tour->id) ? 'Actualizar Tour' : 'Crear Tour' }}

                </button>

            </div>

        </form>

</div>

@endsection