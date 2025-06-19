<?php

namespace Tests\Feature;

use App\Http\Services\AvailabilityCheck;
use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\TestWith;
use Tests\TestCase;

class AvailabilityCheckTest extends TestCase
{
    use RefreshDatabase;

    private AvailabilityCheck $sut;

    public function setUp(): void
    {
        parent::setUp();
        $this->sut = new AvailabilityCheck();
        $this->seedHotels();
        $this->seedRooms();
        $this->seedBookings();
    }

    private function seedHotels()
    {

        Hotel::factory()->create(['name' => 'Test Hotellll']);
    }

    private function seedRooms()
    {

        $rooms = [
            [
                'number' => '1a', // id 1
                'type' => 'single',
                'hotel_id' => 1
            ],
            [
                'number' => '1b', // id 2
                'type' => 'double',
                'hotel_id' => 1
            ],
            [
                'number' => '1c', // id 3
                'type' => 'twin',
                'hotel_id' => 1
            ],
        ];

        Room::factory()->createMany($rooms);
    }

    private function seedBookings() {}

    public function test_returns_true_when_rooom_not_booked(): void
    {

        $bookings = [];

        Booking::factory()->createMany($bookings);

        $booking = [
            'hotel_id' => 1,
            'from' => '2023-01-01', // Check-in date                        
            'to' => '2023-01-02', // Check-out date   
            'rooms' => [
                [
                    'adults' => 1,
                    'children' => 0,
                    'type' => 'single',
                ],
            ],
        ];

        $result = $this->sut->check($booking);

        $this->assertTrue($result);
    }

    public function test_returns_false_when_room_booked(): void
    {

        $singleRoom = Room::where('type', 'single')->first();

        $bookings = [
            [
                'room_id' => $singleRoom->id,
                'user_id' => 1,
                'hotel_id' => 1,
                'from' => '2023-01-01', // Check-in date                        
                'to' => '2023-01-02', // Check-out date
            ],
        ];

        Booking::factory()->createMany($bookings);

        $booking = [
            'hotel_id' => 1,
            'from' => '2023-01-01', // Check-in date                        
            'to' => '2023-01-02', // Check-out date   
            'rooms' => [
                [
                    'adults' => 1,
                    'children' => 0,
                    'type' => 'single',
                ],
            ],
        ];

        $result = $this->sut->check($booking);

        $this->assertFalse($result);
    }

    public function test_returns_true_if_existing_booking_ends_before_from_date(): void
    {

        $bookings = [
            [
                'room_id' => 1,
                'user_id' => 1,
                'hotel_id' => 1,
                'from' => '2022-12-30', // Check-in date                        
                'to' => '2022-12-31', // Check-out date
            ],
        ];

        Booking::factory()->createMany($bookings);

        $booking = [
            'hotel_id' => 1,
            'from' => '2023-01-01', // Check-in date                        
            'to' => '2023-01-02', // Check-out date   
            'rooms' => [
                [
                    'adults' => 1,
                    'children' => 0,
                    'type' => 'single',
                ],
            ],
        ];

        $result = $this->sut->check($booking);

        $this->assertTrue($result);
    }
}
