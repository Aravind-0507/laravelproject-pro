<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Correct the case here

class UserTableSeeder extends Seeder // Change the class name to UserTableSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an Admin User
        user::create([ // Use User instead of user
            'name' => 'Aravind',
            'email' => 'aravind@gmail.com',
            'joining_date' => now(),
            'phone' => '1234567890',
            'is_active' => true,
            'role' => 1, // Admin role
            'password' => Hash::make('password123'), // Ensure the password is hashed
        ]);

        User::create([ // Use User instead of user
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'joining_date' => now(),
            'phone' => '0987654321',
            'is_active' => true,
            'role' => 2, // User role
            'password' => Hash::make('password'), // Ensure the password is hashed
        ]);
    }
}
