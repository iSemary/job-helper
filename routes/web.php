<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'welcome']);
Route::get('register', [DashboardController::class, 'register']);
Route::get('login', [DashboardController::class, 'register']);
