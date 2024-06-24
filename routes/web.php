<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchReportController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\TeamStatisticsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/team-management', [PlayerController::class, 'showTeamManagement'])->name('team.management');
Route::get('/match-details', function () {
    return view('match-details');
});

Route::get('/team/{teamId}/matches', [PlayerController::class, 'showMatchDetails'])->name('team.matches');
Route::get('/teams', [PlayerController::class, 'showUserTeams'])->name('teams.index');
Route::delete('/teams/{team}', [PlayerController::class, 'destroy'])->name('teams.destroy');

Route::post('/check-players', [PlayerController::class, 'checkPlayers'])->name('team.checkPlayers');
Route::post('/save-team', [PlayerController::class, 'saveTeam'])->name('team.save');
Route::get('/team/{teamId}/statistics', [TeamStatisticsController::class, 'getTeamStatistics'])->name('team.statistics');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');
Route::get('/profile', [ProfileController::class, 'index'])->middleware(['auth'])->name('profile');

Route::view('/', 'welcome');

Route::post('/match-report', [MatchReportController::class, 'generateReport'])->name('match.report');

require __DIR__.'/auth.php';
