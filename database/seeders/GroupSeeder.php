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
                'name' => 'Admin Kabupaten',
                'description' => 'Hak Akses untuk Kab',
            ],
            [
                'name' => 'Kecamatan',
                'description' => 'Hak Akses untuk kecamatan',
            ],
            [
                'name' => 'Desa',
                'description' => 'Hak Akses untuk desa',
            ],
            [
                'name' => 'TPS',
                'description' => 'Hak Akses untuk tps',
            ],
        ]);
    }
}
