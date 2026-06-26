<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\ProductionStage;

class ProductionController extends Controller
{
    /**
     * Display stages of production.
     */
    public function index()
    {
        $stages = ProductionStage::orderBy('stage_number')->get();
        return view('public.production', compact('stages'));
    }
}
