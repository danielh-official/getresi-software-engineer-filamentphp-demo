<?php

use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->name('api.')->group(function () {
    Route::apiResource('properties', PropertyController::class)
        ->except(['update']);
});
