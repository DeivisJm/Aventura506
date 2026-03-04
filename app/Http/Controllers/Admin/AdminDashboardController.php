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

        return view('admin.dashboard', compact(
            'totalBookings',
            'totalRevenueUsd',
            'totalRevenueCrc',
            'monthlyBookings'
        ));
    }
}
