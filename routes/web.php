<?php

use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\LogoutController;
use App\Http\Controllers\Web\Auth\RegisterController;
use App\Http\Controllers\Web\Backend\DashboardController;
use App\Http\Controllers\Web\Backend\PatientController;
use App\Http\Controllers\Web\Backend\UserProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->middleware('is.guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('auth.login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('auth.authenticate');
    Route::get('/register', [RegisterController::class, 'index'])->name('auth.register');
    Route::post('/register', [RegisterController::class, 'store'])->name('auth.register.store');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected by Auth)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->middleware('is.auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('auth.logout');
});

Route::prefix('admin')->middleware('is.auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('be.dashboard.index');

    Route::get('/user-profile', [UserProfileController::class, 'show'])->name('be.user_profile.show');
    Route::put('/user-profile', [UserProfileController::class, 'update'])->name('be.user_profile.update');

    Route::prefix('patient')->name('be.patient.')->group(function () {
        Route::get('/', [PatientController::class, 'index'])->name('index');
        Route::get('/create', [PatientController::class, 'create'])->name('create');
        Route::post('/', [PatientController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PatientController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PatientController::class, 'update'])->name('update');
        Route::delete('/{id}', [PatientController::class, 'destroy'])->name('destroy');

        // AJAX detail endpoint
        Route::get('/{id}', [PatientController::class, 'show'])->name('show');
    });

});