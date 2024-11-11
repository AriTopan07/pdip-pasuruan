<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            [
                'name' => 'Super Admin',
                'description' => 'Hak Akses untuk Super Admin',
            ],
            [
                'name' => 'Kecamatan',
                'description' => 'Hak Akses Kecamatan',
            ],
            [
                'name' => 'Desa',
                'description' => 'Hak Akses Desa',
            ],
            [
                'name' => 'TPS',
                'description' => 'Hak Akses TPS',
            ],
        ]);
    }
}
