<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProductionPageTest extends TestCase
{
    public function test_production_page_renders_seven_stages_and_all_seventeen_photos(): void
    {
        $stages = config('production_stages');
        $this->assertIsArray($stages);
        $this->assertCount(7, $stages);

        $totalPhotos = 0;
        foreach ($stages as $stage) {
            $this->assertNotEmpty($stage['photos']);
            foreach ($stage['photos'] as $photo) {
                $totalPhotos++;
                $this->assertFileExists(public_path($photo['src']));
                $this->assertStringNotContainsString(' ', $photo['src']);
            }
        }
        $this->assertSame(17, $totalPhotos);

        $response = $this->get(route('public.production'));
        $response->assertOk();
        $response->assertDontSee('—');
        $response->assertDontSee('5 tahapan');

        foreach ($stages as $stage) {
            $response->assertSee($stage['title']);
            $response->assertSee('id="' . $stage['slug'] . '"', false);
            foreach ($stage['photos'] as $photo) {
                $response->assertSee($photo['src'], false);
            }
        }
    }

    public function test_production_page_shows_empty_state_when_config_is_empty(): void
    {
        config()->set('production_stages', []);

        $response = $this->get(route('public.production'));
        $response->assertOk();
        $response->assertSee('id="empty-stages"', false);
    }
}
