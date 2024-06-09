<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;

Route::post('/check-players', [PlayerController::class, 'checkPlayers']);
Route::get('/', function () {
    return view('welcome');
});
