<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class ProductionController extends Controller
{
    /**
     * Display stages of production from curated configuration.
     */
    public function index()
    {
        $stages = config('production_stages', []);

        return view('public.production', compact('stages'));
    }
}
