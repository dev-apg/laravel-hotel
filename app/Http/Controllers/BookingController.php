<?php

namespace App\Http\Controllers;

use App\Http\Services\FetchRoomsService;
use App\Models\Hotel;
use App\Rules\OccupancyRule;
use App\Rules\ValidateRoomsString;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display home page with search ribbon
     */
    public function index()
    {
        $bookingFormData = [
            'hotels' => Hotel::all(),
        ];
        return Inertia::render('home', compact('bookingFormData'));
    }

    /**
     * Display list of ancillaries
     */

    public function ancillaries(Request $request, FetchRoomsService $fetch)
    {
        try {
            $validated = $request->validate([
                'hotel_id' => 'required|integer|exists:hotels,id',
                'rooms' => ['required', new ValidateRoomsString(adults: ['min' => 1, 'max' => 2], children: ['min' => 0, 'max' => 1])],
                'from' => 'required|date_format:Y-m-d|after_or_equal:today',
                'to' => 'required|date_format:Y-m-d|after:from',
            ]);
        } catch (ValidationException $e) {
            return $this->redirectToHome('There was a problem with your request, please try again');
        }

        $availableRooms = $fetch->availableRooms($request->hotel_id, Carbon::parse($request->from), Carbon::parse($request->to));
        $hotel = Hotel::with('ancillaries')->find($request->hotel_id);

        $requestedRooms = explode('_', $request->rooms);

        if (count($requestedRooms) > count($availableRooms)) {
            $max = count($availableRooms);
            $roomText = $max > 1 ? 'rooms' : 'room';
            return $this->redirectToHome("Unfortunately, we only have $max $roomText available for your chosen dates");
        }

        $standard = $availableRooms->filter(function ($room) {
            return $room->type == 'standard';
        });

        $deluxe = $availableRooms->filter(function ($room) {
            return $room->type == 'deluxe';
        });

        $availableRoomsData = collect([]);

        foreach ($requestedRooms as $requested) {
            [$adults, $children] = explode('-', $requested);

            $available = null;
            if ($standard->count() > 0) {
                $available = $standard->shift();
            } elseif ($deluxe->count() > 0) {
                $available = $deluxe->shift();
            }

            // Safety check
            if ($available === null) {
                return $this->redirectToHome("Unable to allocate enough rooms for your request");
            }

            // Push as array, not Collection
            $availableRoomsData->push([
                'id' => $available->id,
                'adults' => $adults,
                'children' => $children,
                'type' => $available->type,
                'upgradeable' => false,
                'upgrade_requested' => false,
                'selected_ancillaries' => [],
                'available_ancillaries' => $hotel->ancillaries
            ]);
        }

        // Use map() to modify the collection items, and access as array
        $availableRoomsData = $availableRoomsData->map(function ($roomData) use ($deluxe) {
            if ($roomData['type'] == 'standard' && $deluxe->count() > 0) {
                $deluxe->shift();
                $roomData['upgradeable'] = true;
            }
            return $roomData;
        });

        $props = [
            'hotel' => $hotel,
            'rooms' => $request->rooms,
            'from' => $request->from,
            'to' => $request->to,
            'rooms_data' => $availableRoomsData
        ];

        return Inertia::render('ancillaries', compact('props'));
    }

    private function redirectToHome($message)
    {

        $searchRibbonProps = [
            'hotels' => Hotel::all(),
        ];
        return to_route('home', compact('searchRibbonProps'))->with('error', $message);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
