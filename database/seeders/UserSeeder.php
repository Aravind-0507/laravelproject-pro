<?php

namespace Database\Seeders; // Ensure the namespace is correct

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Aravind',
            'email' => 'aravind@gmail.com',
            'joining_date' => now(),
            'phone' => 1234567890,
            'is_active' => true,
            'role' => 1, 
            'password' => Hash::make('password123'), 
        ]);
    }
}