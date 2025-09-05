<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/events', [EventController::class, 'index']);
    Route::post('/events', [EventController::class, 'store']);
    Route::post('/events/{id}/join', [EventController::class, 'join']);
    Route::post('/events/{id}/leave', [EventController::class, 'leave']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
});
