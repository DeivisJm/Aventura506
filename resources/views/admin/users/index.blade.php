@extends('admin.layouts.admin')

@section('admin-content')

<div class="flex justify-between items-center mb-10">

    <div>

        <h1 class="admin-page-title">
            Usuarios
        </h1>

        <p class="admin-page-subtitle">
            Administración de usuarios registrados y suscriptores del sistema
        </p>

    </div>

    <a href="{{ route('admin.users.create') }}"
        class="admin-btn-primary">

        Nuevo usuario

    </a>

</div>


{{-- ========================================
USERS TABLE
======================================== --}}
<div class="admin-card mb-8">

    <div class="mb-2">
        <h2 class="admin-section-title">
            Usuarios Registrados
        </h2>

        <p class="admin-section-description mt-2">
            Gestiona las cuentas creadas dentro de la plataforma.
        </p>
    </div>

    <table class="admin-table users-table">

        <thead>

            <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>

        </thead>

        <tbody>

            @forelse($users as $user)

            @php
            $isLastProtectedAdmin = ((int) $user->role_id === 1) && ($users->where('role_id', 1)->count() === 1);
            @endphp

            <tr>

                <td>
                    <div class="users-person-cell">

                        <div class="users-avatar users-avatar-user">
                            {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                        </div>

                        <div class="users-main-text">
                            {{ $user->name }}
                        </div>

                    </div>
                </td>

                <td class="users-secondary-text">
                    {{ $user->email }}
                </td>

                <td>
                    <span class="users-role-badge
                {{ $user->role?->name === 'superadmin'
                    ? 'users-role-badge-admin'
                    : 'users-role-badge-client' }}">
                        {{ $user->role?->name ?? 'Sin rol' }}
                    </span>
                </td>

                <td class="users-actions-cell">
                    <div class="users-actions">

                        <a
                            href="{{ route('admin.users.edit', $user) }}"
                            class="users-btn users-btn-edit">
                            Editar
                        </a>

                        @if($isLastProtectedAdmin)
                        <button
                            type="button"
                            class="users-btn users-btn-delete users-btn-delete-disabled"
                            title="No se puede eliminar porque es el único Superadministrador del sistema."
                            disabled>
                            Eliminar
                        </button>
                        @else
                        <form
                            method="POST"
                            action="{{ route('admin.users.destroy', $user) }}"
                            class="delete-confirm-form"
                            data-delete-title="Eliminar usuario"
                            data-delete-message="Esta acción eliminará al usuario seleccionado del sistema.">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="users-btn users-btn-delete">
                                Eliminar
                            </button>
                        </form>
                        @endif

                    </div>
                </td>

            </tr>

            @empty

            <tr>
                <td colspan="4" class="text-center py-10 text-gray-500 dark:text-gray-400">
                    No hay usuarios registrados
                </td>
            </tr>

            @endforelse

        </tbody>


    </table>

</div>


{{-- ========================================
SUBSCRIBERS TABLE
======================================== --}}
<div class="admin-card">

    <div class="mb-2">
        <h2 class="admin-section-title">
            Suscriptores
        </h2>

        <p class="admin-section-description mt-2">
            Correos registrados desde los formularios de suscripción.
        </p>
    </div>

    <table class="admin-table users-table">

        <thead>

            <tr>
                <th>Correo</th>
                <th class="text-right">Acciones</th>

            </tr>

        </thead>

        <tbody>

            @forelse($subscribers as $subscriber)

            <tr>

                <td>
                    <div class="users-person-cell">

                        <div class="users-avatar users-avatar-subscriber">
                            @
                        </div>

                        <div class="users-main-text">
                            {{ $subscriber->email }}
                        </div>

                    </div>
                </td>

                <td class="users-actions-cell">
                    <div class="users-actions">

                        <a
                            href="{{ route('admin.subscribers.edit', $subscriber) }}"
                            class="users-btn users-btn-edit">

                            Editar

                        </a>

                        <form
                            method="POST"
                            action="{{ route('admin.subscribers.destroy', $subscriber) }}"
                            class="delete-confirm-form"
                            data-delete-title="Eliminar suscriptor"
                            data-delete-message="Esta acción eliminará el correo seleccionado de la lista de suscriptores.">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="users-btn users-btn-delete">

                                Eliminar

                            </button>

                        </form>

                    </div>
                </td>

            </tr>

            @empty

            <tr>

                <td colspan="2" class="text-center py-10 text-gray-500 dark:text-gray-400">
                    No hay suscriptores registrados
                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection