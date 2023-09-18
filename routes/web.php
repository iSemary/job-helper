<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GeneratorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'welcome']);
Route::get('register', [DashboardController::class, 'register']);
Route::get('login', [DashboardController::class, 'register']);


Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('register', [AuthController::class, 'register'])->name('auth.register');
Route::get('logout', [AuthController::class, 'logout'])->name('auth.logout');


Route::middleware(['auth'])->group(function () {

    Route::prefix('panel')->name('panel.')->group(function () {
        Route::get('home', [DashboardController::class, 'home'])->name('home');
        Route::get('user/edit', [UserController::class, 'edit'])->name('user.profile');
        Route::post('user/update', [UserController::class, 'update'])->name('user.profile');

        Route::resources(['companies' => CompanyController::class]);

        Route::prefix('generator')->name('generator.')->group(function () {
            Route::get('cover-letter', [GeneratorController::class, "coverLetter"])->name('cover-letter');
            Route::get('motivation-message', [GeneratorController::class, "motivationMessage"])->name('motivation-message');
        });
    });
});
