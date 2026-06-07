<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Report;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'     => User::where('role', 'user')->count(),
            'total_listings'  => Listing::count(),
            'active_listings' => Listing::active()->count(),
            'sold_listings'   => Listing::where('status', 'sold')->count(),
            'pending_reports' => Report::pending()->count(),
            'banned_users'    => User::where('is_banned', true)->count(),
        ];

        $latestListings = Listing::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $latestReports = Report::with(['user', 'listing'])
            ->pending()
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestListings', 'latestReports'));
    }
}
