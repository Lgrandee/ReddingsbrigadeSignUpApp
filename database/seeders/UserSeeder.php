<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create a specific, static admin user
        User::create([
            'name' => 'Planner',
            'email' => 'planner@example.com',
            'password' => Hash::make('password123'),
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password123'),
        ]);

        // 2. Create 10 random/fake users using the UserFactory
        User::factory()->count(10)->create();
    }
}