<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\PlanetController;
use App\Http\Controllers\SpeciesController;
use App\Http\Controllers\StarShipController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('signup', [AuthController::class, 'signup']);
Route::post('signin', [AuthController::class, 'signin']);

Route::middleware('auth:api')->group(function () {
    Route::put('users/me', [UserController::class, 'updateMe']);
    Route::get('films', [FilmController::class, 'getFilmsAssociatedWithCurrentUser']);
    Route::get('films/{id}', [FilmController::class, 'getFilmById']);
    Route::get('planets', [PlanetController::class, 'getPlanetsAssociatedWithCurrentUser']);
    Route::get('planets/{id}', [PlanetController::class, 'getPlanetById']);
    Route::get('starships', [StarShipController::class, 'getStarShipsAssociatedWithCurrentUser']);
    Route::get('starships/{id}', [StarShipController::class, 'getStarShipById']);
    Route::get('species', [SpeciesController::class, 'getSpeciesAssociatedWithCurrentUser']);
    Route::get('species/{id}', [SpeciesController::class, 'getSpeciesById']);
    Route::get('vehicles', [VehicleController::class, 'getVehiclesAssociatedWithCurrentUser']);
    Route::get('vehicles/{id}', [VehicleController::class, 'getVehicleById']);
});
