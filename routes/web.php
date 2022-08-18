<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'showCurrentUser']);
    Route::put('/', [UserController::class, 'updateCurrentUser']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->prefix('client')->group(function () {
    Route::get('/', [ClientController::class, 'showClients']);
    Route::post('/import', [ClientController::class, 'importClients']);
    Route::get('/infos', [ClientController::class, 'getClientsInfo']);
});
