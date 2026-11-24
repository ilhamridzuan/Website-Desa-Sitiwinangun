<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Artisan;
use App\Models\Collection;
use App\Models\VirtualTour;

class HomeController extends Controller
{
    /**
     * Display the public homepage.
     */
    public function index()
    {
        $heroSlides = [
            [
                'src' => 'heroimg/bg-1-marini-getak.jpg',
                'alt' => 'Guci gerabah terakota berukir di galeri Uma Getak Desa Sitiwinangun',
            ],
            [
                'src' => 'heroimg/bg-2-kadmiya-ikan.jpg',
                'alt' => 'Karya gerabah berbentuk ikan dan koleksi terakota di rak bengkel Kadmiya Craft',
            ],
            [
                'src' => 'heroimg/bg-3-jaji-penari.jpg',
                'alt' => 'Patung gerabah lukis penari topeng Cirebon karya pengrajin Desa Sitiwinangun',
            ],
            [
                'src' => 'heroimg/bg-4-marini-guci.jpg',
                'alt' => 'Deretan guci dan tempayan gerabah hias khas Sitiwinangun',
            ],
            [
                'src' => 'heroimg/bg-5-kadmiya-rak.jpg',
                'alt' => 'Rak koleksi hiasan atap memolo dan vas krawangan di bengkel gerabah',
            ],
            [
                'src' => 'heroimg/bg-6-rumsani-mangkuk.jpg',
                'alt' => 'Deretan mangkuk cucuk tanah liat kering siap bakar di bengkel Rumsani',
            ],
        ];

        $featuredCollections = Collection::with(['category', 'artisan'])
            ->published()
            ->latest()
            ->take(6)
            ->get();

        $featuredArtisans = Artisan::where('is_featured', true)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        $activeTour = VirtualTour::where('is_active', true)->first();

        return view('public.home', compact('heroSlides', 'featuredCollections', 'featuredArtisans', 'activeTour'));
    }
}
