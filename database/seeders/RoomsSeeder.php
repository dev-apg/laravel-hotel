<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $hotelsNum = count(Hotel::all());

        $rooms = [
            [
                'number' => '1a',
                'type' => 'standard',
            ],
            [
                'number' => '1b',
                'type' => 'standard',
            ],
            [
                'number' => '1c',
                'type' => 'standard',
            ],
            [
                'number' => '2a',
                'type' => 'standard',
            ],
            [
                'number' => '2b',
                'type' => 'standard',
            ],
            [
                'number' => '2c',
                'type' => 'deluxe',
            ],
            [
                'number' => '2d',
                'type' => 'deluxe',
            ],
            [
                'number' => '3a',
                'type' => 'standard',
            ],
            [
                'number' => '3b',
                'type' => 'standard',
            ],
            [
                'number' => '3c',
                'type' => 'deluxe',
            ],
            [
                'number' => '3d',
                'type' => 'deluxe',
            ],
        ];

        for ($i = 1; $i <= $hotelsNum; $i++) {
            foreach ($rooms as $room) {
                Room::create(
                    [
                        'number' => $room['number'],
                        'type' => $room['type'],
                        'hotel_id' => $i
                    ]
                );
            }
        }
    }
}
