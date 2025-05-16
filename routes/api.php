<?php

use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\DriverController;
use App\Http\Controllers\API\StaticController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('authenticate', [UserController::class, 'authenticate']);
Route::post('users', [UserController::class, 'createUser']);
Route::get('countries', [StaticController::class, 'getCountries']);

Route::middleware('user.jwt')->group(function () {
    Route::get('cities', [StaticController::class, 'getCities']);
    Route::get('vehicules', [StaticController::class, 'getVehicules']);
    Route::post('drivers', [DriverController::class, 'createDriver']);
    Route::post('reservations', [CustomerController::class, 'saveReservation']);
    Route::post('trajets', [DriverController::class, 'createTrajet']);
    Route::get('trajets', [DriverController::class, 'getTrajets']);
    Route::get('trajets/search', [CustomerController::class, 'searchTrajets']);
});


