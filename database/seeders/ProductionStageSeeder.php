<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductionStageSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('production_stages')->count() > 0) {
            return;
        }

        $stages = [
            [
                'stage_number' => 1,
                'title'        => 'Memilih & Mengolah Tanah',
                'description'  => 'Tanah liat menjadi awal dari semua karya. Pengrajin mengenali tekstur, membersihkan, dan menyiapkan adonan agar siap dibentuk.',
                'photo_url'    => null,
                'updated_at'   => now(),
            ],
            [
                'stage_number' => 2,
                'title'        => 'Membentuk dengan Tangan',
                'description'  => 'Gerabah dibentuk melalui keterampilan tangan dan alat sederhana. Pengalaman pengrajin menentukan proporsi, kekuatan, dan karakter bentuk.',
                'photo_url'    => null,
                'updated_at'   => now(),
            ],
            [
                'stage_number' => 3,
                'title'        => 'Mengeringkan',
                'description'  => 'Karya yang sudah dibentuk harus dikeringkan dengan hati-hati. Tidak bisa diburu-buru karena menentukan kekuatan gerabah sebelum dibakar.',
                'photo_url'    => null,
                'updated_at'   => now(),
            ],
            [
                'stage_number' => 4,
                'title'        => 'Membakar',
                'description'  => 'Pembakaran mengubah tanah liat menjadi benda keras dan tahan pakai. Kesabaran dan ketepatan sangat dibutuhkan di tahap krusial ini.',
                'photo_url'    => null,
                'updated_at'   => now(),
            ],
            [
                'stage_number' => 5,
                'title'        => 'Finishing',
                'description'  => 'Setelah dibakar, gerabah dirapikan, diberi sentuhan akhir, dan siap digunakan sebagai peralatan, dekorasi, atau suvenir.',
                'photo_url'    => null,
                'updated_at'   => now(),
            ],
        ];

        DB::table('production_stages')->insert($stages);
    }
}
