@extends('admin.layouts.admin')

@section('admin-content')

<div class="dashboard-premium-lite">

    {{-- ========================================
         Header
    ========================================= --}}
    <div class="dashboard-premium-lite__header">
        <div>
            <h1 class="admin-page-title">
                Panel Administrativo
            </h1>

            <p class="admin-page-subtitle">
                Resumen general del sistema
            </p>
        </div>
    </div>

    {{-- ========================================
         Main KPI cards
    ========================================= --}}
    <section class="dashboard-kpi-lite-grid">

        <article class="dashboard-kpi-lite-card">
            <span class="dashboard-kpi-lite-card__label">
                Total de Reservas de Tours
            </span>

            <h2 class="dashboard-kpi-lite-card__value">
                {{ $totalBookings ?? 0 }}
            </h2>

            <p class="dashboard-kpi-lite-card__hint">
                Reservas registradas en la plataforma
            </p>
        </article>

        <article class="dashboard-kpi-lite-card dashboard-kpi-lite-card--success">
            <span class="dashboard-kpi-lite-card__label">
                Ingresos en USD
            </span>

            <h2 class="dashboard-kpi-lite-card__value dashboard-kpi-lite-card__value--success">
                ${{ number_format($totalRevenueUsd ?? 0, 2) }}
            </h2>

            <p class="dashboard-kpi-lite-card__hint">
                Ingreso acumulado en dólares
            </p>
        </article>

        <article class="dashboard-kpi-lite-card dashboard-kpi-lite-card--success">
            <span class="dashboard-kpi-lite-card__label">
                Ingresos en CRC
            </span>

            <h2 class="dashboard-kpi-lite-card__value dashboard-kpi-lite-card__value--success">
                ₡{{ number_format($totalRevenueCrc ?? 0, 0) }}
            </h2>

            <p class="dashboard-kpi-lite-card__hint">
                Ingreso acumulado en colones
            </p>
        </article>

        <article class="dashboard-kpi-lite-card dashboard-kpi-lite-card--module">
            <div class="dashboard-kpi-lite-card__top">
                <span class="dashboard-kpi-lite-card__label">
                    LIsta de Tours
                </span>

                <span class="dashboard-kpi-lite-card__icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 20h18M6 20V10l6-4 6 4v10M9 20v-4h6v4" />
                    </svg>
                </span>
            </div>

            <h2 class="dashboard-kpi-lite-card__value">
                {{ $totalTours ?? 0 }}
            </h2>

            <div class="dashboard-kpi-lite-card__badges dashboard-kpi-lite-card__badges--stack">
                <span class="dashboard-lite-badge dashboard-lite-badge--active">
                    Activos: {{ $activeTours ?? 0 }}
                </span>

                <span class="dashboard-lite-badge dashboard-lite-badge--inactive">
                    Inactivos: {{ $inactiveTours ?? 0 }}
                </span>
            </div>
        </article>

    </section>

    {{-- ========================================
         Secondary compact strip
    ========================================= --}}
    <section class="dashboard-secondary-lite-grid">

        <article class="dashboard-secondary-lite-card">
            <div class="dashboard-secondary-lite-card__head">
                <span class="dashboard-secondary-lite-card__label">
                   Listas de  Hospedajes
                </span>
            </div>

            <div class="dashboard-secondary-lite-card__body">
                <strong class="dashboard-secondary-lite-card__value">
                    {{ $totalAccommodations ?? 0 }}
                </strong>

                <div class="dashboard-secondary-lite-card__badges">
                    <span class="dashboard-lite-badge dashboard-lite-badge--active">
                        {{ $activeAccommodations ?? 0 }} activos
                    </span>

                    <span class="dashboard-lite-badge dashboard-lite-badge--inactive">
                        {{ $inactiveAccommodations ?? 0 }} inactivos
                    </span>
                </div>
            </div>
        </article>

        <article class="dashboard-secondary-lite-card dashboard-secondary-lite-card--compact">
            <div class="dashboard-secondary-lite-card__head">
                <span class="dashboard-secondary-lite-card__label">
                    Tipo de cambio actual
                </span>
            </div>

            <div class="dashboard-secondary-lite-card__body">
                <strong class="dashboard-secondary-lite-card__value">
                    ₡{{ number_format($currentExchangeRate ?? 0, 2) }}
                </strong>
            </div>
        </article>

    </section>

    {{-- ========================================
         Chart
    ========================================= --}}
    <section class="dashboard-chart-lite">
        <div class="dashboard-chart-lite__header">
            <div>
                <h3 class="dashboard-chart-lite__title">
                    Reservas por Mes
                </h3>

                <p class="dashboard-chart-lite__subtitle">
                    Tendencia mensual de reservas registradas
                </p>
            </div>
        </div>

        <div class="dashboard-chart-lite__canvas">
            <canvas
                id="bookingChart"
                data-labels='@json(($monthlyBookings ?? collect())->pluck("month"))'
                data-values='@json(($monthlyBookings ?? collect())->pluck("total"))'>
            </canvas>
        </div>
    </section>

</div>

@endsection