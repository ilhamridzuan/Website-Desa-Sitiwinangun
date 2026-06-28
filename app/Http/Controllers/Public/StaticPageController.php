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
     * Display storytelling chapters view.
     */
    public function storytelling()
    {
        $bab2 = \App\Models\StorytellingChapter::firstOrCreate(['chapter_key' => 'bab_2']);
        $bab3 = \App\Models\StorytellingChapter::firstOrCreate(['chapter_key' => 'bab_3']);
        $bab4 = \App\Models\StorytellingChapter::firstOrCreate(['chapter_key' => 'bab_4']);
        $bab5 = \App\Models\StorytellingChapter::firstOrCreate(['chapter_key' => 'bab_5']);
        
        return view('public.storytelling', compact('bab2', 'bab3', 'bab4', 'bab5'));
    }
}
