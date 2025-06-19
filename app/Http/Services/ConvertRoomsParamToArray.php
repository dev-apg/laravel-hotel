<?php

namespace App\Http\Services;

use App\Models\Hotel;

class ConvertRoomsParamToArray
{
    public function toArray(array $requested): array
    {

        $hotel = Hotel::with('extras')->findOrFail($requested['hotel_id']);

        $arr = [
            'hotel_id' => $requested['hotel_id'],
            'hotel' => $hotel,
            'from' => $requested['from'],
            'to' => $requested['to'],
            'rooms' => [],
        ];

        $rooms = explode('_', $requested['rooms']);

        $extrasArray = [];

        foreach ($hotel->extras as $extra) {
            $extrasArray[] = [
                'id' => $extra->id,
                'name' => $extra->name,
                'description' => $extra->description,
                'pricing_type' => $extra->pricing_type,
                'price' => $extra->pivot->price,
                'selected' => false
            ];
        }

        $roomIds = [];

        foreach ($rooms as $room) {
            [$adults, $children, $type] = explode('-', $room);
            do {
                $roomId = uniqid('tempid_', true);
            } while (in_array($roomId, $roomIds));

            $roomIds[] = $roomId;

            $arr['rooms'][] = [
                'id' => $roomId,
                'adults' => $adults,
                'children' => $children,
                'type' => $type,
                'extras' => $extrasArray
            ];
        }

        return $arr;
    }
}
