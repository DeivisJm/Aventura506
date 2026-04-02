<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @hasSection('title')
        @yield('title') | Aventura506
        @else
        Aventura506
        @endif
    </title>

    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');

            if (
                savedTheme === 'dark' ||
                (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="/images/logos/logo.png">

    <style>
        html {
            background-color: #ffffff;
        }

        html.dark {
            background-color: #111827;
        }

        body {
            background-color: #ffffff;
        }

        html.dark body {
            background-color: #111827;
        }
    </style>

    {{-- VITE --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- SEO --}}
    @if(app()->getLocale() === 'es')
    <link rel="alternate" hreflang="es-cr" href="{{ url()->current() }}" />
    <link rel="alternate" hreflang="en" href="{{ route('lang.switch', 'en') }}" />
    @else
    <link rel="alternate" hreflang="en" href="{{ url()->current() }}" />
    <link rel="alternate" hreflang="es-cr" href="{{ route('lang.switch', 'es') }}" />
    @endif

    <link rel="alternate" hreflang="x-default" href="{{ url('/') }}" />

    {{-- intl-tel-input CSS --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">

    {{-- country-select CSS --}}
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/country-select-js@2.1.1/build/css/countrySelect.min.css">

</head>

<body class="bg-white text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">

    {{-- NAVBAR --}}
    @if (!isset($hideNavbar) || !$hideNavbar)
    @include('components.navbar')
    @endif


    {{--BOOKING MESSAGE --}}
    <x-booking-success />

    {{-- SUBSCRIBE MESSAGE --}}
    <x-subscribe-feedback />

    {{-- CONTACT MESSAGE --}}
    <x-contact-feedback />

    <main class="{{ isset($hideNavbar) ? '' : 'pt-24 md:pt-28' }}">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @if (!isset($hideFooter) || !$hideFooter)
    @include('components.footer')
    @endif


    {{-- ================= WHATSAPP FLOAT BUTTON ================= --}}
    @if(!auth()->check() || auth()->user()->role->name !== 'superadmin')
    <a href="https://wa.me/50683217459?text={{ urlencode(__('whatsapp.floating_message')) }}"
        target="_blank"
        aria-label="WhatsApp"
        class="whatsapp-float">
        <svg class="whatsapp-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12.04 2C6.53 2 2 6.53 2 12c0 2.12.56 4.19 1.63 6.02L2 22l4.13-1.58A9.96 9.96 0 0 0 12.04 22C17.56 22 22 17.47 22 12S17.56 2 12.04 2zm0 18.02c-1.71 0-3.38-.45-4.84-1.31l-.35-.21-2.45.94.93-2.38-.23-.37a8.02 8.02 0 1 1 6.94 3.33zm4.43-5.86c-.24-.12-1.4-.69-1.62-.77-.22-.08-.38-.12-.54.12-.16.24-.62.77-.76.93-.14.16-.28.18-.52.06-.24-.12-1.01-.37-1.93-1.18-.71-.63-1.18-1.41-1.32-1.65-.14-.24-.02-.37.1-.49.1-.1.24-.28.36-.42.12-.14.16-.24.24-.4.08-.16.04-.3-.02-.42-.06-.12-.54-1.3-.74-1.78-.2-.48-.4-.42-.54-.43-.14 0-.3 0-.46 0-.16 0-.42.06-.64.3-.22.24-.84.83-.84 2.02 0 1.19.87 2.35.99 2.51.12.16 1.7 2.62 4.13 3.67.58.25 1.03.4 1.38.51.58.18 1.11.15 1.52.09.47-.07 1.4-.57 1.6-1.13.2-.56.2-1.02.14-1.13-.06-.1-.22-.16-.46-.28z" />
        </svg>
    </a>
    @endif

    <!--Flags -->
    <!-- jQuery PRIMERO -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- intl-tel-input -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.1.1/build/js/intlTelInput.min.js"></script>

    <!-- country-select (VERSIÓN CORRECTA) -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.1.0/css/countrySelect.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/country-select-js/2.1.0/js/countrySelect.min.js"></script>


    @stack('scripts')

</body>

</html>