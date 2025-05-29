<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $hotels = [
            [
                'name' => "Thornfield's Lodge Cotswolds",
                'address_line_1' => '42 Meadowbrook Lane',
                'address_line_2' => '',
                'city' => 'Chipping Norton',
                'county' => 'Oxfordshire',
                'postcode' => 'OX7 3RD',
                'country' => 'United Kingdom',
            ],
            [
                'name' => "Thornfield's Lodge Highlands",
                'address_line_1' => '18 Glen View Road',
                'address_line_2' => '',
                'city' => 'Pitlochry',
                'county' => 'Perthshire',
                'postcode' => 'PH16 2AB',
                'country' => 'United Kingdom',
            ],
            [
                'name' => "Thornfield's Lodge Snowdonia",
                'address_line_1' => '7 Moutain View Terrace',
                'address_line_2' => '',
                'city' => 'Betws-y-Coed',
                'county' => 'Conwy',
                'postcode' => 'LL24 8PQ',
                'country' => 'United Kingdom',
            ],
            [
                'name' => "Thornfield's Lodge Causeway",
                'address_line_1' => '25 Coastal Drive',
                'address_line_2' => '',
                'city' => 'Bushmills',
                'county' => 'County Antrim',
                'postcode' => 'BT57 4NL',
                'country' => 'United Kingdom',
            ],
        ];

        foreach ($hotels as $hotel) {
            Hotel::create($hotel);
        }
    }
}
