<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 

class UserTableSeeder extends Seeder 
{

    public function run(): void
    {
        user::create([ 
            'name' => 'Aravind',
            'email' => 'aravind@gmail.com',
            'joining_date' => now(),
            'phone' => '1234567890',
            'is_active' => true,
            'role' => 1, 
            'password' => Hash::make('password123'), 
        ]);

        User::create([ 
            'name' => 'Normal User',
            'email' => 'user@example.com',
            'joining_date' => now(),
            'phone' => '0987654321',
            'is_active' => true,
            'role' => 2, 
            'password' => Hash::make('password'), 
        ]);
    }
}
