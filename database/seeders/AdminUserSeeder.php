<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
                'name'            => 'Super Admin Sitiwinangun',
                'email'           => 'admin@sitiwinangun.id',
                'password'        => Hash::make('Sitiwinangun@2025'), // change after first login
                'role'            => 'superadmin',
                'is_active'       => true,
                'failed_attempts' => 0,
                'created_at'      => now(),
                'updated_at'      => now(),
        ]);
    }
}
