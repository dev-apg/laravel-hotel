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
            'hotel' => $hotel->name,
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
                'price' => $extra->pivot->price
            ];
        }

        foreach ($rooms as $room) {
            [$adults, $children, $type] = explode('-', $room);

            $arr['rooms'][] = [
                'adults' => $adults,
                'children' => $children,
                'type' => $type,
                'extras' => $extrasArray,
                'selected_extras' => [],
            ];
        }

        return $arr;
    }
}
