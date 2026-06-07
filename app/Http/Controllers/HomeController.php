<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Listing;

class HomeController extends Controller
{
    public function index()
    {
        $featuredListings = Listing::active()
            ->with(['user', 'images', 'category'])
            ->latest()
            ->take(8)
            ->get();

        $categories = Category::parents()
            ->withListingsCount()
            ->orderBy('sort_order')
            ->get();

        $totalListings = Listing::active()->count();

        return view('home', compact('featuredListings', 'categories', 'totalListings'));
    }
}
