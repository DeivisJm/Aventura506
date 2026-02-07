<header class="fixed top-0 left-0 w-full bg-white dark:bg-gray-900 shadow z-50">
    <nav class="max-w-7xl mx-auto px-4">
        <div class="relative flex items-center h-16 md:h-24">

            <!-- LEFT · LOGO -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 z-50">
                <img
                    id="navbar-logo"
                    src="{{ asset('images/logolight.png') }}"
                    data-light="{{ asset('images/logolight.png') }}"
                    data-dark="{{ asset('images/logodark.png') }}"
                    alt="Aventura506 Logo"
                    class="h-10 sm:h-12 md:h-14 lg:h-20 w-auto object-contain transition-all duration-300">
            </a>

            <!-- CENTER · MAIN NAV -->
            <div class="absolute left-1/2 -translate-x-1/2 hidden md:block">
                <ul class="nav-links flex items-center gap-8 font-medium">
                    <li><a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">{{ __('navigation.home') }}</a></li>
                    <li><a href="/tours" class="nav-link {{ request()->is('tours') ? 'active' : '' }}">{{ __('navigation.tours') }}</a></li>
                    <li><a href="/accommodations" class="nav-link {{ request()->is('accommodations') ? 'active' : '' }}">{{ __('navigation.accommodations') }}</a></li>
                    <li><a href="/about_us" class="nav-link {{ request()->is('about_us') ? 'active' : '' }}">{{ __('navigation.about') }}</a></li>
                    <li><a href="/contact" class="nav-link {{ request()->is('contact') ? 'active' : '' }}">{{ __('navigation.contact') }}</a></li>
                </ul>
            </div>

            <!-- RIGHT · ACTIONS (DESKTOP) -->
            <div class="ml-auto hidden md:flex items-center gap-4 z-50">

                <!-- Theme toggle -->
                <button id="theme-toggle"
                    aria-label="Toggle theme"
                    class="nav-icon p-2 transition text-gray-900 dark:text-gray-100 hover:text-green-600">


                    <!-- SUN -->
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

                    <!-- MOON -->
                    <svg id="icon-moon" class="w-5 h-5 hidden"
                        fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.752 15.002A9 9 0 1112.998 2.248a7 7 0 108.754 12.754z" />
                    </svg>
                </button>

                <!-- Language switch -->
                <div class="flex rounded-full border border-gray-400 dark:border-gray-700 bg-gray-100 dark:bg-transparent overflow-hidden text-xs font-semibold">
                    <a href="{{ route('lang.switch','es') }}"
                        class="px-3 py-1 transition
                        {{ app()->getLocale()==='es'
                            ? 'bg-green-600 text-white'
                            : 'text-gray-800 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-800' }}">
                        ES
                    </a>
                    <a href="{{ route('lang.switch','en') }}"
                        class="px-3 py-1 transition
                        {{ app()->getLocale()==='en'
                            ? 'bg-green-600 text-white'
                            : 'text-gray-800 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-800' }}">
                        EN
                    </a>
                </div>

                <!-- Profile -->
                <button aria-label="Profile"
                    class="nav-icon transition text-gray-900 dark:text-gray-100 hover:text-green-600">
                    <svg class="w-5 h-5"
                        fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 12a5 5 0 100-10 5 5 0 000 10z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 21a8 8 0 10-16 0" />
                    </svg>
                </button>
            </div>

            <!-- MOBILE MENU BUTTON -->
            <button id="menu-btn"
                class="md:hidden ml-auto p-2 z-50 text-gray-900 dark:text-gray-100 hover:text-green-600 transition">
                <svg class="w-6 h-6"
                    fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

        </div>
    </nav>

    <!-- ================= MOBILE MENU ================= -->
    <div id="mobile-menu"
        class="mobile-menu bg-white dark:bg-gray-900 border-t dark:border-gray-800 shadow-lg">

        <ul class="flex flex-col p-6 space-y-4 font-medium">

            <li><a href="/" class="mobile-nav-link">{{ __('navigation.home') }}</a></li>
            <li><a href="/tours" class="mobile-nav-link">{{ __('navigation.tours') }}</a></li>
            <li><a href="/accommodations" class="mobile-nav-link">{{ __('navigation.accommodations') }}</a></li>
            <li><a href="/about_us" class="mobile-nav-link">{{ __('navigation.about') }}</a></li>
            <li><a href="/contact" class="mobile-nav-link">{{ __('navigation.contact') }}</a></li>

            <li class="border-t pt-4"></li>

            <!-- Theme toggle -->
            <li>
                <button
                    type="button"
                    id="theme-toggle-mobile"
                    class="nav-icon flex items-center gap-3 text-gray-900 dark:text-gray-100 hover:text-green-600 transition">


                    <!-- SUN -->
                    <svg id="icon-sun-mobile"
                        class="w-5 h-5"
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

                    <!-- MOON -->
                    <svg id="icon-moon-mobile"
                        class="w-5 h-5 hidden"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.752 15.002A9 9 0 1112.998 2.248a7 7 0 108.754 12.754z" />
                    </svg>

                    <span>{{ __('navigation.change_theme') }}</span>
                </button>

            </li>

            <!-- Language -->
            <li class="flex items-center gap-3">
                <span class="text-sm text-gray-500">{{ __('navigation.language') }}:</span>
                <a href="{{ route('lang.switch','es') }}"
                    class="px-3 py-1 rounded-full border text-xs
                    {{ app()->getLocale()==='es' ? 'bg-green-600 text-white' : '' }}">
                    ES
                </a>
                <a href="{{ route('lang.switch','en') }}"
                    class="px-3 py-1 rounded-full border text-xs
                    {{ app()->getLocale()==='en' ? 'bg-green-600 text-white' : '' }}">
                    EN
                </a>
            </li>

        </ul>
    </div>
</header>