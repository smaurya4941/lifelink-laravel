<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::updateOrCreate(
            ['email' => 'admin@lifelink.com'],
            [
            'name' => 'Admin',
            'role' => 'admin',
            'is_donor' => false,
            'is_recipient' => false,
            'password' => Hash::make('123456'),
        ]);
    }
}
