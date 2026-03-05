<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Tour;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalTours = Tour::count();

        $activeTours = Tour::where('active', 1)->count();

        $inactiveTours = Tour::where('active', 0)->count();

        // Total bookings
        $totalBookings = Booking::count();

        // Revenue USD
        $totalRevenueUsd = Booking::sum('total_usd');

        // Revenue CRC
        $totalRevenueCrc = Booking::sum('total_crc');

        // Monthly bookings aggregation
        $monthlyBookings = Booking::select(
            DB::raw('MONTH(date) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy(DB::raw('MONTH(date)'))
            ->orderBy(DB::raw('MONTH(date)'))
            ->get();

        return view('admin.dashboard', [

            'totalTours' => $totalTours,
            'activeTours' => $activeTours,
            'inactiveTours' => $inactiveTours,

            // lo que ya tenías
            'totalBookings' => $totalBookings ?? 0,
            'totalRevenueUsd' => $totalRevenueUsd ?? 0,
            'totalRevenueCrc' => $totalRevenueCrc ?? 0,
            'monthlyBookings' => $monthlyBookings ?? collect(),

        ]);
    }
}
