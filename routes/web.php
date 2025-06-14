<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [BookingController::class, 'index'])->name('home');
Route::get('/ancillaries', [BookingController::class, 'ancillaries'])->name('ancillaries');
Route::post('/ancillaries', [BookingController::class, 'ancillaries'])->name('ancillaries');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
