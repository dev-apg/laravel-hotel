<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hotel>
 */
class HotelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => "Thornfield's Lodge Cotswolds",
            'address_line_1' => '42 Meadowbrook Lane',
            'address_line_2' => '',
            'city' => 'Chipping Norton',
            'county' => 'Oxfordshire',
            'postcode' => 'OX7 3RD',
            'country' => 'United Kingdom',
        ];
    }
}
