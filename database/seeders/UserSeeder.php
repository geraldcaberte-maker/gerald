<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'ID' => 1,
            'name' => 'gerald',
            'email' => 'gerald@example.com',
            'password' => bcrypt('secret123'),
        ]);
    }
}
