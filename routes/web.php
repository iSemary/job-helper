<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'welcome']);
Route::get('register', [DashboardController::class, 'register']);
Route::get('login', [DashboardController::class, 'register']);


Route::middleware(['auth'])->group(function () {
    Route::get('home', [DashboardController::class, 'home'])->name('home');
});


Route::post('register', [DashboardController::class, 'register']);
Route::post('login', [DashboardController::class, 'register']);
