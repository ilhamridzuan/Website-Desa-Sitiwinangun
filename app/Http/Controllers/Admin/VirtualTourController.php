<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VirtualTour;
use App\Services\ActivityLogService;
use App\Services\EmbedSanitizer;
class VirtualTourController extends Controller
{
    protected ActivityLogService $logger;
    protected EmbedSanitizer $sanitizer;

    public function __construct(ActivityLogService $logger, EmbedSanitizer $sanitizer)
    {
        $this->logger = $logger;
        $this->sanitizer = $sanitizer;
    }

    /**
     * Display current active virtual tour config.
     */
    public function index()
    {
        $tour = VirtualTour::first();
        return view('admin.virtual_tour.index', compact('tour'));
    }
}
