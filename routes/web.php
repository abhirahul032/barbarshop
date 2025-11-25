<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/store/api/calendar-events', [\App\Http\Controllers\Store\ApiController::class, 'calendarEvents'])
    ->name('store.api.calendar-events');
require __DIR__ . '/admin.php';
require __DIR__ . '/store.php';