<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Tawagin ang UserSeeder
        $this->call(UserSeeder::class);
    }
}
