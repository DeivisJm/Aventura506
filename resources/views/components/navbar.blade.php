<header class="fixed top-0 left-0 w-full bg-white dark:bg-gray-900 shadow z-50">
    <nav class="max-w-7xl mx-auto px-4">
        <div class="relative flex items-center h-16 md:h-24">

            <!-- LEFT · LOGO -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 z-50 shrink-0">
                <img
                    id="navbar-logo"
                    src="{{ asset('images/logos/logolight.png') }}"
                    data-light="{{ asset('images/logos/logolight.png') }}"
                    data-dark="{{ asset('images/logos/logodark.png') }}"
                    alt="Aventura506 Logo"
                    class="h-10 sm:h-12 md:h-14 lg:h-20 w-auto object-contain transition-all duration-300">
            </a>

            <!-- CENTER + RIGHT WRAPPER · DESKTOP ONLY -->
            <div class="hidden md:flex flex-1 items-center justify-between min-w-0 ml-8">

                <!-- CENTER · MAIN NAV -->
                <div class="flex-1 flex justify-center min-w-0 px-6">
                    <ul class="nav-links flex items-center gap-6 lg:gap-8 font-medium whitespace-nowrap">
                        <li>
                            <a href="{{ route('home') }}"
                                class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                                {{ __('navigation.home') }}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('tours.index') }}"
                                class="nav-link {{ request()->routeIs('tours.*') ? 'active' : '' }}">
                                {{ __('navigation.tours') }}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('accommodations.index') }}"
                                class="nav-link {{ request()->routeIs('accommodations') ? 'active' : '' }}">
                                {{ __('navigation.accommodations') }}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('about') }}"
                                class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                                {{ __('navigation.about') }}
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('contact') }}"
                                class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                                {{ __('navigation.contact') }}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- RIGHT · ACTIONS -->
                <div class="flex items-center gap-3 lg:gap-4 shrink-0 z-50">

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
                    <div class="lang-switch flex rounded-full border-2 border-green-600 overflow-hidden text-xs font-semibold">
                        <a href="{{ route('lang.switch','es') }}"
                            class="lang-btn px-4 py-1.5 {{ app()->getLocale()==='es' ? 'is-active' : '' }}">
                            ES
                        </a>

                        <a href="{{ route('lang.switch','en') }}"
                            class="lang-btn px-4 py-1.5 {{ app()->getLocale()==='en' ? 'is-active' : '' }}">
                            EN
                        </a>
                    </div>

                    {{-- =====================================================
                        PROFILE MENU
                        Refined premium account menu with lighter navbar presence
                        ===================================================== --}}
                    <div class="relative" id="profile-menu-wrapper">

                        @auth
                        <button
                            type="button"
                            id="profile-menu-button"
                            aria-label="{{ __('profile.menu') }}"
                            aria-expanded="false"
                            class="profile-trigger-soft">

                            <span class="profile-trigger-soft-avatar">
                                {{ strtoupper(substr(auth()->user()->username ?: auth()->user()->name, 0, 1)) }}
                            </span>

                            <span class="profile-trigger-soft-name">
                                {{ auth()->user()->username ?: auth()->user()->name }}
                            </span>

                            <svg class="profile-trigger-soft-chevron"
                                id="profile-menu-chevron"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                            </svg>
                        </button>

                        <div id="profile-menu-dropdown" class="hidden profile-dropdown-soft">

                            {{-- User summary --}}
                            <div class="profile-dropdown-soft-header">
                                <div class="profile-dropdown-soft-avatar">
                                    {{ strtoupper(substr(auth()->user()->username ?: auth()->user()->name, 0, 1)) }}
                                </div>

                                <div class="profile-dropdown-soft-user">
                                    <p class="profile-dropdown-soft-name">
                                        {{ auth()->user()->name }}
                                    </p>

                                    <p class="profile-dropdown-soft-username">
                                        {{ auth()->user()->username }}
                                    </p>

                                    <p class="profile-dropdown-soft-email">
                                        {{ auth()->user()->email }}
                                    </p>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="profile-dropdown-soft-body">

                                <a href="{{ route('account.bookings') }}" class="profile-soft-link">
                                    <span class="profile-soft-link-icon">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-11 8h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </span>

                                    <span class="profile-soft-link-content">
                                        <span class="profile-soft-link-title">{{ __('profile.reservations') }}</span>
                                        <span class="profile-soft-link-subtitle">{{ __('profile.reservations_description') }}</span>
                                    </span>
                                </a>

                                <a href="{{ route('account.profile') }}" class="profile-soft-link">
                                    <span class="profile-soft-link-icon">
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a5 5 0 100-10 5 5 0 000 10z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 21a8 8 0 10-16 0" />
                                        </svg>
                                    </span>

                                    <span class="profile-soft-link-content">
                                        <span class="profile-soft-link-title">{{ __('profile.profile') }}</span>
                                        <span class="profile-soft-link-subtitle">{{ __('profile.profile_description') }}</span>
                                    </span>
                                </a>

                            </div>

                            {{-- Footer action --}}
                            <div class="profile-dropdown-soft-footer">
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="profile-soft-link profile-soft-link-danger w-full text-left">
                                        <span class="profile-soft-link-icon">
                                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H9m6-3l3 3-3 3" />
                                            </svg>
                                        </span>

                                        <span class="profile-soft-link-content">
                                            <span class="profile-soft-link-title">{{ __('profile.logout') }}</span>
                                            <span class="profile-soft-link-subtitle">{{ __('profile.menu') }}</span>
                                        </span>
                                    </button>
                                </form>
                            </div>

                        </div>
                        @else
                        <a href="{{ route('login') }}"
                            aria-label="{{ __('profile.login') }}"
                            class="profile-trigger-guest">

                            <svg class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 12a5 5 0 100-10 5 5 0 000 10z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M20 21a8 8 0 10-16 0" />
                            </svg>

                            <span class="hidden md:inline">
                                {{ __('profile.login') }}
                            </span>
                        </a>
                        @endauth

                    </div>

                </div>
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

        <ul class="flex flex-col p-6 space-y-4 font-medium text-base">

            {{-- Main navigation --}}
            <li>
                <a href="{{ route('home') }}"
                    class="mobile-nav-link flex items-center gap-3 transition {{ request()->routeIs('home') ? 'text-green-600 font-semibold' : '' }}">
                    {{ __('navigation.home') }}
                </a>
            </li>

            <li>
                <a href="{{ route('tours.index') }}"
                    class="mobile-nav-link flex items-center gap-3 transition {{ request()->routeIs('tours.*') ? 'text-green-600 font-semibold' : '' }}">
                    {{ __('navigation.tours') }}
                </a>
            </li>

            <li>
                <a href="{{ route('accommodations.index') }}"
                    class="mobile-nav-link flex items-center gap-3 transition {{ request()->routeIs('accommodations') ? 'text-green-600 font-semibold' : '' }}">
                    {{ __('navigation.accommodations') }}
                </a>
            </li>

            <li>
                <a href="{{ route('about') }}"
                    class="mobile-nav-link flex items-center gap-3 transition {{ request()->routeIs('about') ? 'text-green-600 font-semibold' : '' }}">
                    {{ __('navigation.about') }}
                </a>
            </li>

            <li>
                <a href="{{ route('contact') }}"
                    class="mobile-nav-link flex items-center gap-3 transition {{ request()->routeIs('contact') ? 'text-green-600 font-semibold' : '' }}">
                    {{ __('navigation.contact') }}
                </a>
            </li>

            <li class="border-t border-gray-200 dark:border-gray-800 my-3"></li>

            {{-- Account section --}}
            @auth
            <li class="mobile-account-item">

                {{-- Account trigger --}}
                <button
                    type="button"
                    id="mobile-account-toggle"
                    class="mobile-account-trigger"
                    aria-expanded="false"
                    aria-controls="mobile-account-dropdown">

                    <div class="mobile-account-summary">
                        <div class="mobile-account-avatar">
                            {{ strtoupper(substr(auth()->user()->username ?: auth()->user()->name, 0, 1)) }}
                        </div>

                        <div class="mobile-account-user">
                            <p class="mobile-account-name">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="mobile-account-username">
                                {{ auth()->user()->username ?: __('profile.not_registered') }}
                            </p>
                        </div>
                    </div>

                    <svg
                        id="mobile-account-chevron"
                        class="mobile-account-chevron"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                    </svg>
                </button>

                {{-- Account dropdown --}}
                <div id="mobile-account-dropdown" class="mobile-account-dropdown hidden">

                    <a href="{{ route('account.bookings') }}"
                        class="mobile-account-link {{ request()->routeIs('account.bookings') ? 'text-green-600 font-semibold' : '' }}">

                        <svg class="w-5 h-5 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10m-11 8h12a2 2 0 002-2V7a2 2 0 00-2-2H6a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>

                        <div>
                            <span class="block">{{ __('profile.reservations') }}</span>
                            <span class="block text-xs text-gray-500 dark:text-gray-400 font-normal">
                                {{ __('profile.reservations_description') }}
                            </span>
                        </div>
                    </a>

                    <a href="{{ route('account.profile') }}"
                        class="mobile-account-link {{ request()->routeIs('account.profile') ? 'text-green-600 font-semibold' : '' }}">

                        <svg class="w-5 h-5 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 12a5 5 0 100-10 5 5 0 000 10z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 21a8 8 0 10-16 0" />
                        </svg>

                        <div>
                            <span class="block">{{ __('profile.profile') }}</span>
                            <span class="block text-xs text-gray-500 dark:text-gray-400 font-normal">
                                {{ __('profile.profile_description') }}
                            </span>
                        </div>
                    </a>

                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="mobile-account-link mobile-account-link-danger w-full text-left">

                            <svg class="w-5 h-5 shrink-0"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18 12H9m6-3l3 3-3 3" />
                            </svg>

                            <div>
                                <span class="block">{{ __('profile.logout') }}</span>
                                <span class="block text-xs text-gray-500 dark:text-gray-400 font-normal">
                                    {{ __('profile.menu') }}
                                </span>
                            </div>
                        </button>
                    </form>

                </div>
            </li>
            @else
            <li>
                <a href="{{ route('login') }}"
                    class="mobile-nav-link flex items-center gap-3 transition {{ request()->routeIs('login') || request()->routeIs('register') ? 'text-green-600 font-semibold' : '' }}">

                    <svg class="w-5 h-5 shrink-0"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 12a5 5 0 100-10 5 5 0 000 10z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M20 21a8 8 0 10-16 0" />
                    </svg>

                    <span>{{ __('profile.login') }}</span>
                </a>
            </li>
            @endauth

            <li class="border-t border-gray-200 dark:border-gray-800 my-3"></li>

            {{-- Theme toggle --}}
            <li>
                <button type="button"
                    id="theme-toggle-mobile"
                    class="mobile-nav-link flex items-center gap-3 w-full text-left transition">

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

                    <svg id="icon-moon-mobile"
                        class="w-5 h-5 hidden"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.752 15.002A9 9 0 1112.998 2.248a7 7 0 108.754 12.754z" />
                    </svg>

                    {{ __('navigation.change_theme') }}
                </button>
            </li>

            {{-- Language switch --}}
            <li class="pt-2">
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('navigation.language') }}:
                    </span>

                    <a href="{{ route('lang.switch','es') }}"
                        class="px-3 py-1 rounded-full border text-xs transition
                           border-gray-300 dark:border-gray-600
                           {{ app()->getLocale()==='es' ? 'bg-green-600 text-white border-green-600' : 'hover:bg-green-600 hover:text-white' }}">
                        ES
                    </a>

                    <a href="{{ route('lang.switch','en') }}"
                        class="px-3 py-1 rounded-full border text-xs transition
                           border-gray-300 dark:border-gray-600
                           {{ app()->getLocale()==='en' ? 'bg-green-600 text-white border-green-600' : 'hover:bg-green-600 hover:text-white' }}">
                        EN
                    </a>
                </div>
            </li>

        </ul>
    </div>
</header>