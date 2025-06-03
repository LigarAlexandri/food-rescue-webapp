<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Warung Ibu Siti',
            'email' => 'vendor1@example.com',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'shop_name' => 'Warung Ibu Siti',
            'address' => 'Jl. Merdeka No. 10, Jember',
            'phone_number' => '081234567890',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Toko Roti Enak',
            'email' => 'vendor2@example.com',
            'password' => Hash::make('password'),
            'role' => 'vendor',
            'shop_name' => 'Toko Roti Enak',
            'address' => 'Jl. Pahlawan No. 5, Jember',
            'phone_number' => '081234567891',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'recipient1@example.com',
            'password' => Hash::make('password'),
            'role' => 'recipient',
            'address' => 'Jl. Kebonagung No. 1, Jember',
            'phone_number' => '085678901234',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Ani Lestari',
            'email' => 'recipient2@example.com',
            'password' => Hash::make('password'),
            'role' => 'recipient',
            'address' => 'Jl. Mastrip No. 20, Jember',
            'phone_number' => '085678901235',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin', // For potential admin panel later
            'email_verified_at' => now(),
        ]);
    }
}
