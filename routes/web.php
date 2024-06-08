<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('register.show');
Route::post('/register', [UserController::class, 'store'])->name('register.store');
Route::post('/login-submit', [UserController::class, 'login'])->name('login.submit');
Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('welcome');
});