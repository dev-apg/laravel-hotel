<?php

namespace App\Http\Services;

use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class FetchRoomsService
{
    public function availableRooms(int $hotelId, Carbon $from, Carbon $to): Collection
    {

        if ($from >= $to) {
            throw new InvalidArgumentException('Check-in date must be before check-out date');
        }

        return Room::whereDoesntHave('bookings', function ($query) use ($from, $to) {
            $query->where(function ($inner) use ($from, $to) {
                $inner->where('from', '<', $to)->where('to', '>', $from);
            });
        })->where('hotel_id', $hotelId)->get();
    }
}
