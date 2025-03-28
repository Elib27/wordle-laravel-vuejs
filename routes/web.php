<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Wordle');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('api/guessword/{id}', [WordleController::class, 'checkWord']);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
