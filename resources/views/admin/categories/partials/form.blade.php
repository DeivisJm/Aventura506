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
                    <h2 class="admin-section-title">Información de la categoría</h2>
                    <p class="admin-help">
                        Esta categoría se utilizará en todos los tours que la tengan asignada.
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
                            <label class="form-label">Nombre (Español)</label>
                            <input type="text"
                                name="name[es]"
                                value="{{ old('name.es', $category->name['es'] ?? '') }}"
                                class="form-input"
                                required>
                        </div>

                        <div class="form-field">
                            <label class="form-label">Nombre (Inglés)</label>
                            <input type="text"
                                name="name[en]"
                                value="{{ old('name.en', $category->name['en'] ?? '') }}"
                                class="form-input"
                                required>
                        </div>

                    </div>

                    <div class="form-field">
                        <label class="form-label">Slug</label>
                        <input type="text"
                            name="slug"
                            value="{{ old('slug', $category->slug ?? '') }}"
                            class="form-input"
                            required>

                        <p class="form-help">
                            Este valor se usa para el filtro y la URL interna de la categoría.
                        </p>
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