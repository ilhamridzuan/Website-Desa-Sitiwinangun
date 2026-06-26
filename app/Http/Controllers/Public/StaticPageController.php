<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\BoardMember;
use App\Models\HistoryPage;
use App\Models\ProductionLocation;
use App\Models\StorytellingDoc;
use App\Models\VillageProfile;

class StaticPageController extends Controller
{
    /**
     * Display profile of the village.
     */
    public function about()
    {
        $profile = VillageProfile::first();
        return view('public.about', compact('profile'));
    }

    /**
     * Display histories.
     */
    public function history()
    {
        $desa = HistoryPage::findByKey('desa_history');
        $gerabah = HistoryPage::findByKey('gerabah_history');
        return view('public.history', compact('desa', 'gerabah'));
    }

    /**
     * Display village map of production locations.
     */
    public function locations()
    {
        $locations = ProductionLocation::with('artisan')
            ->where('is_open_visit', true)
            ->get();
            
        return view('public.jelajah', compact('locations'));
    }

    /**
     * Display board of organization structure.
     */
    public function board()
    {
        $members = BoardMember::orderBy('sort_order')->get();
        return view('public.board', compact('members'));
    }

    /**
     * Display list of digital storytelling PDF documents.
     */
    public function storytelling()
    {
        $docs = StorytellingDoc::orderBy('sort_order')->get();
        return view('public.storytelling', compact('docs'));
    }
}
