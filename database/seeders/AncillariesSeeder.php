<?php

namespace Database\Seeders;

use App\Models\Ancillary;
use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AncillariesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ancillaries = [
            [
                'name' => 'premium wifi',
                'pricing_type' => 'per_stay',
                'description' => 'High-speed internet access with dedicated bandwidth for seamless streaming, video calls, and business needs. Perfect for guests requiring reliable connectivity.'
            ],
            [
                'name' => 'premium channel selection',
                'pricing_type' => 'per_stay',
                'description' => 'Enjoy access to Premier Sports, premium movie channels, and exclusive entertainment content on your in-room television. Relax with the latest films and live sporting events.'
            ],
            [
                'name' => 'coffee machine',
                'pricing_type' => 'per_stay',
                'description' => 'Start your morning right with our in-room Nespresso coffee machine, complete with a selection of premium coffee pods and fresh milk service.'
            ],
            [
                'name' => 'Lodge Fitness Suite',
                'pricing_type' => 'per_stay',
                'description' => 'Maintain your fitness routine in our luxurious Lodge Fitness Suite, featuring state-of-the-art cardio equipment, premium free weights, and professional-grade strength training machines. Open 24/7 for guests, with complimentary towels, chilled water, and energizing sports drinks. Personal training sessions available upon request.'
            ],
            [
                'name' => 'Lodge Pool and Spa',
                'pricing_type' => 'per_person_per_day',
                'description' => "Dive into relaxation at our heated indoor swimming pool, complete with panoramic countryside views through floor-to-ceiling windows. Enjoy complimentary poolside towels, luxury sun loungers, and our signature cucumber-infused water. Pool butler service available for that extra touch of indulgence - because why shouldn't you have your champagne delivered poolside?"
            ],
        ];

        foreach ($ancillaries as $ancillary) {
            Ancillary::create($ancillary);
        }

        $hotels = Hotel::all();

        foreach ($hotels as $hotel) {
            for ($x = 1; $x < 4; $x++) {
                $hotel->ancillaries()->attach([
                    [
                        'ancillary_id' => $x,
                        'price' => 10.99,
                    ]
                ]);
            }
        }
    }
}
