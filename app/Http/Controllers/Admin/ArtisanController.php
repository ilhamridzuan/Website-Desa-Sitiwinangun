<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Services\ActivityLogService;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class ArtisanController extends Controller
{
    protected ActivityLogService $logger;
    protected ImageUploadService $uploader;

    public function __construct(ActivityLogService $logger, ImageUploadService $uploader)
    {
        $this->logger = $logger;
        $this->uploader = $uploader;
    }

    /**
     * Display listing of artisans.
     */
    public function index(Request $request)
    {
        $query = Artisan::query();

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('specialty', 'like', "%{$search}%");
        }

        $artisans = $query->orderBy('sort_order')->paginate(20)->withQueryString();

        return view('admin.artisans.index', compact('artisans'));
    }

    /**
     * Show form to create new artisan.
     */
    public function create()
    {
        return view('admin.artisans.create');
    }

    /**
     * Store new artisan.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'years_active' => 'nullable|string|max:50',
            'specialty' => 'nullable|string|max:255',
            'story' => 'nullable|string',
            'quote' => 'nullable|string',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('photo')) {
            $validated['photo_url'] = $this->uploader->upload($request->file('photo'), 'artisans');
        }

        $artisan = Artisan::create($validated);

        $this->logger->log(
            'create_artisan',
            'artisan',
            $artisan->id,
            null,
            $artisan->only(array_keys($validated))
        );

        return redirect()->route('admin.artisans.index')
            ->with('success', 'Pengrajin berhasil ditambahkan.');
    }

    /**
     * Show form to edit artisan.
     */
    public function edit(Artisan $artisan)
    {
        return view('admin.artisans.edit', compact('artisan'));
    }

    /**
     * Update artisan details.
     */
    public function update(Request $request, Artisan $artisan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'years_active' => 'nullable|string|max:50',
            'specialty' => 'nullable|string|max:255',
            'story' => 'nullable|string',
            'quote' => 'nullable|string',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'is_featured' => 'boolean',
            'sort_order' => 'integer',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        $oldData = $artisan->toArray();

        if ($request->hasFile('photo')) {
            $this->uploader->delete($artisan->photo_url);
            $validated['photo_url'] = $this->uploader->upload($request->file('photo'), 'artisans');
        }

        $artisan->update($validated);

        $this->logger->log(
            'update_artisan',
            'artisan',
            $artisan->id,
            $oldData,
            $artisan->toArray()
        );

        return redirect()->route('admin.artisans.index')
            ->with('success', 'Pengrajin berhasil diperbarui.');
    }

    /**
     * Toggle artisan featured status.
     */
    public function toggleFeatured(Artisan $artisan)
    {
        $oldData = $artisan->toArray();
        $artisan->update([
            'is_featured' => !$artisan->is_featured,
        ]);

        $this->logger->log(
            'toggle_featured_artisan',
            'artisan',
            $artisan->id,
            $oldData,
            $artisan->toArray()
        );

        return response()->json([
            'success' => true,
            'is_featured' => $artisan->is_featured,
        ]);
    }

    /**
     * Delete artisan.
     */
    public function destroy(Artisan $artisan)
    {
        $oldData = $artisan->toArray();

        // Delete photo from storage
        if ($artisan->photo_url) {
            $this->uploader->delete($artisan->photo_url);
        }

        $artisan->delete();

        $this->logger->log(
            'delete_artisan',
            'artisan',
            $artisan->id,
            $oldData,
            null
        );

        return redirect()->route('admin.artisans.index')
            ->with('success', 'Pengrajin berhasil dihapus.');
    }
}
