<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $twoWeeksFromToday = Carbon::now()->addDays(14)->format('Y-m-d');
        $threeWeeksFromToday = Carbon::now()->addDays(21)->format('Y-m-d');

        $hotel1Rooms = Room::where('hotel_id', 1)->get();

        $roomsToBook =  $hotel1Rooms->count() - 2;

        for ($x = 0; $x < $roomsToBook; $x++) {
            Booking::create([
                'hotel_id' => 1,
                'room_id' => $hotel1Rooms[$x]->id,
                'user_id' => 1,
                'from' => $twoWeeksFromToday,
                'to' => $threeWeeksFromToday,
            ]);
        }
    }
}
