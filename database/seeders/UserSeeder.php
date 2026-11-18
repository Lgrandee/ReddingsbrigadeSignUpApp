<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'diplomas' => ['postkommandant', 'kommandant'],
        ]);

        User::create([
            'name' => 'Planner',
            'email' => 'planner@example.com',
            'password' => Hash::make('password123'),
            'role' => 'planner',
            'diplomas' => ['postkommandant', 'kommandant'],
        ]);

        User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => Hash::make('password123'),
            'role' => 'gebruiker',
        ]);

        User::factory()
            ->count(10)
            ->create(['role' => 'gebruiker']);
    }
}