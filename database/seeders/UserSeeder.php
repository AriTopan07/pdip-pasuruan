<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => Hash::make('secret'),
                'status' => 'active'
            ],
            [
                'name' => 'PANDAAN',
                'username' => 'kecamatan',
                'password' => Hash::make('secret'),
                'status' => 'active'
            ],
            [
                'name' => 'GERBO',
                'username' => 'desa',
                'password' => Hash::make('secret'),
                'status' => 'active'
            ],
            [
                'name' => 'TPS',
                'username' => 'tps',
                'password' => Hash::make('secret'),
                'status' => 'active'
            ],
        ]);
    }
}
