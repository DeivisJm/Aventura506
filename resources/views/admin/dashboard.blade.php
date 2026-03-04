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
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">

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