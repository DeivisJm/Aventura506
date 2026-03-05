@extends('admin.layouts.admin')

@section('admin-content')

<div class="admin-page">

    <h1 class="admin-page-title">
        Editar Tour
    </h1>


    <form method="POST"
        action="{{ route('admin.tours.update',$tour) }}"
        enctype="multipart/form-data"
        class="admin-form">

        @csrf
        @method('PUT')

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

        {{-- GENERAL TAB --}}
        <div class="admin-tab-content active" id="general">

            <section class="admin-card">

                <!-- HEADER -->
                <div class="admin-card-header">

                    <h2 class="admin-section-title">
                        Información General
                    </h2>

                    <p class="admin-section-description">
                        Configura la información principal del tour que será visible en el sitio web.
                    </p>

                </div>


                <div class="admin-card-body">

                    <!-- BASIC INFO -->
                    <div class="admin-subsection">

                        <h3 class="admin-subtitle">
                            Información básica
                        </h3>

                        <div class="admin-grid">

                            <div class="admin-field">
                                <label class="admin-label">Nombre del Tour (Español)</label>

                                <input
                                    type="text"
                                    name="name[es]"
                                    value="{{ $tour->name['es'] ?? '' }}"
                                    class="admin-input">

                            </div>

                            <div class="admin-field">
                                <label class="admin-label">Nombre del Tour (Inglés)</label>

                                <input
                                    type="text"
                                    name="name[en]"
                                    value="{{ $tour->name['en'] ?? '' }}"
                                    class="admin-input">

                            </div>

                        </div>


                        <div class="admin-grid">

                            <div class="admin-field">

                                <label class="admin-label">Slug del Tour</label>

                                <input
                                    type="text"
                                    name="slug"
                                    value="{{ $tour->slug }}"
                                    class="admin-input">

                                <p class="admin-help">
                                    Este texto se usa en la URL del tour.
                                </p>

                            </div>


                            <div class="admin-field">

                                <label class="admin-label">Categoría</label>

                                <select name="category_id" class="admin-input">

                                    @foreach($categories as $category)

                                    <option value="{{ $category->id }}"
                                        {{ $tour->category_id == $category->id ? 'selected':'' }}>

                                        {{ $category->name }}

                                    </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>


                        <!-- COMPANY LOCATION -->
                        <div class="admin-grid">

                            <div class="admin-field">

                                <label class="admin-label">
                                    Ubicación del Tour
                                </label>

                                <input
                                    type="text"
                                    name="location_name"
                                    value="{{ $tour->company->location_name ?? '' }}"
                                    class="admin-input">

                                <p class="admin-help">
                                    Ubicación principal donde se realiza el tour.
                                </p>

                            </div>


                            <div class="admin-field">

                                <label class="admin-label">
                                    Compañía Operadora
                                </label>

                                <input
                                    type="text"
                                    value="{{ $tour->company->name ?? '' }}"
                                    class="admin-input"
                                    readonly>

                            </div>

                        </div>

                    </div>


                    <!-- SCHEDULE -->
                    <div class="admin-subsection">

                        <h3 class="admin-subtitle">
                            Horario General del Tour
                        </h3>

                        <div class="admin-grid">

                            <div class="admin-field">

                                <label class="admin-label">
                                    Horario (Español)
                                </label>

                                <input
                                    type="text"
                                    name="start_hours_text[es]"
                                    value="{{ $tour->detail->start_hours_text['es'] ?? '' }}"
                                    class="admin-input">

                            </div>

                            <div class="admin-field">

                                <label class="admin-label">
                                    Horario (Inglés)
                                </label>

                                <input
                                    type="text"
                                    name="start_hours_text[en]"
                                    value="{{ $tour->detail->start_hours_text['en'] ?? '' }}"
                                    class="admin-input">

                            </div>

                        </div>

                    </div>


                    <!-- IMAGE -->
                    <div class="admin-subsection">

                        <h3 class="admin-subtitle">
                            Imagen del tour
                        </h3>

                        <div class="admin-image-section">

                            <input
                                type="file"
                                name="image"
                                class="admin-input-file">

                            @if($tour->image)

                            <div class="admin-image-preview">

                                <img
                                    src="{{ asset($tour->image) }}"
                                    alt="Tour">

                            </div>

                            @endif

                        </div>

                    </div>

                </div>

            </section>

        </div>

        {{-- DETAILS TAB --}}
        <div class="admin-tab-content" id="details">

            <section class="admin-card">

                <!-- ================= HEADER ================= -->

                <div class="admin-card-header">

                    <h2 class="admin-section-title">
                        Detalles del Tour
                    </h2>

                    <p class="admin-section-description">
                        Información detallada que aparecerá en la página del tour.
                    </p>

                </div>


                <div class="admin-card-body">

                    {{-- =========================================
                        TOUR DURATION
                        ========================================= --}}

                    <div class="admin-subsection">

                        <h3 class="admin-subtitle">
                            Duración del tour
                        </h3>

                        <div class="admin-grid">

                            <div class="admin-field">

                                <label class="admin-label">Duración (Español)</label>

                                <input
                                    type="text"
                                    name="detail[duration][es]"
                                    value="{{ $tour->detail->duration['es'] ?? '' }}"
                                    class="admin-input">

                            </div>

                            <div class="admin-field">

                                <label class="admin-label">Duración (Inglés)</label>

                                <input
                                    type="text"
                                    name="detail[duration][en]"
                                    value="{{ $tour->detail->duration['en'] ?? '' }}"
                                    class="admin-input">

                            </div>

                        </div>

                    </div>


                    {{-- =========================================
                        SHORT DESCRIPTION
                        Stored in tours.description
                    ========================================= --}}

                    <div class="admin-subsection">

                        <h3 class="admin-subtitle">
                            Descripción corta
                        </h3>

                        <p class="admin-help">
                            Este texto aparece en las tarjetas del tour en la página principal.
                        </p>

                        <div class="admin-grid">

                            <div class="admin-field">

                                <label class="admin-label">Español</label>

                                <textarea
                                    name="description[es]"
                                    class="admin-textarea">

                                {{ $tour->description['es'] ?? '' }}

                                </textarea>

                            </div>

                            <div class="admin-field">

                                <label class="admin-label">Inglés</label>

                                <textarea
                                    name="description[en]"
                                    class="admin-textarea">

                                {{ $tour->description['en'] ?? '' }}

                                </textarea>

                            </div>

                        </div>

                    </div>


                    {{-- =========================================
                FULL DESCRIPTION
                Stored in tour_details.full_description
                ========================================= --}}

                    <div class="admin-subsection">

                        <h3 class="admin-subtitle">
                            Descripción completa del tour
                        </h3>

                        <p class="admin-help">
                            Describe el tour con más detalle para la página individual.
                        </p>

                        <div class="admin-grid">

                            <div class="admin-field">

                                <label class="admin-label">Español</label>

                                <textarea
                                    name="detail[full_description][es]"
                                    class="admin-textarea admin-textarea-lg">

                                {{ $tour->detail->full_description['es'] ?? '' }}

                                </textarea>

                            </div>

                            <div class="admin-field">

                                <label class="admin-label">Inglés</label>

                                <textarea
                                    name="detail[full_description][en]"
                                    class="admin-textarea admin-textarea-lg">

                                {{ $tour->detail->full_description['en'] ?? '' }}

                                </textarea>

                            </div>

                        </div>

                    </div>


                    {{-- =========================================
                WHAT IS INCLUDED
                ========================================= --}}

                    <div class="admin-subsection">

                        <h3 class="admin-subtitle">
                            Qué incluye el tour
                        </h3>

                        <p class="admin-help">
                            Agrega elementos separados por coma.
                            Ejemplo: Transporte, Guía bilingüe, Entrada al parque
                        </p>

                        <div class="admin-grid">

                            <div class="admin-field">

                                <label class="admin-label">Español</label>

                                <input
                                    type="text"
                                    name="detail[includes][es]"
                                    value="{{ isset($tour->detail->includes['es']) ? implode(', ', $tour->detail->includes['es']) : '' }}"
                                    class="admin-input"
                                    placeholder="Añadir: Transporte, Guía, Entrada">

                            </div>

                            <div class="admin-field">

                                <label class="admin-label">Inglés</label>

                                <input
                                    type="text"
                                    name="detail[includes][en]"
                                    value="{{ isset($tour->detail->includes['en']) ? implode(', ', $tour->detail->includes['en']) : '' }}"
                                    class="admin-input"
                                    placeholder="Add: Transportation, Guide, Entrance">

                            </div>

                        </div>

                    </div>


                    {{-- =========================================
                IDEAL FOR
                ========================================= --}}

                    <div class="admin-subsection">

                        <h3 class="admin-subtitle">
                            Ideal para
                        </h3>

                        <p class="admin-help">
                            Separa cada opción con coma.
                            Ejemplo: Familias, Fotógrafos, Aventureros
                        </p>

                        <div class="admin-grid">

                            <div class="admin-field">

                                <label class="admin-label">Español</label>

                                <input
                                    type="text"
                                    name="detail[ideal_for][es]"
                                    value="{{ isset($tour->detail->ideal_for['es']) ? implode(', ', $tour->detail->ideal_for['es']) : '' }}"
                                    class="admin-input"
                                    placeholder="Añadir: Familias, Fotógrafos">

                            </div>

                            <div class="admin-field">

                                <label class="admin-label">Inglés</label>

                                <input
                                    type="text"
                                    name="detail[ideal_for][en]"
                                    value="{{ isset($tour->detail->ideal_for['en']) ? implode(', ', $tour->detail->ideal_for['en']) : '' }}"
                                    class="admin-input"
                                    placeholder="Add: Families, Photographers">

                            </div>

                        </div>

                    </div>


                    {{-- =========================================
                RECOMMENDATIONS
                ========================================= --}}

                    <div class="admin-subsection">

                        <h3 class="admin-subtitle">
                            Recomendaciones
                        </h3>

                        <p class="admin-help">
                            Escribe recomendaciones separadas por coma.
                            Ejemplo: Usar bloqueador solar, Llevar agua, Zapatos cómodos
                        </p>

                        <div class="admin-grid">

                            <div class="admin-field">

                                <label class="admin-label">Español</label>

                                <input
                                    type="text"
                                    name="detail[recommendations][es]"
                                    value="{{ isset($tour->detail->recommendations['es']) ? implode(', ', $tour->detail->recommendations['es']) : '' }}"
                                    class="admin-input"
                                    placeholder="Añadir: Protector solar, Agua">

                            </div>

                            <div class="admin-field">

                                <label class="admin-label">Inglés</label>

                                <input
                                    type="text"
                                    name="detail[recommendations][en]"
                                    value="{{ isset($tour->detail->recommendations['en']) ? implode(', ', $tour->detail->recommendations['en']) : '' }}"
                                    class="admin-input"
                                    placeholder="Add: Sunscreen, Water">

                            </div>

                        </div>

                    </div>

                    {{-- TOUR LOCATION MAP Loaded from companies.map_embed_url --}}
                    <div class="admin-subsection">

                        <h3 class="admin-subtitle">
                            Ubicación del tour (Mapa)
                        </h3>

                        <p class="admin-help">
                            URL del mapa de Google Maps que se mostrará en la página del tour.
                        </p>

                        <div class="admin-field">

                            <label class="admin-label">
                                URL del mapa
                            </label>

                            <input
                                type="text"
                                name="company[map_embed_url]"
                                value="{{ $tour->company->map_embed_url ?? '' }}"
                                class="admin-input">

                        </div>


                        {{-- MAP PREVIEW --}}
                        @if(!empty($tour->company->map_embed_url))

                        <div class="admin-map-preview">

                            <iframe
                                src="{{ $tour->company->map_embed_url }}"
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
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

                <div class="prices-header">

                    <h2 class="admin-section-title">
                        Precios del Tour
                    </h2>

                    <button
                        type="button"
                        onclick="addPrice()"
                        class="price-add-btn">

                        + Agregar precio

                    </button>

                </div>

                <div id="prices-container" class="prices-container">

                    @foreach($tour->prices as $index=>$price)

                    <div class="price-card">

                        {{-- TYPE NAMES --}}
                        <div class="price-grid">

                            <div class="price-field">

                                <label>Nombre del tipo (Español)</label>

                                <input
                                    type="text"
                                    name="prices[{{$index}}][type][es]"
                                    value="{{ $price->type['es'] ?? '' }}"
                                    class="admin-input"
                                    placeholder="Ej: Adultos nacionales">

                            </div>

                            <div class="price-field">

                                <label>Name (English)</label>

                                <input
                                    type="text"
                                    name="prices[{{$index}}][type][en]"
                                    value="{{ $price->type['en'] ?? '' }}"
                                    class="admin-input"
                                    placeholder="Example: National Adults">

                            </div>

                        </div>


                        {{-- CATEGORY --}}
                        <div class="price-grid">

                            <div class="price-field">

                                <label>Tipo de visitante</label>

                                <select
                                    name="prices[{{$index}}][category_type]"
                                    class="admin-input">

                                    <option value="international"
                                        {{ $price->category_type=='international'?'selected':'' }}>
                                        Internacional
                                    </option>

                                    <option value="national"
                                        {{ $price->category_type=='national'?'selected':'' }}>
                                        Nacional
                                    </option>

                                </select>

                            </div>


                            <div class="price-field">

                                <label>Precio</label>

                                <div class="price-money">

                                    <span>$</span>

                                    <input
                                        type="number"
                                        step="0.01"
                                        name="prices[{{$index}}][price]"
                                        value="{{ $price->price }}"
                                        class="admin-input">

                                </div>

                            </div>

                        </div>


                        {{-- AGE --}}
                        <div class="price-grid">

                            <div class="price-field">

                                <label>Edad mínima</label>

                                <input
                                    type="number"
                                    name="prices[{{$index}}][min_age]"
                                    value="{{ $price->min_age }}"
                                    class="admin-input">

                            </div>

                            <div class="price-field">

                                <label>Edad máxima</label>

                                <input
                                    type="number"
                                    name="prices[{{$index}}][max_age]"
                                    value="{{ $price->max_age }}"
                                    class="admin-input">

                            </div>

                        </div>


                        <button
                            type="button"
                            class="price-delete remove-price">

                            Eliminar precio

                        </button>

                    </div>

                    @endforeach

                </div>

            </section>

        </div>

        {{-- ========================================= --}}
        {{-- SCHEDULE TAB --}}
        {{-- ========================================= --}}

        <div class="admin-tab-content" id="schedules">

            <section class="admin-card">

                <div class="flex justify-between items-center">

                    <h2 class="admin-section-title">
                        Horarios disponibles
                    </h2>

                    <button
                        type="button"
                        onclick="addSchedule()"
                        class="admin-btn-add">

                        + Agregar horario

                    </button>

                </div>


                <div
                    id="schedules-container"
                    class="grid grid-cols-2 gap-4">

                    @foreach($tour->schedules as $index=>$schedule)

                    <div class="schedule-row schedule-block">

                        <input
                            type="time"
                            name="schedules[{{$index}}][start_time]"
                            value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}"
                            class="admin-input">

                        <button
                            type="button"
                            class="admin-remove remove-schedule">

                            ✕
                        </button>

                    </div>

                    @endforeach

                </div>

            </section>

        </div>



        <div class="mt-12">

            <button type="submit"
                class="admin-btn-primary">

                Actualizar Tour

            </button>

        </div>

    </form>

</div>

@endsection