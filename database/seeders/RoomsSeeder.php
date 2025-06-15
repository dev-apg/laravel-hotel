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
                'type' => 'single',
            ],
            [
                'number' => '1b',
                'type' => 'double',
            ],
            [
                'number' => '1c',
                'type' => 'twin',
            ],
            [
                'number' => '1d',
                'type' => 'family',
            ],
            [
                'number' => '1e',
                'type' => 'accessible',
            ],
            [
                'number' => '2a',
                'type' => 'single',
            ],
            [
                'number' => '2b',
                'type' => 'double',
            ],
            [
                'number' => '2c',
                'type' => 'twin',
            ],
            [
                'number' => '2d',
                'type' => 'family',
            ],
            [
                'number' => '2e',
                'type' => 'accessible',
            ],
            [
                'number' => '3a',
                'type' => 'single',
            ],
            [
                'number' => '3b',
                'type' => 'double',
            ],
            [
                'number' => '3c',
                'type' => 'twin',
            ],
            [
                'number' => '3d',
                'type' => 'family',
            ],
            [
                'number' => '3e',
                'type' => 'accessible',
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
