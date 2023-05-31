<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
#Users
#Houses
#Country
#City


// Create a User
Route::post('/users', [UserController::class, 'store']);
// Update a User
Route::put('/user/{id}', [UserController::class, 'update']);
// Get all Users
Route::get('/users', [UserController::class, 'index']);
// Delete a user
Route::delete('/user/{id}', [UserController::class, 'destroy']);


// Create a City
Route::post('/city', [CityController::class, 'store']);
// Update a City
Route::put('/city/{id}', [CityController::class, 'update']);
// Get all Cities
Route::get('/cities', [CityController::class, 'index']);
// Delete a City
Route::delete('/city/{id}', [CityController::class, 'destroy']);


// Create a Country
Route::post('/country', [CountryController::class, 'store']);
// Update a Country
Route::put('/country/{id}', [CountryController::class, 'update']);
// Get all Countries
Route::get('/countries', [CountryController::class, 'index']);
// Delete a Country
Route::delete('/country/{id}', [CountryController::class, 'destroy']);


// Create a House
Route::post('/house', [HouseController::class, 'store']);
// Update a House
Route::put('/house/{id}', [HouseController::class, 'update']);
// Get all Houses
Route::get('/houses', [HouseController::class, 'index']);
// Delete a House
Route::delete('/house/{id}', [HouseController::class, 'destroy']);
