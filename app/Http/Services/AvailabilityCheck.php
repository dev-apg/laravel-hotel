<?php

namespace App\Http\Services;

use App\Models\Room;
use Carbon\Carbon;
use InvalidArgumentException;

class AvailabilityCheck
{
    public function check(array $booking): bool
    {

        $hotelId = $booking['hotel_id'];
        $from = $booking['from'];
        $to = $booking['to'];

        $from = Carbon::parse($from);
        $to = Carbon::parse($to);

        if ($from >= $to) {
            throw new InvalidArgumentException('Check-in date must be before check-out date');
        }

        $required = [
            'single' => 0,
            'double' => 0,
            'twin' => 0,
            'family' => 0,
            'accessible' => 0,
        ];

        $available = [
            'single' => 0,
            'double' => 0,
            'twin' => 0,
            'family' => 0,
            'accessible' => 0,
        ];

        foreach ($booking['rooms'] as $room) {
            $required[$room['type']]++;
        }

        foreach ($required as $type => $count) {
            if ($count) {
                $available[$type] = Room::wheredoesnthave('bookings', function ($query) use ($from, $to) {
                    $query->where(function ($inner) use ($from, $to) {
                        $inner->where('from', '<', $to)->where('to', '>', $from);
                    });
                })->where('hotel_id', $hotelId)->where('type', $type)->count();
            }
        }

        foreach ($required as $type => $count) {
            if ($available[$type] < $count) {
                return false;
            }
        }

        return true;
    }
}
