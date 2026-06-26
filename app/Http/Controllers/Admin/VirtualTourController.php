<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VirtualTour;
use App\Services\ActivityLogService;
use App\Services\EmbedSanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Show form to edit virtual tour embed.
     */
    public function edit()
    {
        $tour = VirtualTour::first();
        return view('admin.virtual_tour.edit', compact('tour'));
    }

    /**
     * Update active virtual tour code.
     */
    public function update(Request $request)
    {
        $tour = VirtualTour::first();
        if (!$tour) {
            $tour = new VirtualTour();
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'embed_type' => 'required|in:pannellum,marzipano,iframe,custom_html',
            'embed_code' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $oldData = $tour->exists ? $tour->toArray() : [];

        // Try sanitization
        try {
            $sanitized = $this->sanitizer->sanitize($validated['embed_code']);
            $validated['sanitized_code'] = $sanitized;
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['embed_code' => $e->getMessage()])->withInput();
        }

        if ($tour->exists) {
            // Push old embed code to version history
            $tour->addVersionHistory($tour->embed_code, Auth::id());
            $validated['version_history'] = $tour->version_history;
        }

        $validated['updated_by'] = Auth::id();
        $tour->fill($validated);
        $tour->save();

        $this->logger->log(
            'update_virtual_tour',
            'virtual_tour',
            $tour->id,
            $oldData,
            $tour->toArray()
        );

        return redirect()->route('admin.virtual-tour.index')
            ->with('success', 'Virtual Tour berhasil diperbarui.');
    }

    /**
     * Preview sanitized HTML (AJAX POST).
     */
    public function preview(Request $request)
    {
        $request->validate([
            'embed_code' => 'required|string',
        ]);

        try {
            $sanitized = $this->sanitizer->sanitize($request->input('embed_code'));
            return response()->json([
                'success' => true,
                'sanitized_code' => $sanitized,
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Rollback to a specific version from history.
     */
    public function rollback($version)
    {
        $tour = VirtualTour::firstOrFail();
        $history = $tour->version_history ?? [];

        $targetIndex = null;
        foreach ($history as $index => $item) {
            if ($item['version'] == $version) {
                $targetIndex = $index;
                break;
            }
        }

        if ($targetIndex === null) {
            return redirect()->route('admin.virtual-tour.index')
                ->with('error', 'Versi riwayat tidak ditemukan.');
        }

        $targetVersion = $history[$targetIndex];
        $oldData = $tour->toArray();

        // Save current code to history before rolling back
        $tour->addVersionHistory($tour->embed_code, Auth::id());

        // Restore target
        $tour->embed_code = $targetVersion['embed_code'];
        $tour->sanitized_code = $this->sanitizer->sanitize($targetVersion['embed_code']);
        $tour->updated_by = Auth::id();
        $tour->save();

        $this->logger->log(
            'rollback_virtual_tour',
            'virtual_tour',
            $tour->id,
            $oldData,
            $tour->toArray()
        );

        return redirect()->route('admin.virtual-tour.index')
            ->with('success', "Virtual Tour berhasil dikembalikan ke versi #{$version}.");
    }
}
