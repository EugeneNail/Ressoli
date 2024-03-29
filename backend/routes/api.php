<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\LandParcelController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\StatisticsController;
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

Route::post("/signup", [AuthController::class, "store"]);
Route::post("/login", [AuthController::class, "login"]);
Route::get("/photos/{photo}", [PhotoController::class, "show"]);

Route::group(["middleware" => "auth:sanctum"], function () {
    Route::post("/logout", [AuthController::class, "logout"]);

    Route::post("/clients", [ClientController::class, "store"]);

    Route::post("/addresses", [AddressController::class, "store"]);

    Route::group(["prefix" => "land-parcels"], function () {
        Route::post("/", [LandParcelController::class, "store"]);
        Route::put("/{landParcel}", [LandParcelController::class, "update"]);
    });

    Route::group(["prefix" => "houses"], function () {
        Route::post("/", [HouseController::class, "store"]);
        Route::put("/{house}", [HouseController::class, "update"]);
    });

    Route::group(["prefix" => "apartments"], function () {
        Route::post("/", [ApartmentController::class, "store"]);
        Route::put("/{apartment}", [ApartmentController::class, "update"]);
    });

    Route::group(["prefix" => "applications"], function () {
        Route::post("/{applicables}", [ApplicationController::class, "store"]);
        Route::put("/{applicables}/{application}", [ApplicationController::class, "update"]);
        Route::patch("/{application}/activate", [ApplicationController::class, "activate"]);
        Route::patch("/{application}/archive", [ApplicationController::class, "archive"]);
        Route::get("/{id}", [ApplicationController::class, "show"]);
        Route::get("/", [ApplicationController::class, "index"]);
    });

    Route::post("/photos", [PhotoController::class, "store"]);

    Route::get("/options/{type}", OptionController::class);

    Route::get("/statistics", StatisticsController::class);
})->middleware("web");
