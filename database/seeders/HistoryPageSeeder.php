<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HistoryPageSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('history_pages')->count() > 0) {
            return;
        }

        DB::table('history_pages')->insert([
            [
                'page_key'   => 'desa_history',
                'title'      => 'Sejarah Desa Sitiwinangun',
                'content'    => 'Desa Sitiwinangun berdiri sejak abad ke-15. Sitiwinangun dibentuk oleh Pangeran Panjunan dan dilanjutkan oleh Pangeran Jagabaya.',
                'updated_at' => now(),
            ],
            [
                'page_key'   => 'gerabah_history',
                'title'      => 'Sejarah Gerabah Sitiwinangun',
                'content'    => 'Kerajinan gerabah di Sitiwinangun memiliki karakter visual perpaduan budaya Sunda, Jawa, Islam, dan Tionghoa. Teknik pembuatan gerabah ini diwariskan secara lisan lintas generasi.',
                'updated_at' => now(),
            ],
        ]);
    }
}
