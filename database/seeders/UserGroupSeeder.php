<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_groups')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'group_id' => 1,
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'group_id' => 2,
            ],
            [
                'id' => 3,
                'user_id' => 3,
                'group_id' => 3,
            ],
            [
                'id' => 4,
                'user_id' => 4,
                'group_id' => 4,
            ]
        ]);
    }
}
