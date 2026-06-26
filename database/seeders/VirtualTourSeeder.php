<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VirtualTourSeeder extends Seeder
{
    public function run(): void
    {
        /**
         * Virtual Tour menggunakan output Marzipano Tool yang sudah di-host
         * di public/marzipano/sitiwinangun/index.html
         *
         * Alur navigasi (berdasarkan data.js dari Marzipano Tool):
         * 0. Kampung Gerabah (Start)
         * 1. Jalan ke Pengrajin 1 dan 2 (Lurus)
         * 2. Jalan ke Pengrajin 1 dan 2 (Kanan)
         * 3. Jalan ke Pengrajin 1 dan 2 (Lurus → Kanan)
         * 4. Simpang Pengrajin 1 dan 2
         * 5. Tempat Pembakaran Pengrajin 1
         * 6. Tempat Pengrajin 1                  [info: Gerabah Pak Sariman]
         * 7. Tempat Pengrajin 2                  [info: Arkima Pottery]
         * 8. Jalan ke Pengrajin 3
         * 9. Jalan ke Pengrajin 3 (Kiri)
         * 10. Jalan ke Pengrajin 3 (Lurus)
         * 11. Jalan ke Pengrajin 3 (Lurus → Kanan)
         * 12. Persimpangan ke Pengrajin 3 (Lurus)
         * 13. Persimpangan ke Pengrajin 3
         * 14. Warung ke arah Pengrajin 3
         * 15. Persimpangan ke Pengrajin 3 (Kiri)
         * 16. Jalan keluar ke jalan raya
         * 17. Jalan ke arah jalan raya (Kanan)
         * 18. Jalan ke Pengrajin 3
         * 19. Halaman Pengrajin 3                [info: Apik Craft]
         * 20. Tempat Pembakaran Pengrajin 3      [info: Tungku pembakaran]
         * 21. Tempat Pembuatan Kerajinan Pengrajin 3
         * 22. Gapura Masjid Keramat
         * 23. Simpang Pengrajin 4 dan Masjid Keramat
         * 24. Halaman Pengrajin 4                [info: Galeri Kadmiya Craft]
         * 25. Tempat Pengrajin 4
         * 26. Jalan ke Masjid Keramat
         * 27. Jalan di samping Masjid Keramat
         * 28. Halaman Masjid Keramat             [info: Masjid Keramat]
         * 29. Tampak dalam Masjid Keramat
         * 30. Tampak dalam Masjid Keramat (Kuno)
         */

        $iframeCode = '<iframe src="/marzipano/sitiwinangun/index.html" width="100%" height="700" frameborder="0" allowfullscreen allow="fullscreen" title="Virtual Tour 360° Desa Sitiwinangun" style="border:0;display:block;"></iframe>';

        DB::table('virtual_tour')->updateOrInsert(
            ['id' => 1],
            [
                'title'          => 'Jelajah Virtual 360° Desa Sitiwinangun',
                'description'    => 'Telusuri 31 titik panorama interaktif — dari pintu masuk kampung gerabah, rumah produksi pengrajin 1 hingga 4, Gapura & Masjid Keramat Sitiwinangun.',
                'embed_type'     => 'marzipano',
                'embed_code'     => $iframeCode,
                'sanitized_code' => $iframeCode,
                'is_active'      => true,
                'version_history'=> json_encode([]),
                'updated_by'     => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]
        );

        $this->command->info('VirtualTour seeded: Marzipano output with 31 scenes at /marzipano/sitiwinangun/');
    }
}
