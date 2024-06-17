<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;

Route::get('/team-management', function () {
    return view('team-management');
})->name('team.management');

Route::post('/check-players', [PlayerController::class, 'checkPlayers'])->name('team.checkPlayers');
Route::post('/save-team', [PlayerController::class, 'saveTeam'])->name('team.save');

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
