<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Models\Category;
use App\Models\Collection;
use App\Services\ActivityLogService;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    protected ActivityLogService $logger;
    protected ImageUploadService $uploader;

    public function __construct(ActivityLogService $logger, ImageUploadService $uploader)
    {
        $this->logger = $logger;
        $this->uploader = $uploader;
    }

    /**
     * Display a listing of collections.
     */
    public function index(Request $request)
    {
        $query = Collection::with(['category', 'artisan']);

        // Search by name or artisan name
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('artisan', function ($artisanQuery) use ($search) {
                      $artisanQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $collections = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::all();

        return view('admin.collections.index', compact('collections', 'categories'));
    }

    /**
     * Show form to create new collection.
     */
    public function create()
    {
        $categories = Category::orderBy('sort_order')->get();
        $artisans = Artisan::orderBy('name')->get();
        return view('admin.collections.create', compact('categories', 'artisans'));
    }

    /**
     * Store a newly created collection.
     */
    public function store(Request $request)
    {
        $currentYear = date('Y');

        $rules = [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'artisan_id' => 'nullable|exists:artisans,id',
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'required|string|max:1000',
            'history_origin' => 'required|string',
            'philosophy' => 'nullable|string',
            'technique' => 'required|string',
            'materials' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'year' => "nullable|integer|between:1800,{$currentYear}",
            'type' => 'required|in:koleksi,pola',
            'status' => 'required|in:draft,published',
        ];

        $validated = $request->validate($rules);

        // Upload photo
        if ($request->hasFile('photo')) {
            $validated['photo_url'] = $this->uploader->upload($request->file('photo'), 'collections');
        }

        $validated['slug'] = Str::slug($validated['name']);
        $validated['created_by'] = Auth::id();

        // Check if slug is unique (and append counter if not)
        $slug = $validated['slug'];
        $count = 1;
        while (Collection::where('slug', $slug)->exists()) {
            $slug = $validated['slug'] . '-' . $count;
            $count++;
        }
        $validated['slug'] = $slug;

        $collection = Collection::create($validated);

        $this->logger->log(
            'create_collection',
            'collection',
            $collection->id,
            null,
            $collection->only(array_keys($validated))
        );

        return redirect()->route('admin.collections.index')
            ->with('success', 'Koleksi berhasil ditambahkan.');
    }

    /**
     * Show form to edit collection.
     */
    public function edit(Collection $collection)
    {
        $categories = Category::orderBy('sort_order')->get();
        $artisans = Artisan::orderBy('name')->get();
        return view('admin.collections.edit', compact('collection', 'categories', 'artisans'));
    }

    /**
     * Update the specified collection.
     */
    public function update(Request $request, Collection $collection)
    {
        $currentYear = date('Y');

        $rules = [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'artisan_id' => 'nullable|exists:artisans,id',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'description' => 'required|string|max:1000',
            'history_origin' => 'required|string',
            'philosophy' => 'nullable|string',
            'technique' => 'required|string',
            'materials' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'year' => "nullable|integer|between:1800,{$currentYear}",
            'type' => 'required|in:koleksi,pola',
            'status' => 'required|in:draft,published',
        ];

        $validated = $request->validate($rules);

        $oldData = $collection->toArray();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            $this->uploader->delete($collection->photo_url);
            $validated['photo_url'] = $this->uploader->upload($request->file('photo'), 'collections');
        }

        // Regenerate slug if name changed
        if ($collection->name !== $validated['name']) {
            $slug = Str::slug($validated['name']);
            $count = 1;
            while (Collection::where('slug', $slug)->where('id', '!=', $collection->id)->exists()) {
                $slug = Str::slug($validated['name']) . '-' . $count;
                $count++;
            }
            $validated['slug'] = $slug;
        }

        $collection->update($validated);

        $this->logger->log(
            'update_collection',
            'collection',
            $collection->id,
            $oldData,
            $collection->toArray()
        );

        return redirect()->route('admin.collections.index')
            ->with('success', 'Koleksi berhasil diperbarui.');
    }

    /**
     * Remove the specified collection (soft delete).
     */
    public function destroy(Collection $collection)
    {
        $oldData = $collection->toArray();
        $collection->delete();

        $this->logger->log(
            'delete_collection',
            'collection',
            $collection->id,
            $oldData,
            null
        );

        return redirect()->route('admin.collections.index')
            ->with('success', 'Koleksi berhasil dihapus.');
    }
}
