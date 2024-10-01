<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InputController;
use App\Http\Controllers\OutputController;

Route::get('/input', [InputController::class, 'store']);
Route::post('/input', [InputController::class, 'store']);
Route::get('/hours', [OutputController::class, 'getHourlyLoad']);
Route::get('/days', [OutputController::class, 'getDailyLoad']);

