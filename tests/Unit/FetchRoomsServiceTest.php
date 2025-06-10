<?php

namespace Tests\Unit;

use App\Http\Services\FetchRoomsService;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Database\Seeders\HotelsSeeder;
use Database\Seeders\RoomsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FetchRoomsServiceTest extends TestCase
{

    use RefreshDatabase;

    private FetchRoomsService $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new FetchRoomsService();
    }

    public function test_two_rooms_returned()
    {

        $this->seed([HotelsSeeder::class, RoomsSeeder::class]);

        $twoWeeksFromToday = Carbon::now()->addDays(14);
        $threeWeeksFromToday = Carbon::now()->addDays(21);

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

        $from = Carbon::now()->addDays(14);
        $to = Carbon::now()->addDays(21);

        $rooms = $this->sut->fetchAvailable(hotelId: 1, from: $from, to: $to);

        var_dump(['rooms' => $rooms]);

        $this->assertEquals(2, $rooms->count());
    }
}
