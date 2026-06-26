<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StorytellingDoc;
use App\Services\ActivityLogService;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StorytellingDocController extends Controller
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
        $query = StorytellingDoc::query();

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where('title', 'like', "%{$search}%");
        }

        $docs = $query->orderBy('sort_order')->paginate(20)->withQueryString();

        return view('admin.storytelling.index', compact('docs'));
    }

    public function create()
    {
        return view('admin.storytelling.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdf' => 'required|file|mimes:pdf|max:10240',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('pdf')) {
            $validated['pdf_url'] = $this->uploader->upload($request->file('pdf'), 'storytelling');
        }

        $validated['created_by'] = Auth::id();

        $doc = StorytellingDoc::create($validated);

        $this->logger->log('create_storytelling_doc', 'storytelling_doc', $doc->id, null, $doc->toArray());

        return redirect()->route('admin.storytelling.index')
            ->with('success', 'Dokumen PDF Storytelling berhasil diunggah.');
    }

    public function edit(StorytellingDoc $storytelling)
    {
        return view('admin.storytelling.edit', ['doc' => $storytelling]);
    }

    public function update(Request $request, StorytellingDoc $storytelling)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
            'sort_order' => 'integer',
        ]);

        $oldData = $storytelling->toArray();

        if ($request->hasFile('pdf')) {
            $this->uploader->delete($storytelling->pdf_url);
            $validated['pdf_url'] = $this->uploader->upload($request->file('pdf'), 'storytelling');
        }

        $storytelling->update($validated);

        $this->logger->log('update_storytelling_doc', 'storytelling_doc', $storytelling->id, $oldData, $storytelling->toArray());

        return redirect()->route('admin.storytelling.index')
            ->with('success', 'Dokumen PDF Storytelling berhasil diperbarui.');
    }

    public function destroy(StorytellingDoc $storytelling)
    {
        $oldData = $storytelling->toArray();

        if ($storytelling->pdf_url) {
            $this->uploader->delete($storytelling->pdf_url);
        }

        $storytelling->delete();

        $this->logger->log('delete_storytelling_doc', 'storytelling_doc', $storytelling->id, $oldData, null);

        return redirect()->route('admin.storytelling.index')
            ->with('success', 'Dokumen PDF Storytelling berhasil dihapus.');
    }
}
