<?php

use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('subjects', [SubjectController::class, 'index'])->middleware(['auth', 'verified'])->name('subjects');

Route::post('subjects', [SubjectController::class, 'store'])->middleware(['auth', 'verified'])->name('subjects.store');

require __DIR__ . '/settings.php';
