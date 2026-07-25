<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create the Principal / Administrator Account
        User::updateOrCreate(
            ['email' => 'admin@school.ph'],
            [
                'name' => 'Principal Admin',
                'password' => bcrypt('admin123'),
                'role' => 'admin',
            ]
        );

        // 2. Create the Regular Adviser / Teacher Account
        User::updateOrCreate(
            ['email' => 'teacher@school.ph'],
            [
                'name' => 'Adviser Teacher',
                'password' => bcrypt('teacher123'),
                'role' => 'teacher',
            ]
        );
    }
}
