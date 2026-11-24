<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders_six_landscape_hero_images_and_clean_copy(): void
    {
        $expectedFiles = [
            'heroimg/bg-1-marini-getak.jpg',
            'heroimg/bg-2-kadmiya-ikan.jpg',
            'heroimg/bg-3-jaji-penari.jpg',
            'heroimg/bg-4-marini-guci.jpg',
            'heroimg/bg-5-kadmiya-rak.jpg',
            'heroimg/bg-6-rumsani-mangkuk.jpg',
        ];

        foreach ($expectedFiles as $file) {
            $this->assertFileExists(public_path($file));
        }

        for ($i = 1; $i <= 8; $i++) {
            $this->assertFileDoesNotExist(public_path("heroimg/{$i}.png"));
        }

        $response = $this->get(route('home'));
        $response->assertOk();
        $response->assertDontSee('—');
        $response->assertDontSee('5 tahap produksi');
        $response->assertSee('7 tahap produksi');
        $response->assertSee('fetchpriority="high"', false);
        $response->assertSee('id="hero-slideshow-toggle"', false);

        foreach ($expectedFiles as $file) {
            $response->assertSee($file, false);
        }
    }
}
