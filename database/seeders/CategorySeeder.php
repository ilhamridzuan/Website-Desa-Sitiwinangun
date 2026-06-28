<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('categories')->count() > 0) {
            return;
        }

        $categories = [
            [
                'name'        => 'Kendi & Wadah Air',
                'slug'        => 'kendi-wadah-air',
                'color_hex'   => '#7B5EA7',
                'description' => 'Simbol hubungan tanah, air, dan kehidupan rumah tangga',
                'sort_order'  => 1,
            ],
            [
                'name'        => 'Guci & Gentong',
                'slug'        => 'guci-gentong',
                'color_hex'   => '#4A7C59',
                'description' => 'Kokoh, tenang, dekat dengan tradisi rumah-rumah lama Cirebon',
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Peralatan Minum',
                'slug'        => 'peralatan-minum',
                'color_hex'   => '#C8860A',
                'description' => 'Menghubungkan tradisi dengan pengalaman sehari-hari yang personal',
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Vas & Pot',
                'slug'        => 'vas-pot',
                'color_hex'   => '#6B9E6B',
                'description' => 'Nuansa natural & earthy untuk hunian modern',
                'sort_order'  => 4,
            ],
            [
                'name'        => 'Souvenir & Celengan',
                'slug'        => 'souvenir-celengan',
                'color_hex'   => '#D4603A',
                'description' => 'Pintu masuk wisatawan muda untuk mengenal gerabah Sitiwinangun',
                'sort_order'  => 5,
            ],
            [
                'name'        => 'Peralatan Dapur',
                'slug'        => 'peralatan-dapur',
                'color_hex'   => '#8B6914',
                'description' => 'Fungsi harian yang mempertahankan tradisi masak Cirebon',
                'sort_order'  => 6,
            ],
            [
                'name'        => 'Lainnya',
                'slug'        => 'lainnya',
                'color_hex'   => '#6B7280',
                'description' => 'Untuk fleksibilitas koleksi baru di luar kategori utama',
                'sort_order'  => 7,
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
