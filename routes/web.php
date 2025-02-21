<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PollController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/poll', [PollController::class, 'index'])->name('poll');
    Route::post('/poll', [PollController::class, 'create'])->name('poll.create');
    Route::get('/poll', [PollController::class, 'edit'])->name('poll.edit');
    Route::patch('/poll', [PollController::class, 'update'])->name('poll.update');
    Route::delete('/poll', [PollController::class, 'destroy'])->name('poll.destroy');
});

require __DIR__.'/auth.php';
