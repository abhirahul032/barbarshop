<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Store\AuthController;
use App\Http\Controllers\Store\EmployeeController;
use App\Http\Controllers\Store\ServiceController;

Route::prefix('store')
    ->name('store.')
    ->middleware('web')
    ->group(function () {

        // Admin Login
        Route::get('login', [AuthController::class, 'loginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');

        // Protected Admin Routes
        Route::middleware('auth:store')->group(function () {

            Route::get('dashboard', function () {
                return view('store.dashboard');
            })->name('dashboard');

            Route::resource('employees', EmployeeController::class);    
            Route::resource('services', ServiceController::class);

            // Logout
            Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        });

    });
