<header class="fixed top-0 left-0 w-full bg-white shadow z-50">
    <nav class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-24">

            {{-- ================= LOGO ================= --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3">

                <img
                    id="navbar-logo"
                    src="{{ asset('images/logolight.png') }}"
                    data-light="{{ asset('images/logolight.png') }}"
                    data-dark="{{ asset('images/logodark.png') }}"
                    alt="Aventura506 Logo"
                    class="h-20 md:h-24 lg:h-28 w-auto object-contain transition-all duration-300">

            </a>

            {{-- ================= RIGHT SIDE (DESKTOP) ================= --}}
            <div class="hidden md:flex items-center gap-6">

                {{-- MENU LINKS --}}
                <ul class="nav-links flex space-x-6 font-medium">

                    <li>
                        <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                            Inicio
                        </a>
                    </li>

                    <li>
                        <a href="/tours" class="nav-link {{ request()->is('tours') ? 'active' : '' }}">
                            Tours
                        </a>
                    </li>

                    <li>
                        <a href="/accommodations" class="nav-link {{ request()->is('accommodations') ? 'active' : '' }}">
                            Hospedajes
                        </a>
                    </li>

                    <li>
                        <a href="/about_us" class="nav-link {{ request()->is('about_us') ? 'active' : '' }}">
                            Sobre Nosotros
                        </a>
                    </li>

                    <li>
                        <a href="/contact" class="nav-link {{ request()->is('contact') ? 'active' : '' }}">
                            Contacto
                        </a>
                    </li>
                </ul>

                {{-- ================= THEME TOGGLE ================= --}}
                <button
                    id="theme-toggle"
                    aria-label="Toggle theme"
                    class="p-2 rounded-full
                           text-gray-600 hover:text-green-600
                           transition-colors duration-300">

                    {{-- SUN ICON --}}
                    <svg id="icon-sun"
                        class="w-6 h-6 block"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v2m0 14v2m9-9h-2M5 12H3
                               m15.364-6.364l-1.414 1.414
                               M7.05 16.95l-1.414 1.414
                               m0-11.314L7.05 7.05
                               m9.9 9.9l1.414 1.414" />
                        <circle cx="12" cy="12" r="4" />
                    </svg>

                    {{-- MOON ICON --}}
                    <svg id="icon-moon"
                        class="w-6 h-6 hidden"
                        fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M21.752 15.002A9 9 0 1112.998 2.248
                               a7 7 0 108.754 12.754z" />
                    </svg>
                </button>
            </div>

            {{-- ================= MOBILE BUTTON ================= --}}
            <button
                id="menu-btn"
                class="md:hidden focus:outline-none text-gray-700 hover:text-green-600 transition">

                <svg class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

        </div>
    </nav>

    {{-- ================= MOBILE MENU ================= --}}
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <ul class="flex flex-col p-4 space-y-3 font-medium">

            <li>
                <a href="/" class="mobile-nav-link {{ request()->is('/') ? 'active' : '' }}">
                    Inicio
                </a>
            </li>

            <li>
                <a href="/tours" class="mobile-nav-link {{ request()->is('tours') ? 'active' : '' }}">
                    Tours
                </a>
            </li>

            <li>
                <a href="/accommodations" class="mobile-nav-link {{ request()->is('accommodations') ? 'active' : '' }}">
                    Hospedajes
                </a>
            </li>

            <li>
                <a href="/about_us" class="mobile-nav-link {{ request()->is('about_us') ? 'active' : '' }}">
                    Sobre Nosotros
                </a>
            </li>

            <li>
                <a href="/contact" class="mobile-nav-link {{ request()->is('contact') ? 'active' : '' }}">
                    Contacto
                </a>
            </li>

            {{-- ================= THEME TOGGLE (MOBILE) ================= --}}
            <li class="pt-4 border-t">
                <button
                    id="theme-toggle-mobile"
                    aria-label="Toggle theme"
                    class="flex items-center gap-3
               text-black-700 dark:text-black-200
               hover:text-green-600 transition-colors">

                    {{-- SUN --}}
                    <svg id="icon-sun-mobile"
                        class="w-5 h-5 block"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="4" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v2m0 14v2m9-9h-2M5 12H3
                   m15.364-6.364l-1.414 1.414
                   M7.05 16.95l-1.414 1.414
                   m0-11.314L7.05 7.05
                   m9.9 9.9l1.414 1.414" />
                    </svg>

                    {{-- MOON --}}
                    <svg id="icon-moon-mobile"
                        class="w-5 h-5 hidden"
                        fill="currentColor"
                        viewBox="0 0 24 24">
                        <path d="M21.752 15.002A9 9 0 1112.998 2.248a7 7 0 108.754 12.754z" />
                    </svg>

                    <span class="text-sm font-medium">
                        Cambiar tema
                    </span>
                </button>
            </li>
        </ul>
    </div>
</header>