<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [BookingController::class, 'index'])->name('home');
Route::get('/bookings/ancillaries', [BookingController::class, 'ancillaries'])->name('bookings.ancillaries');
Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
