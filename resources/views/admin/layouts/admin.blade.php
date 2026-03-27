<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logos/logo.png') }}">

    <title>Panel Administrativo | Aventura506</title>

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

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<meta name="csrf-token" content="{{ csrf_token() }}">

<body class="bg-gray-50 dark:bg-[#0b1220] transition-colors duration-300">

    <div class="admin-layout">

        {{-- ========================================== --}}
        {{-- SIDEBAR --}}
        {{-- ========================================== --}}

        <aside class="admin-sidebar">

            @include('admin.partials.sidebar')

        </aside>


        {{-- ========================================== --}}
        {{-- CONTENT AREA --}}
        {{-- ========================================== --}}

        <div class="admin-content">

            <main class="admin-main">

                @yield('admin-content')

            </main>

        </div>

    </div>

</body>

</html>