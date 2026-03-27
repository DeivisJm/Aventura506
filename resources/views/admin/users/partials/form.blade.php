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
        class="admin-form"
        autocomplete="off">

        @csrf

        @if(isset($user->id))
        @method('PUT')
        @endif

        {{-- Hidden fields to reduce browser password autofill --}}
        <input type="text" name="fake_username" autocomplete="username" class="hidden">
        <input type="password" name="fake_password" autocomplete="new-password" class="hidden">

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
                                autocomplete="off"
                                required>

                            <p class="form-help">
                                Puede incluir letras, espacios y números.
                            </p>

                            @error('name')
                            <p class="form-help text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-field">
                            <label class="form-label">Nombre de usuario</label>

                            <input
                                type="text"
                                name="username"
                                value="{{ old('username', $user->username ?? '') }}"
                                class="form-input"
                                autocomplete="off">

                            <p class="form-help">
                                Campo opcional. Puede usarse para identificar al usuario dentro del sistema.
                            </p>

                            @error('username')
                            <p class="form-help text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="form-grid">

                        <div class="form-field">
                            <label class="form-label">Correo electrónico</label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email ?? '') }}"
                                class="form-input"
                                autocomplete="off"
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

                            <div class="password-field">
                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-input password-input"
                                    autocomplete="new-password"
                                    {{ isset($user->id) ? '' : 'required' }}>

                                <button
                                    type="button"
                                    class="password-toggle"
                                    data-target="password"
                                    aria-label="Mostrar u ocultar contraseña"
                                    aria-pressed="false">

                                    <svg class="password-icon password-icon-eye"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.438 0 .644C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z" />
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>

                                    <svg class="password-icon password-icon-eye-off hidden"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 3l18 18" />
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M10.58 10.58a2 2 0 002.83 2.83" />
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9.88 5.09A9.77 9.77 0 0112 4.5c4.64 0 8.58 3.01 9.96 7.18.07.21.07.44 0 .65a10.52 10.52 0 01-4.3 5.37" />
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6.23 6.23A10.48 10.48 0 002.04 11.68c-.07.2-.07.43 0 .64C3.42 16.49 7.36 19.5 12 19.5a9.8 9.8 0 004.19-.93" />
                                    </svg>
                                </button>
                            </div>

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

                            <div class="password-field">
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-input password-input"
                                    autocomplete="new-password"
                                    {{ isset($user->id) ? '' : 'required' }}>

                                <button
                                    type="button"
                                    class="password-toggle"
                                    data-target="password_confirmation"
                                    aria-label="Mostrar u ocultar confirmación de contraseña"
                                    aria-pressed="false">

                                    <svg class="password-icon password-icon-eye"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 010-.644C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.438 0 .644C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z" />
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>

                                    <svg class="password-icon password-icon-eye-off hidden"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                        stroke="currentColor">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 3l18 18" />
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M10.58 10.58a2 2 0 002.83 2.83" />
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9.88 5.09A9.77 9.77 0 0112 4.5c4.64 0 8.58 3.01 9.96 7.18.07.21.07.44 0 .65a10.52 10.52 0 01-4.3 5.37" />
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6.23 6.23A10.48 10.48 0 002.04 11.68c-.07.2-.07.43 0 .64C3.42 16.49 7.36 19.5 12 19.5a9.8 9.8 0 004.19-.93" />
                                    </svg>
                                </button>
                            </div>

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