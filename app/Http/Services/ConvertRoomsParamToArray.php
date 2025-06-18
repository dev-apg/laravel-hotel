<?php

namespace App\Http\Services;

use App\Models\Hotel;

class ConvertRoomsParamToArray
{
    public function toArray(array $requested): array

    {

        $hotel = Hotel::findOrFail($requested['hotel_id']);

        $arr = [
            'hotel_id' => $requested['hotel_id'],
            'hotel' => $hotel->name,
            'from' => $requested['from'],
            'to' => $requested['to'],
            'rooms' => [],
            'extras' => $hotel->extras,
        ];

        $rooms = explode('_', $requested['rooms']);

        foreach ($rooms as $room) {
            [$adults, $children] = explode('-', $room);

            $arr['rooms'][] = [
                'adults' => $adults,
                'children' => $children,
            ];
        }

        return $arr;
    }
}
