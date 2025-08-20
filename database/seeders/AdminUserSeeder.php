<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if doesn't exist
        User::firstOrCreate(
            ['email' => 'ssatechs1220@gmail.com'],
            [
                'name' => 'Admin User',
                'email' => 'ssatechs1220@gmail.com',
                'password' => Hash::make('ssatechs1220'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: ssatechs1220@gmail.com');
        $this->command->info('Password: ssatechs1220');
    }
}
