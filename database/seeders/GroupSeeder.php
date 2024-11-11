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
                'description' => 'Hak Akses untuk Super Admin',
            ],
            [
                'name' => 'Kecamatan',
<<<<<<< HEAD
                'description' => 'Hak Akses Kecamatan',
            ],
            [
                'name' => 'Desa',
                'description' => 'Hak Akses Desa',
            ],
            [
                'name' => 'TPS',
                'description' => 'Hak Akses TPS',
=======
                'description' => 'Hak Akses untuk Admin',
            ],
            [
                'name' => 'Desa',
                'description' => 'Hak Akses untuk user',
            ],
            [
                'name' => 'TPS',
                'description' => 'Hak Akses untuk user',
>>>>>>> 86b4992376126499bbb0a8dd9602aaaa859db086
            ],
        ]);
    }
}
