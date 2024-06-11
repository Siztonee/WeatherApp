<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WeatherController::class, 'index'])->name('weather');
Route::post('/', [WeatherController::class, 'getWeather']);
