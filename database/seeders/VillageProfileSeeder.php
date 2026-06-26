<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillageProfileSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('village_profile')->updateOrInsert(
            ['id' => 1],
            [
                'name'           => 'Desa Sitiwinangun',
                'description'    => 'Desa Sitiwinangun merupakan sentra kerajinan gerabah dan Batik Pesisir dengan sejarah panjang sejak abad ke-15. Nama desa berasal dari kata siti (tanah) dan winangun (dibangun/dibentuk).',
                'address'        => 'Desa Sitiwinangun, Kecamatan Lemahwungkuk, Kota Cirebon, Jawa Barat',
                'latitude'       => -6.718889,
                'longitude'      => 108.552222,
                'gallery_photos' => null,
                'updated_at'     => now(),
            ]
        );
    }
}
