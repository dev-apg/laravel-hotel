<?php

namespace App\Http\Controllers;

use App\Http\Services\AvailabilityCheck;
use App\Http\Services\ConvertRoomsParamToArray;
use App\Http\Services\FetchRoomsService;
use App\Models\Booking;
use App\Models\BookingSession;
use App\Models\Hotel;
use App\Rules\ValidateRoomsParam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use PhpParser\Node\Stmt\TryCatch;

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
     * Display list of extras
     */

    public function createBookingSession(Request $request, ConvertRoomsParamToArray $convert, AvailabilityCheck $availability)
    {
        try {
            $validated = $request->validate([
                'hotel_id' => 'required|integer|exists:hotels,id',
                'rooms' => ['required', new ValidateRoomsParam(adults: ['min' => 1, 'max' => 2], children: ['min' => 0, 'max' => 1])],
                'from' => 'required|date_format:Y-m-d|after_or_equal:today',
                'to' => 'required|date_format:Y-m-d|after:from',
            ]);
        } catch (ValidationException $e) {
            return $this->redirectToHome('There was a problem with your request, please try again');
        }

        // 1) TURN QUERY PARAM INTO ARRAY

        try {
            $bookingDetails = $convert->toArray($validated);
        } catch (\Throwable $th) {
            return $this->redirectToHome('There was a problem with your request, please try again');
        }

        // 2) CHECK AVAILABILITY 

        try {
            if (!$availability->check($bookingDetails)) {
                return $this->redirectToHome("I'm sorry but these rooms are not available for your chosen dates");
            }
        } catch (\Throwable $th) {
            return $this->redirectToHome('There was a problem with your request, please try again');
        }

        // 3) ADD SEARCH TO SESSION

        do {
            $sessionToken = Str::random(10);
        } while (BookingSession::where('session_token', $sessionToken)->exists());

        BookingSession::create([
            'session_token' => $sessionToken,
            'booking_data' => json_encode($bookingDetails),
            'expires_at' => Carbon::now()->addMinutes(15),
        ]);

        return redirect()->route('bookings.extras', ['session_token' => $sessionToken]);
    }

    public function extras(Request $request, string $session_token, AvailabilityCheck $availability)
    {
        $bookingDetails = BookingSession::where('session_token', $session_token)->first()->booking_data;
        return Inertia::render('extras', compact('bookingDetails'));
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
