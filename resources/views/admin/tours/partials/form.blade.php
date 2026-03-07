@extends('admin.layouts.admin')

@section('admin-content')

<div class="admin-page">

    <div class="admin-page-header">

        <h1 class="admin-page-title">
            {{ isset($tour->id) ? 'Editar Tour' : 'Agregar Tour' }}
        </h1>

        <p class="admin-page-subtitle">
            {{ isset($tour->id)
            ? 'Modifica la información del tour seleccionado.'
            : 'Completa la información para crear un nuevo tour.' }}
        </p>

    </div>

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
                                    class="form-input">

                            </div>

                            <div class="form-field">

                                <label class="form-label">
                                    Nombre del Tour (Inglés)
                                </label>

                                <input
                                    type="text"
                                    name="name[en]"
                                    value="{{ old('name.en', $tour->name['en'] ?? '') }}"
                                    class="form-input">

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
                                    class="form-input">

                                <p class="form-help">
                                    Este texto se usa en la URL del tour.
                                </p>

                            </div>


                            <div class="form-field">

                                <label class="form-label">
                                    Categoría
                                </label>

                                <select name="category_id" class="form-input">

                                    @foreach($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        {{ old('category_id', $tour->category_id ?? '') == $category->id ? 'selected' : '' }}>

                                        {{ $category->name }}

                                    </option>

                                    @endforeach

                                </select>

                            </div>

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
                                    name="location_name"
                                    value="{{ old('location_name', $tour->company->location_name ?? '') }}"
                                    class="form-input">

                                <p class="form-help">
                                    Ubicación principal donde se realiza el tour.
                                </p>

                            </div>


                            <div class="form-field">

                                <label class="form-label">
                                    Compañía Operadora
                                </label>

                                <select name="company_id" class="form-input">

                                    <option value="">
                                        Selecciona una compañía
                                    </option>

                                    @foreach($companies as $company)

                                    <option
                                        value="{{ $company->id }}"
                                        {{ old('company_id', $tour->company_id ?? '') == $company->id ? 'selected' : '' }}>

                                        {{ $company->name }}

                                    </option>

                                    @endforeach

                                </select>

                                <p class="form-help">
                                    Selecciona la empresa responsable de operar este tour.
                                </p>

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
                                    name="start_hours_text[es]"
                                    value="{{ old('start_hours_text.es', $tour->detail->start_hours_text['es'] ?? '') }}"
                                    class="form-input">

                            </div>

                            <div class="form-field">

                                <label class="form-label">
                                    Horario (Inglés)
                                </label>

                                <input
                                    type="text"
                                    name="start_hours_text[en]"
                                    value="{{ old('start_hours_text.en', $tour->detail->start_hours_text['en'] ?? '') }}"
                                    class="form-input">

                            </div>

                        </div>

                    </div>


                    {{--IMAGE--}}
                    <div class="form-card">

                        <div class="form-card-header">
                            <h3 class="form-card-title">Imagen del Tour</h3>
                        </div>

                        <div class="form-field">

                            <input
                                type="file"
                                name="image"
                                id="tour-image-input"
                                class="form-input-file"
                                accept="image/*">

                        </div>

                        <div class="admin-image-preview">

                            <img
                                id="tour-image-preview"
                                src="{{ isset($tour) && $tour->image ? asset($tour->image) : '' }}"
                                alt="Tour Preview">

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
                                    value="{{ old('detail.duration.es', $tour->detail->duration['es'] ?? '') }}"
                                    class="form-input"
                                    placeholder="Ej: 2 horas">

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
                                    placeholder="Example: 2 hours">

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
                                    placeholder="Describe brevemente el tour...">{{ old('description.es', $tour->description['es'] ?? '') }}</textarea>

                            </div>

                            <div class="form-field">

                                <label class="form-label">English</label>

                                <textarea
                                    name="description[en]"
                                    class="form-textarea"
                                    placeholder="Write a short description...">{{ old('description.en', $tour->description['en'] ?? '') }}</textarea>

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
                                    placeholder="Describe el tour con más detalle...">{{ old('detail.full_description.es', $tour->detail->full_description['es'] ?? '') }}</textarea>

                            </div>

                            <div class="form-field">

                                <label class="form-label">English</label>

                                <textarea
                                    name="detail[full_description][en]"
                                    class="form-textarea"
                                    placeholder="Write the full tour description...">{{ old('detail.full_description.en', $tour->detail->full_description['en'] ?? '') }}</textarea>

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
                                    placeholder="Transporte, Guía, Entrada">

                            </div>

                            <div class="form-field">

                                <label class="form-label">English</label>

                                <input
                                    type="text"
                                    name="detail[includes][en]"
                                    value="{{ old('detail.includes.en', isset($tour->detail->includes['en']) ? implode(', ', $tour->detail->includes['en']) : '') }}"
                                    class="form-input"
                                    placeholder="Transportation, Guide, Entrance">

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
                                    placeholder="Familias, Fotógrafos">

                            </div>

                            <div class="form-field">

                                <label class="form-label">English</label>

                                <input
                                    type="text"
                                    name="detail[ideal_for][en]"
                                    value="{{ old('detail.ideal_for.en', isset($tour->detail->ideal_for['en']) ? implode(', ', $tour->detail->ideal_for['en']) : '') }}"
                                    class="form-input"
                                    placeholder="Families, Photographers">

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
                                    placeholder="Protector solar, Agua">

                            </div>

                            <div class="form-field">

                                <label class="form-label">English</label>

                                <input
                                    type="text"
                                    name="detail[recommendations][en]"
                                    value="{{ old('detail.recommendations.en', isset($tour->detail->recommendations['en']) ? implode(', ', $tour->detail->recommendations['en']) : '') }}"
                                    class="form-input"
                                    placeholder="Sunscreen, Water">

                            </div>

                        </div>

                    </div>


                    {{--MAP--}}
                    <div class="form-card">

                        <div class="form-card-header">
                            <h3 class="form-card-title">Ubicación del tour</h3>
                        </div>

                        <p class="form-help">
                            Mapa que se mostrará en la página del tour.
                        </p>

                        <div class="form-field">

                            <label class="form-label">URL del mapa</label>

                            <input
                                type="text"
                                name="company[map_embed_url]"
                                value="{{ old('company.map_embed_url', $tour->company->map_embed_url ?? '') }}"
                                class="form-input"
                                placeholder="Google Maps embed URL">

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
                                    placeholder="Ej: Adultos nacionales">

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
                                    placeholder="Example: Adults">

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
                                    class="form-input">

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
                                        placeholder="Ej: 55.00">

                                </div>

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
                                    class="form-input">

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