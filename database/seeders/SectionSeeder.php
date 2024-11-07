<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Settings',
                'order' => 1,
                'icons' => 'file-earmark-bar-graph',
                'status' => 'active',
            ]);

        DB::table('menu_sections')
            ->insert([
                'name_section' => 'Tambah Data',
                'order' => 1,
                'icons' => 'file-earmark-bar-graph',
                'status' => 'active',
            ]);
    }
}
