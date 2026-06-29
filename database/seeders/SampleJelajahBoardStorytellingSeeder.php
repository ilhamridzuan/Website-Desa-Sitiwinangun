<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SampleJelajahBoardStorytellingSeeder extends Seeder
{
    public function run(): void
    {
        // Get Artisan IDs
        $artisanAde = DB::table('artisans')->where('name', 'Nuradi')->first();
        $artisanJunah = DB::table('artisans')->where('name', 'Rumsani')->first();
        $artisanMaman = DB::table('artisans')->where('name', 'Suyandi')->first();

        // Seed Production Locations (Jelajah)
        DB::table('production_locations')->insert([
            [
                'artisan_id' => $artisanAde ? $artisanAde->id : null,
                'name' => 'Bengkel Gerabah Nuradi',
                'address' => 'Blok Pejaten, RT 02/RW 03, Desa Sitiwinangun',
                'latitude' => -6.700500,
                'longitude' => 108.456800,
                'phone' => '085213635533',
                'main_products' => 'Kendi Hias, Gentong Wudhu, Guci Besar',
                'visit_capacity' => '30 Orang',
                'edu_activities' => 'Edukasi teknik putar miring, pembakaran tradisional, dan mewarnai gerabah.',
                'is_open_visit' => true,
                'photo_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'artisan_id' => $artisanJunah ? $artisanJunah->id : null,
                'name' => 'Bengkel Coet Sani (Rumsani)',
                'address' => 'Blok Pos, RT 04/RW 01, Desa Sitiwinangun',
                'latitude' => -6.701000,
                'longitude' => 108.455800,
                'phone' => '083840751249',
                'main_products' => 'Cobek, Wajan Tanah, Celengan Karakter',
                'visit_capacity' => '15 Orang',
                'edu_activities' => 'Belajar mencetak celengan hias dan teknik cetak press cobek tanah liat.',
                'is_open_visit' => true,
                'photo_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'artisan_id' => $artisanMaman ? $artisanMaman->id : null,
                'name' => 'Studio IyandiPoetery (Suyandi)',
                'address' => 'Blok Kebon Kelapa, Desa Sitiwinangun',
                'latitude' => -6.700000,
                'longitude' => 108.457200,
                'phone' => '083878865925',
                'main_products' => 'Vas Bunga Minimalis, Pot Estetik Modern',
                'visit_capacity' => '10 Orang',
                'edu_activities' => 'Pelatihan teknik putar cepat (wheel-throwing) modern dan teknik carving vas.',
                'is_open_visit' => true,
                'photo_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed Board Members (Pengurus)
        DB::table('board_members')->insert([
            [
                'name' => 'H. Sunaryo',
                'position' => 'Ketua Pengurus & Pelindung Adat',
                'photo_url' => null,
                'phone' => '081122334455',
                'email' => 'sunaryo@sitiwinangun.id',
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ahmad Fauzi',
                'position' => 'Sekretaris & Kordinator Pemasaran',
                'photo_url' => null,
                'phone' => '085566778899',
                'email' => 'fauzi@sitiwinangun.id',
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Aminah',
                'position' => 'Bendahara & Humas Kemasyarakatan',
                'photo_url' => null,
                'phone' => '089900112233',
                'email' => 'aminah@sitiwinangun.id',
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Seed Storytelling Docs (PDF)
        DB::table('storytelling_docs')->insert([
            [
                'title' => 'Panduan Teknik Putar Miring Sitiwinangun',
                'description' => 'Buku saku digital yang mengupas tuntas teknik putar tradisional miring khas pengrajin gerabah Sitiwinangun.',
                'pdf_url' => 'storytelling/panduan_putar_miring.pdf',
                'sort_order' => 1,
                'created_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Filosofi Motif Naga & Kaligrafi Gerabah',
                'description' => 'Makalah dokumentasi akulturasi budaya Islam-Tionghoa pada ukiran gerabah Cirebonan.',
                'pdf_url' => 'storytelling/filosofi_motif_gerabah.pdf',
                'sort_order' => 2,
                'created_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
