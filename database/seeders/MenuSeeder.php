<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 1,
                'name_menu' => 'User',
                'url' => '/users',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);
        
        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 2,
                'name_menu' => 'Group',
                'url' => '/group',
                'icons' => '',
                'order' => 1,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 2,
                'name_menu' => 'Create Section',
                'url' => '/create-section',
                'icons' => '',
                'order' => 2,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 2,
                'name_menu' => 'Aksi',
                'url' => '/action',
                'icons' => '',
                'order' => 3,
                'status' => 'active',
            ]);

        DB::table('menus')
            ->insert([
                'parent_id' => 0,
                'section_id' => 2,
                'name_menu' => 'Tombol',
                'url' => '/button',
                'icons' => '',
                'order' => 4,
                'status' => 'active',
            ]);
    }
}
