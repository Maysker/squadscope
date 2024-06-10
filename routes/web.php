<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\PlayerController;

Route::get('auth/xbox', [SocialAuthController::class, 'redirectToXbox']);
Route::get('auth/xbox/callback', [SocialAuthController::class, 'handleXboxCallback']);
Route::get('auth/steam', [SocialAuthController::class, 'redirectToSteam']);
Route::get('auth/steam/callback', [SocialAuthController::class, 'handleSteamCallback']);

Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register.show');
Route::post('/register', [UserController::class, 'store'])->name('register.store');
Route::post('/login-submit', [UserController::class, 'login'])->name('login.submit');
Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');

Route::post('/check-players', [PlayerController::class, 'checkPlayers']);
Route::get('/', function () {
    return view('welcome');
});