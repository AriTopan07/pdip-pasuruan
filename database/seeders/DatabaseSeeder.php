<?php

namespace Database\Seeders;

use App\Models\UserGroup;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(GroupSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(SectionSeeder::class);
        $this->call(UserGroupSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(MasterActionSeeder::class);
        $this->call(ButtonSeeder::class);
        $this->call(ActionSeeder::class);
        // \App\Models\User::factory(10)->create();
    }
}
