<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Artisan;

class ArtisanController extends Controller
{
    /**
     * Display a listing of featured artisans.
     */
    public function index()
    {
        $artisans = Artisan::where('is_featured', true)
            ->orderBy('sort_order')
            ->get();

        return view('public.artisans.index', compact('artisans'));
    }

    /**
     * Display the specified artisan profiles and their works.
     */
    public function show(int $id)
    {
        $artisan = Artisan::with(['collections' => function ($q) {
            $q->published()->latest();
        }])->findOrFail($id);

        return view('public.artisans.show', compact('artisan'));
    }
}
