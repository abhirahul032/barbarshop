<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\StoreController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\BusinessTypeController;
use App\Http\Controllers\Admin\GlobalServiceController;
use App\Http\Controllers\Admin\CountryController;
Route::prefix('admin')
    ->name('admin.')
    ->middleware('web')
    ->group(function () {

        // Admin Login
        Route::get('login', [AuthController::class, 'loginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.submit');
        
        
         Route::get('/', function () {
            return auth()->guard('admin')->check() 
                ? redirect()->route('admin.dashboard')
                : redirect()->route('admin.login');
        })->name('index');
        
        // Protected Admin Routes
       Route::middleware('admin.auth')->group(function () {
            Route::get('dashboard', function () {                
                return view('admin.dashboard');
            })->name('dashboard');
            //  CRUD
            Route::resource('store', StoreController::class);
            Route::resource('package', PackageController::class);
            Route::resource('business-type', BusinessTypeController::class);
            Route::resource('global-service', GlobalServiceController::class);
            Route::resource('countries', CountryController::class);
            // Logout
            Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        });

    });
