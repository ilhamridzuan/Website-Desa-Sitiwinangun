<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Update village profile coordinates
        DB::table('village_profile')
            ->where('id', 1)
            ->update([
                'address' => 'Desa Sitiwinangun, Kecamatan Jamblang, Kabupaten Cirebon, Jawa Barat',
                'latitude' => -6.700682,
                'longitude' => 108.456178,
            ]);

        // Update production location coordinates
        DB::table('production_locations')
            ->where('name', 'Bengkel Gerabah Nuradi')
            ->update([
                'latitude' => -6.700500,
                'longitude' => 108.456800,
            ]);

        DB::table('production_locations')
            ->where('name', 'Bengkel Coet Sani (Rumsani)')
            ->update([
                'latitude' => -6.701000,
                'longitude' => 108.455800,
            ]);

        DB::table('production_locations')
            ->where('name', 'Studio IyandiPoetery (Suyandi)')
            ->update([
                'latitude' => -6.700000,
                'longitude' => 108.457200,
            ]);
    }

    public function down(): void
    {
        // Restore old Lemahwungkuk coordinates if rolled back
        DB::table('village_profile')
            ->where('id', 1)
            ->update([
                'address' => 'Desa Sitiwinangun, Kecamatan Lemahwungkuk, Kota Cirebon, Jawa Barat',
                'latitude' => -6.718889,
                'longitude' => 108.552222,
            ]);

        DB::table('production_locations')
            ->where('name', 'Bengkel Gerabah Nuradi')
            ->update([
                'latitude' => -6.719000,
                'longitude' => 108.552500,
            ]);

        DB::table('production_locations')
            ->where('name', 'Bengkel Coet Sani (Rumsani)')
            ->update([
                'latitude' => -6.718500,
                'longitude' => 108.551800,
            ]);

        DB::table('production_locations')
            ->where('name', 'Studio IyandiPoetery (Suyandi)')
            ->update([
                'latitude' => -6.719500,
                'longitude' => 108.553200,
            ]);
    }
};
