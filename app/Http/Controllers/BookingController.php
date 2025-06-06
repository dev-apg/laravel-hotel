<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
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
        // try {
        $validated = $request->validate([
            'hotel' => 'required|exists:hotels,id',
            'rooms' => 'required|integer|min:1|max:6',
            'from' => 'required|date_format:Y-m-d|after_or_equal:today',
            'to' => 'required|date_format:Y-m-d|after:checkin',
            'adults' => 'required|string|min:1|max:50',
            'children' => 'required|string|min:1|max:50',
        ]);
        // } catch (ValidationException $e) {
        //     return back()->withErrors([
        //         'general' => 'There was a problem with your request, please make another selection'
        //     ]);
        // }

        dump($request->fullUrl());

        $hotelID = $request->input('hotel', 'no-hotel');
        $checkin = $request->input('checkin', 'no-checkin');
        $checkout = $request->input('checkout', 'no-checkout');
        $rooms = $request->input('rooms', 'no-rooms');
        $adults = $request->input('adults', 'no-adults');
        $children = $request->input('children', 'no-adults');

        $hotel = Hotel::with('ancillaries')->find($hotelID);

        $props = [
            'ancillaries' => $hotel->ancillaries,
            'hotel' => $hotel,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'rooms' => $rooms,
            'adults' => $adults,
            'children' => $children,
        ];

        return Inertia::render('ancillaries', compact('props'));
    }

    private function returnHomeWithMessage()
    {

        $searchRibbonProps = [
            'hotels' => Hotel::all(),
        ];
        return to_route('home', compact('searchRibbonProps'))->with('error', 'there was an errror');
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
