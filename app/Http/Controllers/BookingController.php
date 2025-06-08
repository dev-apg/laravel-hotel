<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Rules\OccupancyRule;
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
        $searchRibbonProps = [
            'hotels' => Hotel::all(),
        ];
        return Inertia::render('home', compact('searchRibbonProps'));
    }

    /**
     * Display list of ancillaries
     */

    public function ancillaries(Request $request)
    {
        try {
            $validated = $request->validate([
                'hotel' => 'required|integer|exists:hotels,id',
                'rooms' => 'required|integer|min:1|max:6',
                'from' => 'required|date_format:Y-m-d|after_or_equal:today',
                'to' => 'required|date_format:Y-m-d|after:from',
                'adults' => ['required', 'string', new OccupancyRule(minPerRoom: 1, maxPerRoom: 2)],
                'children' => ['required', 'string', new OccupancyRule(minPerRoom: 0, maxPerRoom: 1)],
            ]);
        } catch (ValidationException $e) {
            return $this->redirectToHome('There was a problem with your request, please try again');
        }


        $hotelID = $request->input('hotel', 'no-hotel');
        $hotel = Hotel::with('ancillaries')->find($hotelID);

        $props = [
            // 'ancillaries' => $hotel->ancillaries,
            'hotel' => $hotel,
            // 'from' => $from,
            // 'to' => $to,
            // 'rooms' => $rooms,
            // 'adults' => $adults,
            // 'children' => $children,
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
