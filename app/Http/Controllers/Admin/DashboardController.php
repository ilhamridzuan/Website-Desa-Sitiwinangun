<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Models\Collection;
class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_collections' => Collection::count(),
            'published_collections' => Collection::published()->count(),
            'draft_collections' => Collection::draft()->count(),
            'total_artisans' => Artisan::count(),
        ];

        $recentCollections = Collection::with(['category', 'artisan'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentCollections'));
    }
}
