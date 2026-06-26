<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Models\ProductionLocation;
use App\Services\ActivityLogService;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class ProductionLocationController extends Controller
{
    protected ActivityLogService $logger;
    protected ImageUploadService $uploader;

    public function __construct(ActivityLogService $logger, ImageUploadService $uploader)
    {
        $this->logger = $logger;
        $this->uploader = $uploader;
    }

    public function index(Request $request)
    {
        $query = ProductionLocation::with('artisan');

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
        }

        $locations = $query->latest()->paginate(20)->withQueryString();

        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        $artisans = Artisan::orderBy('name')->get();
        return view('admin.locations.create', compact('artisans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'artisan_id' => 'nullable|exists:artisans,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'main_products' => 'nullable|string',
            'visit_capacity' => 'nullable|string|max:100',
            'edu_activities' => 'nullable|string',
            'is_open_visit' => 'boolean',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['is_open_visit'] = $request->boolean('is_open_visit');

        if ($request->hasFile('photo')) {
            $validated['photo_url'] = $this->uploader->upload($request->file('photo'), 'locations');
        }

        $location = ProductionLocation::create($validated);

        $this->logger->log('create_production_location', 'production_location', $location->id, null, $location->toArray());

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi rumah produksi berhasil ditambahkan.');
    }

    public function edit(ProductionLocation $location)
    {
        $artisans = Artisan::orderBy('name')->get();
        return view('admin.locations.edit', compact('location', 'artisans'));
    }

    public function update(Request $request, ProductionLocation $location)
    {
        $validated = $request->validate([
            'artisan_id' => 'nullable|exists:artisans,id',
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'phone' => 'nullable|string|max:20',
            'main_products' => 'nullable|string',
            'visit_capacity' => 'nullable|string|max:100',
            'edu_activities' => 'nullable|string',
            'is_open_visit' => 'boolean',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $validated['is_open_visit'] = $request->boolean('is_open_visit');

        $oldData = $location->toArray();

        if ($request->hasFile('photo')) {
            $this->uploader->delete($location->photo_url);
            $validated['photo_url'] = $this->uploader->upload($request->file('photo'), 'locations');
        }

        $location->update($validated);

        $this->logger->log('update_production_location', 'production_location', $location->id, $oldData, $location->toArray());

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi rumah produksi berhasil diperbarui.');
    }

    public function destroy(ProductionLocation $location)
    {
        $oldData = $location->toArray();

        if ($location->photo_url) {
            $this->uploader->delete($location->photo_url);
        }

        $location->delete();

        $this->logger->log('delete_production_location', 'production_location', $location->id, $oldData, null);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Lokasi rumah produksi berhasil dihapus.');
    }
}
