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
    Route::post('change_password', [UserController::class, 'change_password']);
    Route::post('users/profile', [UserController::class, 'update_profile']);
    Route::get('cities', [StaticController::class, 'getCities']);
    Route::get('vehicules', [StaticController::class, 'getVehicules']);
    Route::post('drivers', [DriverController::class, 'createDriver']);
    Route::post('drivers/photos', [DriverController::class, 'uploadVoiture']);
    Route::post('reservations', [CustomerController::class, 'saveReservation']);
    Route::get('reservations/trajet/{id}', [DriverController::class, 'getReservations']);
    Route::get('reservations', [CustomerController::class, 'getReservations']);
    Route::post('trajets', [DriverController::class, 'createTrajet']);
    Route::get('trajets', [DriverController::class, 'getTrajets']);
    Route::get('trajets/search', [CustomerController::class, 'searchTrajets']);
    Route::post('users/photo', [UserController::class, 'uploadPhoto']);
});


