<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Models\Collection;
use App\Models\VirtualTour;

class HomeController extends Controller
{
    /**
     * Display the public homepage.
     */
    public function index()
    {
        $featuredCollections = Collection::with(['category', 'artisan'])
            ->published()
            ->latest()
            ->take(6)
            ->get();

        $featuredArtisans = Artisan::where('is_featured', true)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        $activeTour = VirtualTour::where('is_active', true)->first();

        return view('public.home', compact('featuredCollections', 'featuredArtisans', 'activeTour'));
    }
}
