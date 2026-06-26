<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use App\Services\ActivityLogService;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class BoardMemberController extends Controller
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
        $query = BoardMember::query();

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
        }

        $members = $query->orderBy('sort_order')->paginate(20)->withQueryString();

        return view('admin.board_members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.board_members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'sort_order' => 'integer',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo_url'] = $this->uploader->upload($request->file('photo'), 'board');
        }

        $member = BoardMember::create($validated);

        $this->logger->log('create_board_member', 'board_member', $member->id, null, $member->toArray());

        return redirect()->route('admin.board-members.index')
            ->with('success', 'Anggota pengurus berhasil ditambahkan.');
    }

    public function edit(BoardMember $boardMember)
    {
        return view('admin.board_members.edit', compact('boardMember'));
    }

    public function update(Request $request, BoardMember $boardMember)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'sort_order' => 'integer',
        ]);

        $oldData = $boardMember->toArray();

        if ($request->hasFile('photo')) {
            $this->uploader->delete($boardMember->photo_url);
            $validated['photo_url'] = $this->uploader->upload($request->file('photo'), 'board');
        }

        $boardMember->update($validated);

        $this->logger->log('update_board_member', 'board_member', $boardMember->id, $oldData, $boardMember->toArray());

        return redirect()->route('admin.board-members.index')
            ->with('success', 'Anggota pengurus berhasil diperbarui.');
    }

    public function destroy(BoardMember $boardMember)
    {
        $oldData = $boardMember->toArray();

        if ($boardMember->photo_url) {
            $this->uploader->delete($boardMember->photo_url);
        }

        $boardMember->delete();

        $this->logger->log('delete_board_member', 'board_member', $boardMember->id, $oldData, null);

        return redirect()->route('admin.board-members.index')
            ->with('success', 'Anggota pengurus berhasil dihapus.');
    }
}
