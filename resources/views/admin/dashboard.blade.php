@extends('admin.layouts.admin')

@section('admin-content')

<div class="flex justify-between items-center mb-10">

    {{-- Logo + Title --}}
    <div class="flex items-center gap-4">

        <div>
            <h1 class="admin-page-title">
                Panel Administrativo
            </h1>

            <p class="admin-page-subtitle">
                Resumen general del sistema
            </p>
        </div>
    </div>


</div>

{{-- KPI Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-8 mb-12">
    {{-- Total Reservations --}}
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg 
                hover:shadow-xl transition">

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Total de Reservas
        </p>

        <h2 class="text-4xl font-bold mt-3 text-gray-900 dark:text-white">
            {{ $totalBookings ?? 0 }}
        </h2>
    </div>

    {{-- USD Revenue --}}
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg 
                hover:shadow-xl transition">

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Ingresos en USD
        </p>

        <h2 class="text-4xl font-bold mt-3 text-green-600">
            ${{ number_format($totalRevenueUsd ?? 0, 2) }}
        </h2>
    </div>

    {{-- CRC Revenue --}}
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg 
                hover:shadow-xl transition">

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Ingresos en CRC
        </p>

        <h2 class="text-4xl font-bold mt-3 text-green-600">
            ₡{{ number_format($totalRevenueCrc ?? 0, 0) }}
        </h2>
    </div>

    {{-- Tours Overview --}}
    <div class="bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg hover:shadow-xl transition">

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Total de Tours
        </p>

        <h2 class="text-4xl font-bold mt-2 text-gray-900 dark:text-white">
            {{ $totalTours ?? 0 }}
        </h2>

        <div class="flex items-center gap-6 mt-4 text-sm font-medium">

            <span class="text-green-600">
                Activos: {{ $activeTours ?? 0 }}
            </span>

            <span class="text-red-500">
                Inactivos: {{ $inactiveTours ?? 0 }}
            </span>

        </div>

    </div>

</div>


{{-- Chart Section --}}
<div class="bg-white dark:bg-gray-800 p-6 md:p-8 rounded-2xl shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-xl font-semibold text-gray-800 dark:text-white">
            Reservas por Mes
        </h3>
    </div>

    <div class="h-80">
        <canvas
            id="bookingChart"
            data-labels='@json(($monthlyBookings ?? collect())->pluck("month"))'
            data-values='@json(($monthlyBookings ?? collect())->pluck("total"))'>
        </canvas>
    </div>

</div>

@endsection