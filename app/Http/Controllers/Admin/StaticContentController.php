<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistoryPage;
use App\Models\VillageProfile;
use App\Services\ActivityLogService;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class StaticContentController extends Controller
{
    protected ActivityLogService $logger;
    protected ImageUploadService $uploader;

    public function __construct(ActivityLogService $logger, ImageUploadService $uploader)
    {
        $this->logger = $logger;
        $this->uploader = $uploader;
    }

    /**
     * Show edit form for static pages/profiles.
     */
    public function edit(string $module)
    {
        switch ($module) {

            case 'village-profile':
                $profile = VillageProfile::first();
                if (!$profile) {
                    $profile = VillageProfile::create([
                        'name' => 'Desa Sitiwinangun',
                        'gallery_photos' => [],
                    ]);
                }
                return view('admin.static.village_profile', compact('profile'));

            case 'history':
                $desa = HistoryPage::findByKey('desa_history');
                $gerabah = HistoryPage::findByKey('gerabah_history');
                return view('admin.static.history', compact('desa', 'gerabah'));

            default:
                abort(404);
        }
    }

    /**
     * Update static content module.
     */
    public function update(Request $request, string $module)
    {
        switch ($module) {

            case 'village-profile':
                $validated = $request->validate([
                    'name' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'address' => 'nullable|string|max:500',
                    'latitude' => 'nullable|numeric|between:-90,90',
                    'longitude' => 'nullable|numeric|between:-180,180',
                    'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
                    'delete_photos' => 'nullable|array',
                ]);

                $profile = VillageProfile::firstOrFail();
                $oldData = $profile->toArray();

                $photos = $profile->gallery_photos ?? [];

                // Delete selected photos
                if ($request->has('delete_photos')) {
                    foreach ($request->input('delete_photos') as $photoToDelete) {
                        $this->uploader->delete($photoToDelete);
                        $photos = array_values(array_filter($photos, fn($p) => $p !== $photoToDelete));
                    }
                }

                // Add new photos (max 6 total)
                if ($request->hasFile('photos')) {
                    foreach ($request->file('photos') as $file) {
                        if (count($photos) >= 6) {
                            break;
                        }
                        $photos[] = $this->uploader->upload($file, 'village');
                    }
                }

                $profile->update([
                    'name' => $validated['name'],
                    'description' => $validated['description'] ?? null,
                    'address' => $validated['address'] ?? null,
                    'latitude' => isset($validated['latitude']) ? (float) $validated['latitude'] : null,
                    'longitude' => isset($validated['longitude']) ? (float) $validated['longitude'] : null,
                    'gallery_photos' => $photos,
                ]);

                $this->logger->log('update_village_profile', 'village_profile', $profile->id, $oldData, $profile->toArray());
                return back()->with('success', 'Profil desa berhasil diperbarui.');

            case 'history':
                $validated = $request->validate([
                    'desa_title' => 'required|string|max:255',
                    'desa_content' => 'required|string',
                    'gerabah_title' => 'required|string|max:255',
                    'gerabah_content' => 'required|string',
                ]);

                $desa = HistoryPage::findByKey('desa_history');
                $oldDesa = $desa->toArray();
                $desa->update([
                    'title' => $validated['desa_title'],
                    'content' => $validated['desa_content'],
                ]);
                $this->logger->log('update_desa_history', 'history_page', $desa->id, $oldDesa, $desa->toArray());

                $gerabah = HistoryPage::findByKey('gerabah_history');
                $oldGerabah = $gerabah->toArray();
                $gerabah->update([
                    'title' => $validated['gerabah_title'],
                    'content' => $validated['gerabah_content'],
                ]);
                $this->logger->log('update_gerabah_history', 'history_page', $gerabah->id, $oldGerabah, $gerabah->toArray());

                return back()->with('success', 'Narasi sejarah berhasil diperbarui.');

            default:
                abort(404);
        }
    }
}
