<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\VirtualTour;

class VirtualTourController extends Controller
{
    /**
     * Display the virtual tour viewer.
     */
    public function index()
    {
        $tour = VirtualTour::where('is_active', true)->first();
        $tourConfig = null;

        if ($tour && $tour->embed_type === 'pannellum') {
            $decoded = json_decode($tour->embed_code ?? '', true);
            $tourConfig = json_last_error() === JSON_ERROR_NONE ? $decoded : null;
        }

        return view('public.virtual_tour', compact('tour', 'tourConfig'));
    }
}
