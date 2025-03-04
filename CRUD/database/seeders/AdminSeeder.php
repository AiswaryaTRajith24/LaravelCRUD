<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'phone_number' => '8735427898',
            'address' => '36 East 8th Street, New York, NY 10003, United States',
            'password' => Hash::make('Admin@1234567'),
            'role' => 'admin'
        ]);
    }
}
