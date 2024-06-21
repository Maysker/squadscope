<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;

Route::get('/team-management', function () {
    return view('team-management');
})->name('team.management');

Route::get('/match-details', function () {
    return view('match-details');
});

Route::get('/team/{teamId}/matches', [PlayerController::class, 'showMatchDetails'])->name('team.matches');
Route::get('/team-management', [PlayerController::class, 'showTeamManagement'])->name('team.management');
Route::get('/teams', [PlayerController::class, 'showUserTeams'])->name('teams.index');
Route::delete('/teams/{team}', [PlayerController::class, 'destroy'])->name('teams.destroy');


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
