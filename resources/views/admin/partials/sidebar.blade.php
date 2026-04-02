<div id="sidebar-content" class="admin-sidebar">

    <!-- HEADER -->
    <div class="admin-header">

        <!-- BRAND -->
        <a href="{{ url('/') }}" class="admin-brand-container">

            <!-- LOGO -->
            <img
                id="admin-logo"
                src="{{ asset('images/logos/logo.png') }}"
                class="admin-logo"
                alt="Logo">

            <!-- BRAND TEXT -->
            <img
                id="admin-letter"
                src="{{ asset('images/logos/letterlight.png') }}"
                data-light="{{ asset('images/logos/letterlight.png') }}"
                data-dark="{{ asset('images/logos/letterdark.png') }}"
                class="admin-letter"
                alt="Brand">

        </a>

        <!-- ACTION BAR -->
        <div class="admin-actions">

            <!-- THEME TOGGLE -->
            <button id="theme-toggle" class="admin-icon-link admin-action-icon" type="button">

                <svg id="icon-sun" class="admin-icon"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">

                    <circle cx="12" cy="12" r="4"></circle>

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3v2m0 14v2m9-9h-2M5 12H3
                        m15.364-6.364l-1.414 1.414
                        M7.05 16.95l-1.414 1.414
                        m0-11.314L7.05 7.05
                        m9.9 9.9l1.414 1.414" />

                </svg>

                <svg id="icon-moon" class="admin-icon hidden"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21.752 15.002A9 9 0 1112.998 2.248a7 7 0 108.754 12.754z" />

                </svg>

            </button>

            <!-- LOGOUT -->
            <form method="POST"
                action="{{ route('admin.logout') }}"
                class="admin-logout-form">

                @csrf

                <button
                    type="submit"
                    class="admin-logout-btn admin-action-icon"
                    title="Cerrar sesión"
                    aria-label="Cerrar sesión">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="admin-icon logout-icon"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M18 12H9m6-3l3 3-3 3" />

                    </svg>

                </button>

            </form>

        </div>

    </div>

    <!-- NAVIGATION -->
    <nav class="admin-nav">

        <a href="{{ route('admin.dashboard') }}"
            class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            Panel Administrativo
        </a>

        <a href="#" class="admin-sidebar-link">
            Reservas
        </a>

        <a href="{{ route('admin.tours.index') }}"
            class="admin-sidebar-link {{ request()->routeIs('admin.tours.*', 'admin.categories.*', 'admin.companies.*') ? 'active' : '' }}">
            Tours
        </a>

        <div class="admin-subnav {{ request()->routeIs('admin.tours.*', 'admin.categories.*', 'admin.companies.*') ? 'open' : '' }}">

            <a href="{{ route('admin.categories.index') }}"
                class="admin-sidebar-sublink {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                Categorías
            </a>

            <a href="{{ route('admin.companies.index') }}"
                class="admin-sidebar-sublink {{ request()->routeIs('admin.companies.*') ? 'active' : '' }}">
                Compañías
            </a>

        </div>

        <a href="{{ route('admin.accommodations.index') }}"
            class="admin-sidebar-link {{ request()->routeIs('admin.accommodations.*') ? 'active' : '' }}">
            Hospedajes
        </a>

        <a href="{{ route('admin.users.index') }}"
            class="admin-sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            Usuarios
        </a>

        <a href="{{ route('admin.exchange_rates.index') }}"
            class="admin-sidebar-link {{ request()->routeIs('admin.exchange_rates.*') ? 'active' : '' }}">

            Tipos de Cambio

        </a>

    </nav>

</div>