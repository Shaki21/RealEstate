<?php

use App\Http\Controllers\AuthController;
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


// Create a User
Route::post('/users', [UserController::class, 'store']);
// Get a single user
Route::get('/user/{id}', [UserController::class, 'getUserById']);//->middleware('auth:sanctum');
// Get all Users
Route::get('/users', [UserController::class, 'index']);
// Update a User
Route::put('/user/{id}', [UserController::class, 'update']);//->middleware('auth:sanctum', 'is_admin');
// Delete a user
Route::delete('/user/{id}', [UserController::class, 'destroy']);//->middleware('auth:sanctum', 'is_admin');


// Create a City
Route::post('/city', [CityController::class, 'store']);//->middleware('auth:sanctum', 'is_admin');
// Get a single city
Route::get('/city/{id}', [CityController::class, 'getCityById']);//->middleware('auth:sanctum');
// Get all Cities
Route::get('/cities', [CityController::class, 'index']);
// Update a City
Route::put('/city/{id}', [CityController::class, 'update']);//->middleware('auth:sanctum', 'is_admin');
// Delete a City
Route::delete('/city/{id}', [CityController::class, 'destroy']);//->middleware('auth:sanctum', 'is_admin');


// Create a Country
Route::post('/country', [CountryController::class, 'store']);//->middleware('auth:sanctum', 'is_admin');
// Get a single country
Route::get('/country/{id}', [CountryController::class, 'getCountryById']);//->middleware('auth:sanctum');
// Get all Countries
Route::get('/countries', [CountryController::class, 'index']);
// Update a Country
Route::put('/country/{id}', [CountryController::class, 'update']);//->middleware('auth:sanctum', 'is_admin');
// Delete a Country
Route::delete('/country/{id}', [CountryController::class, 'destroy']);//->middleware('auth:sanctum', 'is_admin');


// Create a House
Route::post('/house', [HouseController::class, 'store']);//->middleware('auth:sanctum', 'is_admin');
// Get a single house
Route::get('/house/{id}', [HouseController::class, 'getHouseById']);//->middleware('auth:sanctum');
// Get all Houses
Route::get('/houses', [HouseController::class, 'index']);
// Update a House
Route::put('/house/{id}', [HouseController::class, 'update']);//->middleware('auth:sanctum');
// Delete a House
Route::delete('/house/{id}', [HouseController::class, 'destroy']);//->middleware('auth:sanctum');


// Auth Routes
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    // Get authenticated user
    Route::get('user', [AuthController::class, 'user'])->middleware('auth:sanctum');
    // Update authenticated user
    Route::put('/user', [AuthController::class, 'update'])->middleware('auth:sanctum');

    // Admin methods
    // Get All users method for Admin
    Route::get('/users', [AuthController::class, 'allUsers'])->middleware('auth:sanctum', 'is_admin');
    // Update User method for Admin
    Route::put('/users/{user}', [AuthController::class, 'adminUpdateUser'])->middleware('auth:sanctum', 'is_admin');
    // Delete User method for Admin
    Route::delete('/users/{user}', [AuthController::class, 'destroy'])->middleware('auth:sanctum', 'is_admin');
});
