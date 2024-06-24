<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchReportController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamStatisticsController;

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
Route::get('/team/{teamId}/statistics', [TeamStatisticsController::class, 'getTeamStatistics']);

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::post('/match-report', [MatchReportController::class, 'generateReport'])->name('match.report');


require __DIR__.'/auth.php';
