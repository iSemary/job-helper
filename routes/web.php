<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\EmailCredentialController;
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

        Route::prefix('user')->name('user.')->group(function () {
            Route::get('edit', [UserController::class, 'edit'])->name('profile.edit');
            Route::post('update', [UserController::class, 'update'])->name('profile.update');

            Route::get('email-credentials/edit', [EmailCredentialController::class, 'edit'])->name('email-credentials.edit');
            Route::post('email-credentials/update', [EmailCredentialController::class, 'update'])->name('email-credentials.update');
            Route::post('email-credentials/test',  [EmailCredentialController::class, 'test'])->name('email-credentials.test');
       
        });

        Route::get('companies/excel', [CompanyController::class, "importExcel"])->name('companies.excel.import');
        Route::post('companies/excel/store', [CompanyController::class, "storeExcel"])->name('companies.excel.store');
        Route::resources(['companies' => CompanyController::class]);

        Route::prefix('generator')->name('generator.')->group(function () {
            Route::get('cover-letter', [GeneratorController::class, "coverLetter"])->name('cover-letter');
            Route::get('motivation-message', [GeneratorController::class, "motivationMessage"])->name('motivation-message');
            Route::get('company', [GeneratorController::class, 'company'])->name('company');

            Route::post("cover-letter/pdf", [GeneratorController::class, "downloadCoverLetter"])->name("cover-letter.download");
        });

        Route::get('apply', [EmailController::class, 'index'])->name('apply');
    });
});
