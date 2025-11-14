<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\BusinessTypeController;
Route::prefix('admin')
    ->name('admin.')
    ->middleware('web')
    ->group(function () {

        // Admin Login
        Route::get('login', [AuthController::class, 'loginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');

        // Protected Admin Routes
        Route::middleware('auth:admin')->group(function () {

            Route::get('dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard');

            //  CRUD
            Route::resource('store', StoreController::class);
            Route::resource('package', PackageController::class);
            Route::resource('business-type', BusinessTypeController::class);

            // Logout
            Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        });

    });
