<div id="sidebar-content" class="admin-sidebar">

    {{-- HEADER --}}
    <div class="admin-header">

        <a href="{{ url('/') }}" class="admin-brand-container">
            <img src="{{ asset('images/logo.png') }}" class="admin-logo" alt="Logo">

            <div class="admin-brand-text">
                <span class="brand-aventura">AVENTURA</span>
                <span class="brand-506">506</span>
            </div>
        </a>

        <div class="admin-actions">

            {{-- THEME TOGGLE --}}
            <button id="theme-toggle" class="admin-icon-link" type="button">
                <svg id="icon-sun" class="w-5 h-5"
                    fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="4" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v2m0 14v2m9-9h-2M5 12H3
                   m15.364-6.364l-1.414 1.414
                   M7.05 16.95l-1.414 1.414
                   m0-11.314L7.05 7.05
                   m9.9 9.9l1.414 1.414" />
                </svg>

                <svg id="icon-moon" class="w-5 h-5 hidden"
                    fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.752 15.002A9 9 0 1112.998 2.248a7 7 0 108.754 12.754z" />
                </svg>
            </button>

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('admin.logout') }}" class="admin-logout">
                @csrf
                <button type="submit" class="admin-icon-link">
                    <svg class="w-5 h-5"
                        fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 17l5-5m0 0l-5-5m5 5H9" />
                    </svg>
                </button>
            </form>

        </div>

    </div>

    {{-- NAV --}}
    <nav class="admin-nav">
        <a href="{{ route('admin.dashboard') }}"
            class="admin-sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <a href="#" class="admin-sidebar-link">Reservas</a>
        <a href="{{ route('admin.tours.index') }}"
            class="admin-sidebar-link {{ request()->routeIs('admin.tours.*') ? 'active' : '' }}">
            Tours
        </a>
        <a href="#" class="admin-sidebar-link">Usuarios</a>
    </nav>

</div>