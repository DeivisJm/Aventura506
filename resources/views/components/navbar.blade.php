<header class="fixed top-0 left-0 w-full bg-white shadow z-50">
    <nav class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-24">


            {{-- LOGO --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">

                {{-- Logo image --}}
                <img
                    src="{{ asset('images/logo2.png') }}"
                    alt="Aventura506 Logo"
                    class="h-20 md:h-24 lg:h-28 w-auto object-contain">


            </a>

            {{-- DESKTOP MENU --}}
            <ul class="nav-links hidden md:flex space-x-6 font-medium">

                <li>
                    <a href="/"
                        class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        Inicio
                    </a>
                </li>

                <li>
                    <a href="/destinations"
                        class="nav-link {{ request()->is('destinations') ? 'active' : '' }}">
                        Destinos
                    </a>
                </li>

                <li>
                    <a href="/packages"
                        class="nav-link {{ request()->is('packages') ? 'active' : '' }}">
                        Paquetes
                    </a>
                </li>

                <li>
                    <a href="/contact"
                        class="nav-link {{ request()->is('contact') ? 'active' : '' }}">
                        Contacto
                    </a>
                </li>

            </ul>

            {{-- MOBILE BUTTON --}}
            <button id="menu-btn"
                class="md:hidden focus:outline-none text-gray-700 hover:text-green-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </nav>

    {{-- MOBILE MENU --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <ul class="flex flex-col p-4 space-y-3 font-medium">

            <li>
                <a href="/"
                    class="mobile-nav-link {{ request()->is('/') ? 'active' : '' }}">
                    Inicio
                </a>
            </li>

            <li>
                <a href="/destinations"
                    class="mobile-nav-link {{ request()->is('destinations') ? 'active' : '' }}">
                    Destinos
                </a>
            </li>

            <li>
                <a href="/packages"
                    class="mobile-nav-link {{ request()->is('packages') ? 'active' : '' }}">
                    Paquetes
                </a>
            </li>

            <li>
                <a href="/contact"
                    class="mobile-nav-link {{ request()->is('contact') ? 'active' : '' }}">
                    Contacto
                </a>
            </li>

        </ul>
    </div>
</header>