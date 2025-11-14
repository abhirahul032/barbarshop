<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Store;
use App\Models\Employee;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all stores or create a default one if none exist
        $stores = Store::all();
        
        if ($stores->isEmpty()) {
            // Create a default store if none exists
            $store = Store::create([
                'name' => 'Main Store',
                'address' => '123 Main Street',
                'phone' => '+1234567890',
                'email' => 'store@example.com',
                'is_active' => true,
            ]);
            $stores = collect([$store]);
        }

        $services = [
            // Hair Cut & Styling Services
            [
                'name' => 'Classic Haircut',
                'description' => 'Professional haircut with styling and finish. Includes consultation, shampoo, and blow dry.',
                'price' => 35.00,
                'duration_minutes' => 45,
                'category' => 'hair',
                'is_active' => true,
            ],
            [
                'name' => 'Premium Haircut',
                'description' => 'Deluxe haircut experience with premium products, scalp massage, and detailed styling.',
                'price' => 50.00,
                'duration_minutes' => 60,
                'category' => 'hair',
                'is_active' => true,
            ],
            [
                'name' => 'Kids Haircut',
                'description' => 'Special haircut for children under 12 years old. Fun and comfortable experience.',
                'price' => 25.00,
                'duration_minutes' => 30,
                'category' => 'hair',
                'is_active' => true,
            ],
            [
                'name' => 'Hair Styling',
                'description' => 'Professional styling for special occasions. Includes blowout and finishing.',
                'price' => 40.00,
                'duration_minutes' => 45,
                'category' => 'hair',
                'is_active' => true,
            ],

            // Hair Coloring Services
            [
                'name' => 'Full Color',
                'description' => 'Complete hair coloring service with premium color products and conditioning treatment.',
                'price' => 80.00,
                'duration_minutes' => 120,
                'category' => 'coloring',
                'is_active' => true,
            ],
            [
                'name' => 'Root Touch Up',
                'description' => 'Color application to new growth only. Perfect for maintaining your color between full services.',
                'price' => 55.00,
                'duration_minutes' => 90,
                'category' => 'coloring',
                'is_active' => true,
            ],
            [
                'name' => 'Balayage Highlights',
                'description' => 'Hand-painted highlights for a natural, sun-kissed look. Includes toner and treatment.',
                'price' => 120.00,
                'duration_minutes' => 180,
                'category' => 'coloring',
                'is_active' => true,
            ],
            [
                'name' => 'Toner Service',
                'description' => 'Color toning to perfect your shade and eliminate brassiness.',
                'price' => 30.00,
                'duration_minutes' => 30,
                'category' => 'coloring',
                'is_active' => true,
            ],

            // Beard Services
            [
                'name' => 'Beard Trim',
                'description' => 'Precise beard trimming and shaping to maintain your desired style.',
                'price' => 20.00,
                'duration_minutes' => 30,
                'category' => 'beard',
                'is_active' => true,
            ],
            [
                'name' => 'Deluxe Beard Grooming',
                'description' => 'Complete beard service including trim, hot towel, oil, and balm application.',
                'price' => 35.00,
                'duration_minutes' => 45,
                'category' => 'beard',
                'is_active' => true,
            ],
            [
                'name' => 'Beard Color',
                'description' => 'Professional beard coloring to cover gray or change beard color.',
                'price' => 25.00,
                'duration_minutes' => 30,
                'category' => 'beard',
                'is_active' => true,
            ],

            // Spa & Facial Services
            [
                'name' => 'Classic Facial',
                'description' => 'Deep cleansing facial with steam, extraction, mask, and moisturizer.',
                'price' => 75.00,
                'duration_minutes' => 60,
                'category' => 'spa',
                'is_active' => true,
            ],
            [
                'name' => 'Anti-Aging Facial',
                'description' => 'Rejuvenating facial with collagen boost and firming treatments.',
                'price' => 95.00,
                'duration_minutes' => 75,
                'category' => 'spa',
                'is_active' => true,
            ],
            [
                'name' => 'Back Facial',
                'description' => 'Deep cleansing and treatment for back acne and congestion.',
                'price' => 85.00,
                'duration_minutes' => 60,
                'category' => 'spa',
                'is_active' => true,
            ],

            // Massage Services
            [
                'name' => 'Swedish Massage',
                'description' => 'Relaxing full-body massage with long, flowing strokes to relieve tension.',
                'price' => 80.00,
                'duration_minutes' => 60,
                'category' => 'massage',
                'is_active' => true,
            ],
            [
                'name' => 'Deep Tissue Massage',
                'description' => 'Therapeutic massage targeting deeper muscle layers to release chronic tension.',
                'price' => 90.00,
                'duration_minutes' => 60,
                'category' => 'massage',
                'is_active' => true,
            ],
            [
                'name' => 'Sports Massage',
                'description' => 'Massage designed for athletes to prevent and treat injuries, improve flexibility.',
                'price' => 85.00,
                'duration_minutes' => 60,
                'category' => 'massage',
                'is_active' => true,
            ],

            // Waxing Services
            [
                'name' => 'Eyebrow Wax',
                'description' => 'Precise eyebrow shaping and waxing for clean, defined brows.',
                'price' => 18.00,
                'duration_minutes' => 15,
                'category' => 'waxing',
                'is_active' => true,
            ],
            [
                'name' => 'Full Face Wax',
                'description' => 'Complete facial waxing including brows, lip, and chin.',
                'price' => 35.00,
                'duration_minutes' => 30,
                'category' => 'waxing',
                'is_active' => true,
            ],
            [
                'name' => 'Brazilian Wax',
                'description' => 'Complete bikini wax service for smooth, hair-free skin.',
                'price' => 55.00,
                'duration_minutes' => 45,
                'category' => 'waxing',
                'is_active' => true,
            ],

            // Other Services
            [
                'name' => 'Scalp Treatment',
                'description' => 'Therapeutic scalp treatment for dandruff, dryness, or oil control.',
                'price' => 40.00,
                'duration_minutes' => 30,
                'category' => 'other',
                'is_active' => true,
            ],
            [
                'name' => 'Hair Treatment',
                'description' => 'Deep conditioning treatment to restore moisture and shine to damaged hair.',
                'price' => 45.00,
                'duration_minutes' => 45,
                'category' => 'other',
                'is_active' => true,
            ],
            [
                'name' => 'Consultation',
                'description' => 'Professional consultation to discuss your hair and beauty goals.',
                'price' => 0.00,
                'duration_minutes' => 15,
                'category' => 'other',
                'is_active' => true,
            ],
        ];

        foreach ($stores as $store) {
            foreach ($services as $serviceData) {
                $service = Service::create(array_merge($serviceData, [
                    'store_id' => $store->id,
                ]));

                // Optionally attach some employees to services
                $employees = Employee::where('store_id', $store->id)->inRandomOrder()->take(rand(1, 3))->get();
                
                foreach ($employees as $employee) {
                    $expertiseLevels = ['beginner', 'intermediate', 'expert'];
                    $service->employees()->attach($employee->id, [
                        'expertise_level' => $expertiseLevels[array_rand($expertiseLevels)]
                    ]);
                }
            }
        }

        $this->command->info('Services seeded successfully!');
        $this->command->info('Total services created: ' . Service::count());
    }
}