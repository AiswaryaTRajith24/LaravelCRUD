<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'User',
            'email' => 'User@gmail.com',
            'phone_number' => '7894561235',
            'address' => '20 Cooper Square, New York, NY 10003, USA',
            'password' => Hash::make('User@1234567'),
            'role' => 'user'
        ]);

        User::create([
            'name' => 'Aiswarya',
            'email' => 'aiswarya@gmail.com',
            'phone_number' => '8974236579',
            'address' => '371 7th Ave, New York, NY 10001',
            'password' => Hash::make('Aiswarya@1234567'),
            'role' => 'user'
        ]);

        User::create([
            'name' => 'Alex',
            'email' => 'alex@gmail.com',
            'phone_number' => '9457621586',
            'address' => '50 Washington Square S, New York, NY 10012, USA',
            'password' => Hash::make('Alex@1234567'),
            'role' => 'user'
        ]);

        User::create([
            'name' => 'Mike',
            'email' => 'mike@gmail.com',
            'phone_number' => '8475398564',
            'address' => '610 E 20th St, New York, NY 10009, USA',
            'password' => Hash::make('Mike@1234567'),
            'role' => 'user'
        ]);

        User::create([
            'name' => 'Mark',
            'email' => 'mark@gmail.com',
            'phone_number' => '9914786258',
            'address' => '40 Washington Square S, New York, NY 10012, USA',
            'password' => Hash::make('Mark@1234567'),
            'role' => 'user'
        ]);

    }
}
