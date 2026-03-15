<div class="admin-page">

    <div class="admin-page-header">

        <h1 class="admin-page-title">
            {{ isset($user->id) ? 'Editar Usuario' : 'Agregar Usuario' }}
        </h1>

        <p class="admin-page-subtitle">
            {{ isset($user->id)
                ? 'Modifica la información del usuario seleccionado.'
                : 'Completa la información para crear un nuevo usuario.' }}
        </p>

    </div>

    <form method="POST"
        action="{{ isset($user->id) ? route('admin.users.update', $user) : route('admin.users.store') }}"
        class="admin-form">

        @csrf

        @if(isset($user->id))
        @method('PUT')
        @endif

        <section class="admin-card">

            <div class="admin-card-header">

                <div>
                    <h2 class="admin-section-title">
                        Información del Usuario
                    </h2>

                    <p class="admin-help">
                        Configura los datos principales de acceso y rol del usuario.
                    </p>
                </div>

            </div>

            <div class="form-section">

                {{-- BASIC INFO --}}
                <div class="form-card">

                    <div class="form-card-header">
                        <h3 class="form-card-title">Información básica</h3>
                    </div>

                    <div class="form-grid">

                        <div class="form-field">
                            <label class="form-label">Nombre</label>

                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name ?? '') }}"
                                class="form-input"
                                required>

                            @error('name')
                            <p class="form-help text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label class="form-label">Correo electrónico</label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email ?? '') }}"
                                class="form-input"
                                required>

                            @error('email')
                            <p class="form-help text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                </div>

                {{-- ROLE / ACCESS --}}
                <div class="form-card">

                    <div class="form-card-header">
                        <h3 class="form-card-title">Acceso y permisos</h3>
                    </div>

                    <div class="form-grid">

                        <div class="form-field">
                            <label class="form-label">Rol</label>

                            <select name="role_id" class="form-input" required>
                                <option value="">Selecciona un rol</option>

                                @foreach($roles as $role)
                                <option
                                    value="{{ $role->id }}"
                                    {{ old('role_id', $user->role_id ?? '') == $role->id ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                                @endforeach
                            </select>

                            @error('role_id')
                            <p class="form-help text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label class="form-label">
                                {{ isset($user->id) ? 'Nueva contraseña (opcional)' : 'Contraseña' }}
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-input"
                                {{ isset($user->id) ? '' : 'required' }}>

                            <p class="form-help">
                                {{ isset($user->id)
                                    ? 'Déjala vacía si no deseas cambiar la contraseña.'
                                    : 'Debe tener al menos 8 caracteres.' }}
                            </p>

                            @error('password')
                            <p class="form-help text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="form-grid">

                        <div class="form-field">
                            <label class="form-label">Confirmar contraseña</label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-input"
                                {{ isset($user->id) ? '' : 'required' }}>

                            @error('password_confirmation')
                            <p class="form-help text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                </div>

            </div>

        </section>

        <div class="mt-12">
            <button type="submit" class="admin-btn-primary">
                {{ isset($user->id) ? 'Actualizar Usuario' : 'Crear Usuario' }}
            </button>
        </div>

    </form>

</div>