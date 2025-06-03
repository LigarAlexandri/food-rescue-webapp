<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FoodItem;
use App\Models\User;
use Carbon\Carbon;

class FoodItemSeeder extends Seeder
{
    public function run(): void
    {
        $vendor1 = User::where('email', 'vendor1@example.com')->first();
        $vendor2 = User::where('email', 'vendor2@example.com')->first();
        $recipient1 = User::where('email', 'recipient1@example.com')->first();

        if ($vendor1) {
            FoodItem::create([
                'vendor_id' => $vendor1->id,
                'name' => 'Nasi Goreng Spesial (Seeder)',
                'description' => 'Nasi goreng sisa dari penutupan, masih sangat layak.',
                'quantity' => '3 porsi',
                'pickup_location' => $vendor1->address,
                'pickup_start_time' => Carbon::now()->addHours(1),
                'pickup_end_time' => Carbon::now()->addHours(3),
                'status' => 'available',
            ]);
            FoodItem::create([
                'vendor_id' => $vendor1->id,
                'name' => 'Ayam Bakar (Seeder)',
                'description' => 'Ayam bakar bumbu rujak, sisa 2 potong.',
                'quantity' => '2 potong',
                'pickup_location' => $vendor1->address,
                'pickup_start_time' => Carbon::now()->addHours(2),
                'pickup_end_time' => Carbon::now()->addHours(4),
                'status' => 'available',
            ]);
        }

        if ($vendor2) {
            FoodItem::create([
                'vendor_id' => $vendor2->id,
                'name' => 'Roti Tawar Gandum (Seeder)',
                'description' => 'Roti tawar gandum utuh, H-1 kadaluarsa.',
                'quantity' => '5 bungkus',
                'pickup_location' => $vendor2->address,
                'pickup_start_time' => Carbon::now()->addMinutes(30),
                'pickup_end_time' => Carbon::now()->addHours(2),
                'status' => 'available',
            ]);

            if ($recipient1) {
                FoodItem::create([
                    'vendor_id' => $vendor2->id,
                    'name' => 'Donat Coklat (Claimed by Seeder)',
                    'description' => 'Sisa donat coklat display hari ini.',
                    'quantity' => '6 buah',
                    'pickup_location' => $vendor2->address,
                    'pickup_start_time' => Carbon::now()->subHours(1), // In the past to simulate active claim
                    'pickup_end_time' => Carbon::now()->addHours(1),
                    'status' => 'claimed',
                    'claimed_by_recipient_id' => $recipient1->id,
                ]);
            }

            FoodItem::create([
                'vendor_id' => $vendor2->id,
                'name' => 'Pastry (Expired by Seeder)',
                'description' => 'Pastry sisa kemarin.',
                'quantity' => '3 buah',
                'pickup_location' => $vendor2->address,
                'pickup_start_time' => Carbon::now()->subDays(1)->setTime(17, 0, 0),
                'pickup_end_time' => Carbon::now()->subDays(1)->setTime(18, 0, 0),
                'status' => 'expired',
            ]);
        }
    }
}
