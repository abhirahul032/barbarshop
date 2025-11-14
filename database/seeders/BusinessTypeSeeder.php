<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BusinessType;

class BusinessTypeSeeder extends Seeder
{
    public function run()
    {
        $businessTypes = [
            ['name' => 'Salon', 'description' => 'Hair and beauty salon services'],
            ['name' => 'Barber', 'description' => 'Traditional barber services'],
            ['name' => 'Nails', 'description' => 'Nail care and manicure services'],
            ['name' => 'Spa & sauna', 'description' => 'Spa and sauna relaxation services'],
            ['name' => 'Medspa', 'description' => 'Medical spa services'],
            ['name' => 'Massage', 'description' => 'Therapeutic massage services'],
            ['name' => 'Fitness & recovery', 'description' => 'Fitness and recovery services'],
            ['name' => 'Physical therapy', 'description' => 'Physical therapy and rehabilitation'],
            ['name' => 'Health practices', 'description' => 'General health practices'],
            ['name' => 'Tattooing & piercing', 'description' => 'Tattoo and body piercing services'],
            ['name' => 'Pet grooming', 'description' => 'Pet grooming and care services'],
            ['name' => 'Tanning studio', 'description' => 'Tanning and skin care services'],
        ];

        foreach ($businessTypes as $type) {
            BusinessType::create($type);
        }
    }
}