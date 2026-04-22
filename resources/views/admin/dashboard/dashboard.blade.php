@extends('admin.layouts.admin')

@section('admin-content')

@php
/*
|--------------------------------------------------------------------------
| Normalize monthly bookings data
|--------------------------------------------------------------------------
| The chart dataset may come as stdClass items from the query builder.
| We convert every row to an array so the view can safely use array access.
*/
$monthlyBookingsCollection = collect($monthlyBookings ?? [])->map(function ($item) {
return is_array($item) ? $item : (array) $item;
});

/*
|--------------------------------------------------------------------------
| Normalize month names to full Spanish labels
|--------------------------------------------------------------------------
| This lets the dashboard display full month names consistently in the
| best month card and in the chart labels.
*/
$monthNames = [
'1' => 'Enero',
'01' => 'Enero',
'jan' => 'Enero',
'january' => 'Enero',

'2' => 'Febrero',
'02' => 'Febrero',
'feb' => 'Febrero',
'february' => 'Febrero',

'3' => 'Marzo',
'03' => 'Marzo',
'mar' => 'Marzo',
'march' => 'Marzo',

'4' => 'Abril',
'04' => 'Abril',
'apr' => 'Abril',
'april' => 'Abril',

'5' => 'Mayo',
'05' => 'Mayo',
'may' => 'Mayo',

'6' => 'Junio',
'06' => 'Junio',
'jun' => 'Junio',
'june' => 'Junio',

'7' => 'Julio',
'07' => 'Julio',
'jul' => 'Julio',
'july' => 'Julio',

'8' => 'Agosto',
'08' => 'Agosto',
'aug' => 'Agosto',
'august' => 'Agosto',

'9' => 'Septiembre',
'09' => 'Septiembre',
'sep' => 'Septiembre',
'sept' => 'Septiembre',
'september' => 'Septiembre',

'10' => 'Octubre',
'oct' => 'Octubre',
'october' => 'Octubre',

'11' => 'Noviembre',
'nov' => 'Noviembre',
'november' => 'Noviembre',

'12' => 'Diciembre',
'dec' => 'Diciembre',
'december' => 'Diciembre',
];

$formatMonthName = function ($month) use ($monthNames) {
$key = strtolower(trim((string) $month));
return $monthNames[$key] ?? (string) $month;
};

$chartLabelsFull = $monthlyBookingsCollection->pluck('month')->map(function ($month) use ($formatMonthName) {
return $formatMonthName($month);
});

$yearlyBookingsTotal = $monthlyBookingsCollection->sum(function ($item) {
return (int) ($item['total'] ?? 0);
});

$bestMonthRow = $monthlyBookingsCollection
->sortByDesc(function ($item) {
return (int) ($item['total'] ?? 0);
})
->first();

$bestMonth = isset($bestMonthRow['month'])
? $formatMonthName($bestMonthRow['month'])
: '—';

$bestMonthTotal = (int) ($bestMonthRow['total'] ?? 0);

$monthlyAverage = $monthlyBookingsCollection->count() > 0
? round($yearlyBookingsTotal / $monthlyBookingsCollection->count(), 1)
: 0;

$monthsTracked = $monthlyBookingsCollection->count();
@endphp

<div class="dashboard-premium-executive">

    {{-- ========================================
         Dashboard header
    ========================================= --}}
    <header class="dashboard-premium-executive__header">
        <div class="dashboard-premium-executive__heading">
            <span class="dashboard-premium-executive__eyebrow">
                Administración general
            </span>

            <h1 class="admin-page-title">
                Panel Administrativo
            </h1>

            <p class="admin-page-subtitle dashboard-premium-executive__subtitle">
                Visualiza el rendimiento del sistema, controla el catálogo y analiza el comportamiento de las reservas en un solo lugar.
            </p>
        </div>
    </header>

    {{-- ========================================
         Executive KPI row
         Card 1 and 4 keep a related neutral style
         Only middle cards receive the green accent line
    ========================================= --}}
    <section class="dashboard-executive-kpi-grid">

        {{-- Hero KPI / Reservations --}}
        <article class="dashboard-executive-card dashboard-executive-card--hero">
            <div class="dashboard-executive-card__top">
                <div>
                    <span class="dashboard-executive-card__label">
                        Total de Reservas
                    </span>

                    <h2 class="dashboard-executive-card__value dashboard-executive-card__value--hero">
                        {{ $totalBookings ?? 0 }}
                    </h2>
                </div>

                <span class="dashboard-executive-card__icon dashboard-executive-card__icon--neutral">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10m-12 9h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </span>
            </div>

            <p class="dashboard-executive-card__description">
                Total de reservas realizadas para tours dentro de la plataforma.
            </p>

            <div class="dashboard-executive-card__meta">
                <span class="dashboard-executive-chip dashboard-executive-chip--neutral">
                    Flujo principal del negocio
                </span>
            </div>
        </article>

        {{-- Revenue USD --}}
        <article class="dashboard-executive-card dashboard-executive-card--accent">
            <div class="dashboard-executive-card__top">
                <div>
                    <span class="dashboard-executive-card__label">
                        Ingresos en USD
                    </span>

                    <h2 class="dashboard-executive-card__value dashboard-executive-card__value--success">
                        ${{ number_format($totalRevenueUsd ?? 0, 2) }}
                    </h2>
                </div>
            </div>

            <p class="dashboard-executive-card__description">
                Total acumulado en dólares generado por las reservas registradas.
            </p>

            <div class="dashboard-executive-card__meta">
                <span class="dashboard-executive-chip dashboard-executive-chip--success">
                    Moneda internacional
                </span>
            </div>
        </article>

        {{-- Revenue CRC --}}
        <article class="dashboard-executive-card dashboard-executive-card--accent">
            <div class="dashboard-executive-card__top">
                <div>
                    <span class="dashboard-executive-card__label">
                        Ingresos en CRC
                    </span>

                    <h2 class="dashboard-executive-card__value dashboard-executive-card__value--success">
                        ₡{{ number_format($totalRevenueCrc ?? 0, 0) }}
                    </h2>
                </div>
            </div>

            <p class="dashboard-executive-card__description">
                Total acumulado en colones costarricenses dentro del sistema.
            </p>

            <div class="dashboard-executive-card__meta">
                <span class="dashboard-executive-chip dashboard-executive-chip--success">
                    Moneda local
                </span>
            </div>
        </article>

        {{-- Exchange rate --}}
        <article class="dashboard-executive-card dashboard-executive-card--neutral">
            <div class="dashboard-executive-card__top">
                <div>
                    <span class="dashboard-executive-card__label">
                        Tipo de Cambio
                    </span>

                    <h2 class="dashboard-executive-card__value">
                        ₡{{ number_format($currentExchangeRate ?? 0, 2) }}
                    </h2>
                </div>
            </div>

            <p class="dashboard-executive-card__description">
                Valor actual utilizado para conversiones monetarias dentro de la plataforma.
            </p>

            <div class="dashboard-executive-card__meta">
                <span class="dashboard-executive-chip dashboard-executive-chip--neutral">
                    Referencia financiera
                </span>
            </div>
        </article>

    </section>

    {{-- ========================================
         Catalog management block
         Symmetrical cards with equal height
    ========================================= --}}
    <section class="dashboard-catalog-grid">

        {{-- Tours --}}
        <article class="dashboard-catalog-card">
            <div class="dashboard-catalog-card__top">
                <div>
                    <span class="dashboard-catalog-card__label">
                        Tours
                    </span>

                    <h3 class="dashboard-catalog-card__value">
                        {{ $totalTours ?? 0 }}
                    </h3>
                </div>

                <span class="dashboard-catalog-card__icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.553-.832L9 7m0 13l6-3m-6-10v13m6-3l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                    </svg>
                </span>
            </div>

            <p class="dashboard-catalog-card__description">
                Total de experiencias turísticas administradas dentro del catálogo.
            </p>

            <div class="dashboard-catalog-card__badges">
                <span class="dashboard-lite-badge dashboard-lite-badge--active">
                    Activos: {{ $activeTours ?? 0 }}
                </span>

                <span class="dashboard-lite-badge dashboard-lite-badge--inactive">
                    Inactivos: {{ $inactiveTours ?? 0 }}
                </span>
            </div>
        </article>

        {{-- Accommodations --}}
        <article class="dashboard-catalog-card">
            <div class="dashboard-catalog-card__top">
                <div>
                    <span class="dashboard-catalog-card__label">
                        Hospedajes
                    </span>

                    <h3 class="dashboard-catalog-card__value">
                        {{ $totalAccommodations ?? 0 }}
                    </h3>
                </div>

                <span class="dashboard-catalog-card__icon">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 20V10.5a1 1 0 01.553-.894l8-4a1 1 0 01.894 0l8 4A1 1 0 0121 10.5V20M7 20v-5a1 1 0 011-1h8a1 1 0 011 1v5M9 10h.01M15 10h.01" />
                    </svg>
                </span>
            </div>

            <p class="dashboard-catalog-card__description">
                Total de hospedajes disponibles y controlados desde el panel administrativo.
            </p>

            <div class="dashboard-catalog-card__badges">
                <span class="dashboard-lite-badge dashboard-lite-badge--active">
                    Activos: {{ $activeAccommodations ?? 0 }}
                </span>

                <span class="dashboard-lite-badge dashboard-lite-badge--inactive">
                    Inactivos: {{ $inactiveAccommodations ?? 0 }}
                </span>
            </div>
        </article>

    </section>

    {{-- ========================================
         Analytics block
         Stronger chart section with quick context
    ========================================= --}}
    <section class="dashboard-analytics-card">

        <div class="dashboard-analytics-card__header">
            <div>
                <span class="dashboard-analytics-card__label">
                    Rendimiento mensual
                </span>

                <h3 class="dashboard-analytics-card__title">
                    Reservas por Mes
                </h3>

                <p class="dashboard-analytics-card__subtitle">
                    Visualiza la tendencia mensual de reservas registradas durante el período analizado.
                </p>
            </div>
        </div>

        <div class="dashboard-analytics-card__summary">
            <article class="dashboard-analytics-mini-card">
                <span class="dashboard-analytics-mini-card__label">
                    Meses analizados
                </span>

                <strong class="dashboard-analytics-mini-card__value">
                    {{ $monthsTracked }}
                </strong>
            </article>

            <article class="dashboard-analytics-mini-card">
                <span class="dashboard-analytics-mini-card__label">
                    Mejor mes
                </span>

                <strong class="dashboard-analytics-mini-card__value">
                    {{ $bestMonth }}
                </strong>

                <small class="dashboard-analytics-mini-card__meta">
                    {{ $bestMonthTotal }} reservas
                </small>
            </article>

            <article class="dashboard-analytics-mini-card">
                <span class="dashboard-analytics-mini-card__label">
                    Promedio mensual
                </span>

                <strong class="dashboard-analytics-mini-card__value">
                    {{ $monthlyAverage }}
                </strong>
            </article>
        </div>

        <div class="dashboard-analytics-card__canvas">
            <canvas
                id="bookingChart"
                data-labels='@json($chartLabelsFull->values())'
                data-values='@json($monthlyBookingsCollection->pluck("total")->values())'>
            </canvas>
        </div>

    </section>

</div>

@endsection