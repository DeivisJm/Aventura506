<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Booking;
use App\Models\ExchangeRate;
use App\Models\Tour;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // ===============================
        // Primary operational metrics
        // ===============================
        $totalBookings = Booking::count();
        $totalRevenueUsd = (float) Booking::sum('total_usd');
        $totalRevenueCrc = (float) Booking::sum('total_crc');

        // ===============================
        // Tours overview
        // ===============================
        $totalTours = Tour::count();
        $activeTours = Tour::where('active', 1)->count();
        $inactiveTours = Tour::where('active', 0)->count();

        // ===============================
        // Accommodations overview
        // ===============================
        $totalAccommodations = Accommodation::count();
        $activeAccommodations = Accommodation::where('is_active', 1)->count();
        $inactiveAccommodations = Accommodation::where('is_active', 0)->count();

        // ===============================
        // Users overview
        // ===============================
        $totalUsers = User::count();

        // ===============================
        // Current exchange rate
        // Adjust the key if your project uses another one
        // ===============================
        $currentExchangeRate = ExchangeRate::where('key', 'usd_to_crc')
            ->latest('updated_at')
            ->value('value') ?? 0;

        // ===============================
        // Monthly bookings chart
        // ===============================
        $monthlyBookings = Booking::select(
            DB::raw('MONTH(date) as month_number'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy(DB::raw('MONTH(date)'))
            ->orderBy(DB::raw('MONTH(date)'))
            ->get()
            ->map(function ($item) {
                $months = [
                    1 => 'Ene',
                    2 => 'Feb',
                    3 => 'Mar',
                    4 => 'Abr',
                    5 => 'May',
                    6 => 'Jun',
                    7 => 'Jul',
                    8 => 'Ago',
                    9 => 'Sep',
                    10 => 'Oct',
                    11 => 'Nov',
                    12 => 'Dic',
                ];

                return (object) [
                    'month' => $months[(int) $item->month_number] ?? (string) $item->month_number,
                    'total' => (int) $item->total,
                ];
            });

        return view('admin.dashboard.dashboard', [
            'totalBookings' => $totalBookings,
            'totalRevenueUsd' => $totalRevenueUsd,
            'totalRevenueCrc' => $totalRevenueCrc,

            'totalTours' => $totalTours,
            'activeTours' => $activeTours,
            'inactiveTours' => $inactiveTours,

            'totalAccommodations' => $totalAccommodations,
            'activeAccommodations' => $activeAccommodations,
            'inactiveAccommodations' => $inactiveAccommodations,

            'totalUsers' => $totalUsers,
            'currentExchangeRate' => $currentExchangeRate,

            'monthlyBookings' => $monthlyBookings,
        ]);
    }
}