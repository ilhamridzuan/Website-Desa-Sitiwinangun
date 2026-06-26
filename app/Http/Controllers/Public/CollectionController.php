<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    /**
     * Display the public gallery listing.
     */
    public function index(Request $request)
    {
        $type = $request->input('tab', 'koleksi');
        if (!in_array($type, ['koleksi', 'pola'])) {
            $type = 'koleksi';
        }

        $query = Collection::with(['category', 'artisan'])->published()->where('type', $type);

        // Search by name, materials, technique
        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('materials', 'like', "%{$search}%")
                  ->orWhere('technique', 'like', "%{$search}%")
                  ->orWhereHas('artisan', function ($artisanQuery) use ($search) {
                      $artisanQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category slug
        if ($request->filled('kategori')) {
            $categorySlug = $request->input('kategori');
            $query->whereHas('category', function ($categoryQuery) use ($categorySlug) {
                $categoryQuery->where('slug', $categorySlug);
            });
        }

        $collections = $query->latest()->paginate(20)->withQueryString();
        $categories = Category::orderBy('sort_order')->get();

        return view('public.collections.index', compact('collections', 'categories', 'type'));
    }

    /**
     * Display a specific published collection.
     */
    public function show(string $slug)
    {
        $collection = Collection::with(['category', 'artisan', 'creator'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Query related collections in same category (exclude current)
        $related = Collection::with(['category', 'artisan'])
            ->published()
            ->where('category_id', $collection->category_id)
            ->where('id', '!=', $collection->id)
            ->take(3)
            ->get();

        return view('public.collections.show', compact('collection', 'related'));
    }
}
