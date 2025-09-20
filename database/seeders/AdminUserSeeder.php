<?php
// database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kursusperangkatdesa.com'],
            [
                'name' => 'Administrator',
                'email' => 'admin@kursusperangkatdesa.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
                'notes' => 'Default admin user created by seeder'
            ]
        );

        // Create some demo customers
        User::updateOrCreate(
            ['email' => 'customer1@example.com'],
            [
                'name' => 'Ahmad Rizki',
                'email' => 'customer1@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+6281234567890',
                'role' => 'customer',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'customer2@example.com'],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'customer2@example.com',
                'password' => Hash::make('password123'),
                'phone' => '+6281234567891',
                'role' => 'customer',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
