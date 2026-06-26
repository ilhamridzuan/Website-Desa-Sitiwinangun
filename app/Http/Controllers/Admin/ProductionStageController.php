<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductionStage;
use App\Services\ActivityLogService;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class ProductionStageController extends Controller
{
    protected ActivityLogService $logger;
    protected ImageUploadService $uploader;

    public function __construct(ActivityLogService $logger, ImageUploadService $uploader)
    {
        $this->logger = $logger;
        $this->uploader = $uploader;
    }

    /**
     * Display all 5 stages of production.
     */
    public function index()
    {
        $stages = ProductionStage::orderBy('stage_number')->get();
        return view('admin.production.index', compact('stages'));
    }

    /**
     * Show edit form for stage.
     */
    public function edit(ProductionStage $production)
    {
        return view('admin.production.edit', ['stage' => $production]);
    }

    /**
     * Update stage details.
     */
    public function update(Request $request, ProductionStage $production)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $oldData = $production->toArray();

        if ($request->hasFile('photo')) {
            $this->uploader->delete($production->photo_url);
            $validated['photo_url'] = $this->uploader->upload($request->file('photo'), 'stages');
        }

        $production->update($validated);

        $this->logger->log(
            'update_production_stage',
            'production_stage',
            $production->id,
            $oldData,
            $production->toArray()
        );

        return redirect()->route('admin.production.index')
            ->with('success', "Tahap {$production->stage_number} berhasil diperbarui.");
    }
}
