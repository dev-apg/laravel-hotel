<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [BookingController::class, 'index'])->name('home');
Route::get('bookings/create-session', [BookingController::class, 'createBookingSession'])->name('bookings.create-booking-session');
Route::get('/bookings/upgrade/{session_token}', [BookingController::class, 'upgrade'])->name('bookings.upgrade');
Route::get('/bookings/extras/{session_token}', [BookingController::class, 'extras'])->name('bookings.extras');
Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
