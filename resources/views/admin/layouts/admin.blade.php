<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <title>Panel Administrativo | Aventura506</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>


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